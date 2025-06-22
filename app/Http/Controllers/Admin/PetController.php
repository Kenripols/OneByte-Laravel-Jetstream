<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
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
       //Segun el rol de usuario autenticado, muestra las mascotas
        if (Auth::user()->hasRole('admin')) {
            // Si es admin, muestra todas las mascotas
            $pets = Pet::with(['breed', 'owner'])->paginate(10);
        } else {
            // Si no es admin, muestra solo las mascotas del usuario autenticado
            $pets = Pet::with(['breed', 'owner'])
                ->whereHas('owner', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->paginate(10);
        }

        return view('admin.pets.index', compact('pets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
