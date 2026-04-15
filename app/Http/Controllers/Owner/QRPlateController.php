<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQRPlateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\QRPlate;
use App\Models\Pet;
use App\Models\Owner;


class QRPlateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
            $QRPlates = QRPlate::whereHas('pet.owner', function ($query) {
                $query->where('user_id', Auth::id());
            })->paginate(10); // Paginación de 10
            return view('owner.qrplates.index', compact('QRPlates'));
    
    }

    
    public function create(Request $request)
    {   
      //  dd(Auth::user()->claimed_qr_id);

        $this->authorize('create', QRPlate::class);

        $pets = Pet::with(['breed', 'owner'])
            ->whereHas('owner', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->paginate(10);

        $qr = null;

        // 1: QR en sesión (flujo escaneado)
        if (Auth::user()->claimed_qr_id) {
           $qr = QRPlate::find(Auth::user()->claimed_qr_id);  //si tiene un qr pendiente me fijo que sea uno posta
        if (!$qr) {
            Auth::user()->update(['claimed_qr_id' => null]); //si no lo encuentra lo saca de mi "pendiente"
        }
}
        // 2: QR por query (?qr=...)
        elseif ($request->has('qr')) {
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
                'pet_id' => 'nullable|exists:pets,id',
                'new_name' => 'required_without:pet_id',
            ]);

            $qr = QRPlate::where('code', $request->code)->firstOrFail();

            // elegir o crear mascota
            if ($request->pet_id) {
                $pet = Pet::where('id', $request->pet_id)
                    ->whereHas('owner', fn($q) => $q->where('user_id', Auth::id()))
                    ->firstOrFail();
            } else {
                $pet = Pet::create([
                    'name' => $request->new_name,
                    'bDate' => $request->new_bDate,
                    'breed_id' => $request->new_breed_id,
                    'owner_id' => Auth::user()->owner->id,
                ]);

                if ($request->hasFile('new_photo')) {
                    $path = $request->file('new_photo')->store('pets', 'public');
                    $pet->update(['photo' => $path]);
                }
            }

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
            /*$pet = Pet::where('id', $request->pet_id)
                ->whereHas('owner', fn($q) => $q->where('user_id', Auth::id()))
                ->firstOrFail();
            */  //si estoy creando esto no anda, pero tengo mis dudas
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
    //dd('ENTRE A CLAIM');
        $user = Auth::user();

        if ($user->claimed_qr_id) {
            return redirect()->route('owner.qrplates.create', [
                'qr' => QRPlate::find($user->claimed_qr_id)->code
            ]);
        }

        $qr = QRPlate::where('code', $code)->firstOrFail();

        if ($qr->pet_id !== null) {
           return back()->with('error', 'Este QR ya está en uso.');
        }

        DB::transaction(function () use ($qr, $user) {
            $qr->addEvent('claimed', now(), [
                'user_id' => $user->id
            ]);

            $user->claimed_qr_id = $qr->id;
            $user->save();
            //dd($user->claimed_qr_id);
        });
    Auth::user()->update(['claimed_qr_id' => null ]); //como ya lo use ahora no tengo mas el pendiente<

        return redirect()->route('owner.qrplates.create', [
            'qr' => $qr->code
        ]);
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
