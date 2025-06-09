<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Devuelve la vista del index de usuarios
        // Paginamos los resultados
    $users = User::paginate(10); //  10 por página

    return view('admin.users.index', compact('users'));
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
    public function show(User $user)
    {
        
        $user = User::with('owner')->findOrFail($user->id);
        $user = User::with('owner.pets.breed')->findOrFail($user->id);
        $user = User::with('owner.pets.breed')->find($user->id);
        return view('admin.users.show', compact('user'));
        // Devuelve la vista de detalles de un usuario y datos de dueño en específico
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
