<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePetRequest;
use App\Models\Pet;

class PetController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    { //Quedaría obsoleto al utilizar livewire con modal
           
            // Si es admin, muestra todas las mascotas
            $pets = Pet::with(['breed', 'owner'])->paginate(10);
            return view('admin.pets.index', compact('pets'));

}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            return redirect()->route('admin.pets.index')
                ->with('error', 'No tienes permiso para crear mascotas.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePetRequest $request)
    {
       
        return redirect()->route('admin.pets.index')
            ->with('error', 'No tienes permiso para crear mascotas.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet)
    {
        $pet->load(['breed', 'owner']);
        return view('admin.pets.show', compact('pet'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        return redirect()->route('admin.pets.index')
            ->with('error', 'No tienes permiso para editar mascotas.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePetRequest $request, Pet $pet)
    {

        return redirect()->route('admin.pets.index')
            ->with('error', 'No tienes permiso para editar mascotas.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
       return redirect()->route('admin.pets.index')
            ->with('error', 'No tienes permiso para eliminar mascotas.');
    }
    
}
