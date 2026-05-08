<?php
// Creado 16-12-25 para recuento de usuarios, mascotas, y estados de las mismas
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\User;
use App\Enums\PetState;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        $ownerId = auth()->id();
        // Total de mascotas
        $totalPets = Pet::where('owner_id', $ownerId)->count();

        // Mascotas perdidas (estado actual = PERDIDA)
        $lostPets = Pet::where('owner_id', $ownerId)->whereHas('currentState', function ($q) {$q->where('state', 'LOST');})->count();
        // Mascotas encontradas (estado actual = NORMAL)
        $foundPets = Pet::where('owner_id', $ownerId)->whereHas('currentState', function ($q) {$q->where('state', 'NORMAL');})->count();
        // Yo diría de no poner el indicador de mascotas fallecidas  (coincido, queda fiero)
        
        //acá se pica todo y te muestra datos de tus mascotas perdidas para que al entrar ya sepas que onda
        $lostPetsList = Pet::where('owner_id', $ownerId)
            ->whereHas('currentState', function ($q) {$q->where('state', 'LOST');})
            ->with(['qrPlate.lastReading'])
            ->with(['qrPlate' => function ($q) {$q->withCount('readings')->with('lastReading');}])->get();
        //
        $lostPetsList = $lostPetsList->sortByDesc(function ($pet) {return $pet->qrPlate?->lastReading?->created_at;});
        
        $lostPetsData = $lostPetsList->map(function ($pet) {
        $qr = $pet->qrPlate;
        $last = $qr?->lastReading;

        return [
            'id' => $pet->id,
            'name' => $pet->name,
            'photo_url' => $pet->photo_url,
            'message' => $qr?->message,

            //(info actual)
            'lat' => $last?->lat,
            'lng' => $last?->lng,
            'last_seen' => $last?->created_at?->toDateTimeString(),
            'scans' => $qr?->readings_count ?? 0,
            'is_recent' => $last && now()->diffInMinutes($last->created_at) < 60,

            // recorrido
            'points' => $qr?->readings?->map(function ($r) use ($pet, $qr) {
                  return [
                    'lat' => $r->lat,
                    'lng' => $r->lng,
                    'time' => $r->created_at?->toDateTimeString(),
                    'photo' => $pet->photo_url,
                    'message' => $qr?->message,
                ];
            })->values() ?? [],
        ];
    });
    $now = now();

    $base = Post::where('is_active', true)
        ->where(function ($q) use ($now) {
            $q->whereNull('publish_at')
            ->orWhere('publish_at', '<=', $now);
        })
        ->where(function ($q) use ($now) {
            $q->whereNull('expires_at')
            ->orWhere('expires_at', '>=', $now);
        });
    // Tips
    $tips = (clone $base)
        ->where('type', 'tip')
        ->inRandomOrder()
        ->take(3)
        ->get();
    // Novedades
    $news = (clone $base)
        ->where('type', 'news')
        ->latest()
        ->take(10)
        ->get();
        return view('owner.dashboard', compact('totalPets','lostPets','foundPets','lostPetsData','lostPetsList','tips','news'));
        }
}