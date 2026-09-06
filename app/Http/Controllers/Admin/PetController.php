<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePetRequest;
use App\Models\Pet;


class PetController extends Controller
{

    /**
     * Muestra una lista del recurso.
     */
    public function index()
    { //Quedaría obsoleto al utilizar livewire con modal
           
            // Si es admin, muestra todas las mascotas
            $pets = Pet::with(['breed', 'owner'])->paginate(10);
            return view('admin.pets.index', compact('pets'));

}

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
            return redirect()->route('admin.pets.index')
                ->with('error', 'No tienes permiso para crear mascotas.');
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(StorePetRequest $request)
    {
       
        return redirect()->route('admin.pets.index')
            ->with('error', 'No tienes permiso para crear mascotas.');
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(Pet $pet)
    {
        $pet->load(['breed', 'owner']);
        return view('admin.pets.show', compact('pet'));
        
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
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
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(Pet $pet)
    {
       return redirect()->route('admin.pets.index')
            ->with('error', 'No tienes permiso para eliminar mascotas.');
    }
    
}
