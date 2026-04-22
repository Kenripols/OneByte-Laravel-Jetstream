<?php
// Creado 16-12-25 para recuento de usuarios, mascotas, y estados de las mismas
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $ownerId = auth()->user()->owner->id;
        // Total de mascotas
        $totalPets = Pet::where('owner_id', $ownerId)->count();

        // Mascotas perdidas (estado actual = PERDIDA)
        $lostPets = Pet::where('owner_id', $ownerId)->whereHas('currentState', function ($q) {$q->where('state', 'PERDIDA');})->count();
        // Mascotas encontradas (estado actual = NORMAL)
        $foundPets = Pet::where('owner_id', $ownerId)->whereHas('currentState', function ($q) {$q->where('state', 'NORMAL');})->count();
        // Yo diría de no poner el indicador de mascotas fallecidas  (coincido, queda fiero)
        
        //acá se pica todo y te muestra datos de tus mascotas perdidas para que al entrar ya sepas que onda
        $lostPetsList = Pet::where('owner_id', $ownerId)
            ->whereHas('currentState', function ($q) {$q->where('state', 'PERDIDA');})
            ->with(['qrPlate.lastReading'])
            ->with(['qrPlate' => function ($q) {$q->withCount('readings')->with('lastReading');}])->get();
        //
        $lostPetsList = $lostPetsList->sortByDesc(function ($pet) {return $pet->qrPlate?->lastReading?->created_at;});
        
        $lostPetsData = $lostPetsList->map(
            function ($pet) {$qr = $pet->qrPlate;$last = $qr?->lastReading;
                return ['id' => $pet->id,'name' => $pet->name,'lat' => $last?->lat,'lng' => $last?->lng,'last_seen' => $last?->created_at?->toDateTimeString(),'scans' => $qr?->readings_count ?? 0,'is_recent' => $last && now()->diffInMinutes($last->created_at) < 60,   ];
            }
        );
        return view('owner.dashboard', compact('totalPets','lostPets','foundPets','lostPetsData'));
    }
}