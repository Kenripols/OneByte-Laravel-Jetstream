<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\QrPlate;
use App\Models\Pet;
use App\Services\QrAssignmentService;

class QrPlateController extends Controller
{
    public function index()
    {   
        $QrPlates = QrPlate::whereHas('pet.owner', function ($query) {
            $query->where('user_id', Auth::id());
        })->paginate(10);

        return view('owner.qrplates.index', compact('QrPlates'));
    }

    public function create(Request $request)
    {   
        $this->authorize('create', QrPlate::class);

        $pets = Pet::with(['breed', 'owner'])
            ->whereHas('owner', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->paginate(10);

        $user = Auth::user();
        $qr = null;

        // QR pendiente
        if ($user->claimed_qr_id) {
            $qr = QrPlate::find($user->claimed_qr_id);

            if (!$qr) {
                $user->update(['claimed_qr_id' => null]);
            }
        }
        // QR por query
        elseif ($request->has('qr')) {
            $qr = QrPlate::where('code', $request->qr)->first();

            if ($qr && $qr->owner_user_id && $qr->owner_user_id !== $user->id) {
                abort(403);
            }
        }

        return view('owner.qrplates.create', compact('pets', 'qr'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:qr_plates,code',
            'pet_id' => 'nullable|exists:pets,id',

            'new_name' => 'required_without:pet_id',
            'new_bDate' => 'nullable|date',
            'new_breed_id' => 'nullable|exists:breeds,id',
        ]);

        $user = Auth::user();

        $qr = QrPlate::where('code', $request->code)->firstOrFail();

        // mascota
        if ($request->pet_id) {
            $pet = Pet::where('id', $request->pet_id)
                ->whereHas('owner', fn($q) => $q->where('user_id', $user->id))
                ->firstOrFail();
        } else {
            $pet = Pet::create([
                'name' => $request->new_name,
                'bDate' => $request->new_bDate,
                'breed_id' => $request->new_breed_id,
                'owner_id' => $user->id,
            ]);
        }

        // validaciones QR
        if ($qr->pet_id !== null) {
            return back()->with('error', 'El QR ya está asignado.');
        }

        if ($qr->status === QrPlate::STATUS_GENERATED) {
            return back()->with('error', 'El QR aún no está disponible.');
        }

        if (in_array($qr->status, [
            QrPlate::STATUS_CLAIMED,
            QrPlate::STATUS_REGISTERED
        ])) {
            if ($qr->owner_user_id !== $user->id) {
                return back()->with('error', 'Este QR pertenece a otro usuario.');
            }
        }

        // Usar el servicio para hacer la asignación segura y luego registrar el evento
        DB::transaction(function () use ($qr, $pet, $user) {

            app(QrAssignmentService::class)->assignToPet($qr, $pet);

            $qr->addEvent('assigned', now(), [
                'pet_id' => $pet->id,
                'user_id' => $user->id
            ]);

            $user->update(['claimed_qr_id' => null]);
        });

        return redirect()
            ->route('owner.qrplates.index')
            ->with('success', 'QR asignado correctamente a la mascota.');
    }

    public function claim(Request $request, $code)
    {
        $user = Auth::user();

        // ya tiene uno pendiente
        if ($user->claimed_qr_id) {

            $existingQr = QrPlate::find($user->claimed_qr_id);

            if ($existingQr) {
                return redirect()->route('owner.qrplates.create', [
                    'qr' => $existingQr->code
                ]);
            } else {
                $user->update(['claimed_qr_id' => null]);
            }
        }

        $qr = QrPlate::where('code', $code)->firstOrFail();

        if ($qr->pet_id !== null) {
            return back()->with('error', 'Este QR ya está en uso.');
        }

        DB::transaction(function () use ($qr, $user) {

            $qr->addEvent('claimed', now(), [
                'user_id' => $user->id
            ]);

            $user->update([
                'claimed_qr_id' => $qr->id
            ]);
        });

        return redirect()->route('owner.qrplates.create', [
            'qr' => $qr->code
        ]);
    }
    public function forget($userId = null)
    {
        return DB::transaction(function () use ($userId) {

            $this->addEvent('forgotten', now(), [
                'user_id' => $userId
            ]);

            return $this;
        });
    }
}