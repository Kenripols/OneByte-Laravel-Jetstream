<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQRPlateRequest;
use App\Models\QRPlate;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QRPlateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
            $QRPlates = QRPlate::whereHas('pet', function ($query) {
                $query->where('owner_id', Auth::id());
            })->paginate(10); // Paginación de 10
            return view('owner.qrplates.index', compact('QRPlates'));
    
    }

    
    public function create(Request $request)
        {
            $this->authorize('create', QRPlate::class);
            $pets = Pet::with(['breed', 'owner'])
                ->whereHas('owner', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->paginate(10);
            $qr = null;
            if ($request->has('qr')) {
                $qr = QRPlate::where('code', $request->qr)->first();
            }
            return view('owner.qrplates.create', compact('pets', 'qr'));
        }

    /**
     * Store a newly created resource in storage.
     */
       public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:qr_plates,code',
            'pet_id' => 'required|exists:pets,id',
        ]);

        $qr = QRPlate::where('code', $request->code)->firstOrFail();

        // VALIDACIONES

        // 1- Ya usado
        if ($qr->pet_id !== null) {
            return back()->with('error', 'El QR ya está asignado.');
        }
        // 2- No disponible aún
        if ($qr->status === QRPlate::STATUS_GENERATED) {
            return back()->with('error', 'El QR aún no está disponible.');
        }

        // 3- Si esta CLAIMED o REGISTERED → validar ownership
            if (in_array($qr->status, [
                QRPlate::STATUS_CLAIMED,
                QRPlate::STATUS_REGISTERED
            ])) {

        if ($qr->owner_user_id !== Auth::id()) {
            return back()->with('error', 'Este QR pertenece a otro usuario.');
        }
    }
        // 3- Si está registrado -> validar propietario
        if ($qr->status === QRPlate::STATUS_REGISTERED) {

            $owner = Owner::where('registration_qr_id', $qr->id)->first();

            if (!$owner || $owner->user_id !== Auth::id()) {
                return back()->with('error', 'Este QR pertenece a otro usuario.');
            }
        }
        //4 - Verificar que la mascota es del usuario
        $pet = Pet::where('id', $request->pet_id)
            ->whereHas('owner', fn($q) => $q->where('user_id', Auth::id()))
            ->firstOrFail();

        // TRANSACCIoN (o lo hace todo bien o rollbackea)
        DB::transaction(function () use ($qr, $pet) {
            $qr->update([
                'pet_id' => $pet->id,
                'status' => QRPlate::STATUS_ASSIGNED
            ]);

            $qr->addEvent('assigned', now(), [
                'pet_id' => $pet->id,
                'user_id' => Auth::id()
            ]);
        });
 
       return redirect()
            ->route('owner.qrplates.index')
            ->with('success', 'QR asignado correctamente a la mascota.');
    }

   public function claim(Request $request, $code)
    {
        $user = Auth::user();

        if ($user->qr_pending_id) {
            $pendingQr = QRPlate::find($user->qr_pending_id);

            return redirect()->route('owner.qrplates.create', [
                'qr' => $pendingQr->code
            ])->with('error', 'Tenés un QR pendiente.');
        }

        $qr = QRPlate::where('code', $code)->firstOrFail();

        if ($qr->status !== QRPlate::STATUS_DOWNLOADED) {
            return back()->with('error', 'No se puede reclamar este QR.');
        }

        DB::transaction(function () use ($qr, $user) {

            // evitar doble claim
            if ($qr->status === QRPlate::STATUS_CLAIMED) {
                throw new \Exception('QR ya reclamado');
            }

            $qr->addEvent('claimed', now(), [
                'user_id' => $user->id
            ]);

            $user->update([
                'qr_pending_id' => $qr->id
            ]);
        });

        return redirect()->route('owner.qrplates.create', [
            'qr' => $qr->code
        ])->with('info', 'Ahora asigná el QR a una mascota.');
    }
    /**
     * Display the specified resource.
     */
    public function show(QRPlate $qRPlate)
    {
        // Lo hace Modal
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QRPlate $qRPlate)
    {
        // La idea es modal
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QRPlate $qRPlate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QRPlate $qRPlate)
    {
        // No se eliminan los QR en cambio vencen y queda registro en historial
    }
}
