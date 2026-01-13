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

        // Mascotas perdidas (estado actual = perdida)
        $lostPets = Pet::whereHas('currentState', function ($q) {
            $q->where('state', 'perdida');
        })->count();

        // Mascotas encontradas (estado actual = encontrada)
        $foundPets = Pet::whereHas('currentState', function ($q) {
            $q->where('state', 'encontrada');
        })->count();

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