<?php
// Creado 16-12-25 para recuento de usuarios, mascotas, y estados de las mismas
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\User;
use App\Enums\PetState;

class DashboardController extends Controller
{
    public function index()
    {
        // Total de mascotas
        $totalPets = Pet::count();

        // Mascotas perdidas (estado actual = PERDIDA)
        $lostPets = Pet::whereHas('currentStateModel', function ($q) {
        $q->where('state', PetState::LOST);
        })->count();

        // Mascotas encontradas (estado actual = NORMAL)
        $foundPets = Pet::whereHas('currentStateModel', function ($q) {
        $q->where('state', PetState::NORMAL);
        })->count();
        // Yo diría de no poner el indicador de mascotas fallecidas (estoy de acuerdo)
        // Total de usuarios
        $totalUsers = User::count();

        return view('admin.dashboard', compact(
            'totalPets',
            'lostPets',
            'foundPets',
            'totalUsers'
        ));
    }
}