<?php
// Creado 16-12-25 para recuento de usuarios, mascotas, y estados de las mismas
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\User;
use App\Enums\PetState;
// Importo Post para el carrousel
use App\Models\Post;
// Importo para las graficas
use App\Models\QrPlate;
// Importo para actividad reciente
use App\Models\PetStateHistory;
use App\Models\Reading;
use Illuminate\Support\Facades\DB;


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

        // Total de escaneos QR
        $totalScans = Reading::count();

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

        // Para seleccionar las mascotas registradas por mes 
        $monthlyPets = Pet::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $months = [];
        $totals = [];

        foreach ($monthlyPets as $item) {

            $months[] = date('M', mktime(0, 0, 0, $item->month, 1));

            $totals[] = $item->total;
    }
    
    // Para usuarios registrados por mes
    $monthlyUsers = User::select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('COUNT(*) as total')
    )
    ->groupBy('month')
    ->orderBy('month')
    ->get();

    $userMonths = [];
    $userTotals = [];

    foreach ($monthlyUsers as $item) {

        $userMonths[] = date('M', mktime(0, 0, 0, $item->month, 1));

        $userTotals[] = $item->total;
    }

    // Para qr registrados por mes
    $monthlyQr = QrPlate::select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('COUNT(*) as total')
    )
    ->groupBy('month')
    ->orderBy('month')
    ->get();

    $qrMonths = [];
    $qrTotals = [];

    foreach ($monthlyQr as $item) {

        $qrMonths[] = date('M', mktime(0, 0, 0, $item->month, 1));

        $qrTotals[] = $item->total;
    }

    // Para las lecturas de QRs
    $monthlyScans = Reading::select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('COUNT(*) as total')
    )
    ->groupBy('month')
    ->orderBy('month')
    ->get();

    $scanMonths = [];
    $scanTotals = [];

    foreach ($monthlyScans as $item) {

        $scanMonths[] = date('M', mktime(0, 0, 0, $item->month, 1));

        $scanTotals[] = $item->total;
    }

    // Sección Actividad Reciente
    
    // Usuarios recientes
    $recentUsers = User::latest()
        ->take(2)
        ->get();

    // Mascotas registradas recientemente
    $recentPets = Pet::latest()
        ->take(2)
        ->get();

    // Últimos escaneos QR
    $recentReadings = Reading::latest()
        ->take(2)
        ->get();

    // Últimas mascotas reportadas como perdidas
    $recentLostPets = PetStateHistory::with('pet')
        ->where('state', PetState::LOST)
        ->latest('started_at')
        ->take(2)
        ->get();

    // Últimas mascotas encontradas
    $recentFoundPets = PetStateHistory::with('pet')
        ->where('state', PetState::NORMAL)
        ->latest('started_at')
        ->take(2)
        ->get();


        return view('admin.dashboard', compact(
            'totalPets',
            'lostPets',
            'foundPets',
            'totalUsers',
            'latestPets',
            'months',
            'totals',
            'userMonths',
            'userTotals',
            'qrMonths',
            'qrTotals',
            'scanMonths',
            'scanTotals',
            'totalScans',
            'recentUsers',
            'recentPets',
            'recentReadings',
            'recentLostPets',
            'recentFoundPets'
        ));
    }
}