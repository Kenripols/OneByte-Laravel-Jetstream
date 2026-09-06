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
     * Muestra una lista del recurso.
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
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        $this->authorize('create', Pet::class);
            $breeds = Breed::all();
            return view('owner.pets.create', compact('breeds'));
        
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(StorePetRequest $request)
    {
        $this->authorize('create', Pet::class);
        $owner = Auth::user()->owner; // El dueño es el usuario logueado

        $data = $request->validated();

        $data['owner_id'] = $owner->user_id; // Asigno el owner_id

        //Si sube una foto, la guardo en storage
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('pets', 'public');
        } else {
            $data['photo'] = null;
        }

        $pet = Pet::create($data);

        if (session('claimed_qr_id')) {
            $qr = QrPlate::find(session('claimed_qr_id'));

            if ($qr) {
                app(QrAssignmentService::class)->assignToPet($qr, $pet);
            }

            session()->forget('claimed_qr_id');
        }

        return redirect()->route('owner.pets.index')
            ->with('success', 'Mascota creada correctamente');
    }

    /**
     * Mostrar el recurso especificado.
     */
    public function show(Pet $pet)
    {
        //politica que no rompa 403
        $this->authorize('view', $pet);
        $pet->load(['breed','owner','qrPlate.readings'=> function ($q) {$q->orderBy('created_at');}]);
        $readings = $pet->qrPlate?->readings ?? collect();
        $points = $readings->map(function ($r) {return ['lat' => $r->lat,'lng' => $r->lng,'time' => $r->created_at->toDateTimeString(),];})
        ->filter(fn($p) => $p['lat'] && $p['lng'])->values();
        return view('owner.pets.show', compact('pet', 'points'));
    }

    

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(Pet $pet)
    {
        $this->authorize('update', $pet);
        //Falta implementar con modal no iría acá
        abort(404);
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
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
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(Pet $pet)
    {
        $this->authorize('delete', $pet);
        $pet->delete();
            return redirect()->route('owner.pets.index')->with('success', 'Mascota eliminada correctamente');
    }
    
}
