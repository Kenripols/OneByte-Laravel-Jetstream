<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Breed;
use App\Models\QrPlate;
use App\Models\Pet;
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
        $user = Auth::user();

        if ($request->has('qr')) {
            $maybeQr = QrPlate::where('code', $request->qr)->first();

            if ($maybeQr && $maybeQr->status === QrPlate::STATUS_CLAIMED) {
                // si no está logueado o no es el dueño que lo reservó, mostrar 'no disponible'
                if (!Auth::check() || (
                    Auth::id() !== $maybeQr->owner_user_id
                    && (! $user || $user->claimed_qr_id !== $maybeQr->id)
                )) {
                    return view('qr.unavailable');
                }
            }
        }

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
            $code = trim($request->input('qr'));
            $qr = QrPlate::where('code', $code)->first();

            if ($qr && $qr->owner_user_id && $qr->owner_user_id !== $user->id) {
                abort(403);
            }
        }

        $breeds = Breed::orderBy('breedName')->get();

        return view('owner.qrplates.create', compact('pets', 'qr', 'breeds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:qr_plates,code',
            'pet_id' => 'nullable|exists:pets,id',

            'new_name' => 'required_without:pet_id',
            'new_bDate' => 'nullable|date|before_or_equal:today',
            'new_breed_id' => 'required_with:new_name|exists:breeds,id',
            'new_photo' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        $qr = QrPlate::where('code', $request->code)->firstOrFail();

        // validaciones QR primero, antes de crear nada
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

        // foto fuera de la transaction (operación de filesystem)
        $photoPath = (!$request->pet_id && $request->hasFile('new_photo'))
            ? $request->file('new_photo')->store('pets', 'public')
            : null;

        DB::transaction(function () use ($request, $qr, $user, $photoPath) {

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
                    'photo' => $photoPath,
                ]);
            }

            $oldQr = QrPlate::where('pet_id', $pet->id)
                ->where('status', QrPlate::STATUS_ASSIGNED)
                ->first();

            if ($oldQr) {
                $oldQr->addEvent('replaced', now(), [
                    'replaced_by_qr_id' => $qr->id,
                    'user_id' => $user->id,
                ]);
            }

            $qr->update([
                'pet_id' => $pet->id,
                'status' => QrPlate::STATUS_ASSIGNED,
            ]);

            $qr->refresh();

            $qr->addEvent('assigned', now(), [
                'pet_id' => $pet->id,
                'user_id' => $user->id
            ]);

            $user->update(['claimed_qr_id' => null]);
        });

        $qr->refresh();

        return redirect()
            ->route('owner.pets.index')
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

        if (in_array($qr->status, [
            QrPlate::STATUS_GENERATED,
            QrPlate::STATUS_EXPIRED,
            QrPlate::STATUS_REPLACED,
            QrPlate::STATUS_ASSIGNED,
        ])) {
            return back()->with('error', 'Este QR no está disponible para reclamar.');
        }

        DB::transaction(function () use ($qr, $user) {

            $qr->addEvent('claimed', now(), [
                'user_id' => $user->id
            ]);

            $qr->update(['owner_user_id' => $user->id]);

            $user->update([
                'claimed_qr_id' => $qr->id
            ]);
        });

        return redirect()->route('owner.qrplates.create', [
            'qr' => $qr->code
        ]);
    }
}