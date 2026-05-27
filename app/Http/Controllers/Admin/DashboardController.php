<?php
// Creado 16-12-25 para recuento de usuarios, mascotas, y estados de las mismas
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\User;
use App\Enums\PetState;
// Importo Post para el carrousel
use App\Models\Post;

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
        
        // Total de usuarios
        $totalUsers = User::count();

        // Lee las últimas 5 publicaciones de mascotas con estados normal y perdidas 
        $latestPets = Pet::whereHas('currentStateModel', function ($q) {
                    $q->whereIn('state', [
                        PetState::LOST,
                        PetState::NORMAL
                    ]);
                })
                ->latest()
                ->take(5)
                ->get();

        return view('admin.dashboard', compact(
            'totalPets',
            'lostPets',
            'foundPets',
            'totalUsers',
            'latestPets'
        ));
    }
}