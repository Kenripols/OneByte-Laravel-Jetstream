<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Breed;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBreedRequest;
use App\Http\Requests\UpdateBreedRequest;

class BreedController extends Controller
{
    
    public function index()
    {
        //Devuelve la vista del index de breeds
        // Paginamos los resultados
    $breeds = Breed::paginate(10); // Cambia el número 10 por la cantidad de elementos por página que desees

    return view('admin.breeds.index', compact('breeds'));
    }

    
    public function create()
    {
        return view('admin.breeds.create');
    // Devuelve la vista del formulario de creación de razas
    }

  
    public function store(StoreBreedRequest $request)
    {
    Breed::create($request->validated());

    return redirect()->route('admin.breeds.index')
        ->with('success', 'Raza creada correctamente');
    }

    
    public function show(Breed $breed)
    {
        return view('admin.breeds.show', compact('breed'));
        // Devuelve la vista de detalles de una raza específica
    }

    
    public function edit(Breed $breed)
    {
        return view('admin.breeds.edit', compact('breed'));
        // Devuelve la vista del formulario de edición de una raza específica
    }

    public function update(UpdateBreedRequest $request, Breed $breed)
    {
        $breed->update($request->validated());
        return redirect()->route('admin.breeds.index')
        ->with('success', 'Raza actualizada correctamente');
        // Actualiza la raza específica en la base de datos
    }

   
    public function destroy(Breed $breed)
    {
        $breed->delete();
        return redirect()->route('admin.breeds.index')
        ->with('success', 'Raza eliminada correctamente');
        // Elimina la raza específica de la base de datos
    }
}
