<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePetRequest;
use App\Models\Pet;
use App\Models\Breed;
use Illuminate\Support\Facades\Auth;


class PetController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    { //Quedaría obsoleto al utilizar livewire con modal
    //Listo mascotas del dueño con paginación
        $this->authorize('viewAny', Pet::class);
            $pets = Pet::with(['breed', 'owner'])
                ->whereHas('owner', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->paginate(10);

                return view('owner.pets.index', compact('pets'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Pet::class);
            $breeds = Breed::all();
            return view('owner.pets.create', compact('breeds'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePetRequest $request)
    {
        $this->authorize('create', Pet::class);
        $owner = Auth::user()->owner; // El dueño es el usuario logueado

        $data = $request->validated();

        $data['owner_id'] = $owner->id; // Asigno el owner_id


        if (session('claimed_qr_id')) {
            $qr = QrPlate::find(session('claimed_qr_id'));

            app(QrAssignmentService::class)->assignToPet($qr, $pet);

            session()->forget('claimed_qr_id');
        }



        //Si sube una foto, la guardo en storage
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('pets', 'public');
        } else {
            $data['photo'] = null;
        }

        Pet::create($data);

        return redirect()->route('owner.pets.index')
            ->with('success', 'Mascota creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet)
    {
        //policy poar aque no rompa 403
        $this->authorize('view', $pet);
        $pet->load(['breed','owner','qrPlate.readings'=> function ($q) {$q->orderBy('created_at');}]);
        $readings = $pet->qrPlate?->readings ?? collect();
        $points = $readings->map(function ($r) {return ['lat' => $r->lat,'lng' => $r->lng,'time' => $r->created_at->toDateTimeString(),];})
        ->filter(fn($p) => $p['lat'] && $p['lng'])->values();
        return view('owner.pets.show', compact('pet', 'points'));
    }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        $this->authorize('update', $pet);
        //Falta implementar con modal no iría acá
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePetRequest $request, Pet $pet)
    {
        $this->authorize('update', $pet);
        $data = $request->validated();
        // Si sube una foto, la guardo en storage

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('pets', 'public');
        }
        $pet->update($data);
        return redirect()->route('owner.pets.index')->with('success', 'Mascota actualizada correctamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        $this->authorize('delete', $pet);
        $pet->delete();
            return redirect()->route('owner.pets.index')->with('success', 'Mascota eliminada correctamente');
    }
    
}
