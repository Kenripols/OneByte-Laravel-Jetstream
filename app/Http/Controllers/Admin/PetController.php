<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePetRequest;
use App\Models\Pet;
use App\Models\Breed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       //Segun el rol de usuario autenticado, muestra las mascotas (Funciona a pesar de que el ID da error)
        if (Auth::user()->hasRole('admin')) {
            // Si es admin, muestra todas las mascotas
            $pets = Pet::with(['breed', 'owner'])->paginate(10);
            return view('admin.pets.index', compact('pets'));
        } else {
            // Si no es admin, muestra solo las mascotas del usuario autenticado
            $pets = Pet::with(['breed', 'owner'])
                ->whereHas('owner', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->paginate(10);
                return view('owner.pets.index', compact('pets'));
        }

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasRole('owner')) {
            $breeds = Breed::all();
            return view('owner.pets.create', compact('breeds'));
        } else {
            return redirect()->route('admin.pets.index')
                ->with('error', 'No tienes permiso para crear mascotas.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePetRequest $request)
    {
        $owner = Auth::user()->owner; // El dueño es el usuario logueado

        $data = $request->validated();
        
        $data['owner_id'] = $owner->user_id; // Asigno el owner_id

        // Si sube una foto, la guardo en storage
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
        $pet = Pet::with(['breed', 'owner'])->findOrFail($pet->id);

    return view('admin.pets.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pet $pet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        //
    }
}
