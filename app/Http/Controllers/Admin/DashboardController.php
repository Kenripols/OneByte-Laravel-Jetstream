<?php
// Creado 16-12-25 para recuento de usuarios, mascotas, y estados de las mismas
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Total de mascotas
        $totalPets = Pet::count();

        // Mascotas perdidas (estado actual = PERDIDA)
        $lostPets = Pet::whereHas('currentState', function ($q) {
            $q->where('state', 'PERDIDA');
        })->count();

        // Mascotas encontradas (estado actual = OK)
        $foundPets = Pet::whereHas('currentState', function ($q) {
            $q->where('state', 'OK');
        })->count();
        // Yo diría de no poner el indicador de mascotas fallecidas (estoy de acuerdo)
        // Total de usuarios
        $totalUsers = User::count();

        return view('dashboard', compact(
            'totalPets',
            'lostPets',
            'foundPets',
            'totalUsers'
        ));
    }
}