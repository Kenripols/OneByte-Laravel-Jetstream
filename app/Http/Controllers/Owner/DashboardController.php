<?php
// Creado 16-12-25 para recuento de usuarios, mascotas, y estados de las mismas
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        abort_if(!$user || !$user->owner, 403);
        // pets.owner_id apunta a owners.user_id (mismo valor que users.id), no al id de la fila owners
        $ownerId = $user->id;

        // Datos para el mapa / carrusel de mascotas perdidas del dueño
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
    // Cambios de estado: alertas lost de toda la comunidad
    $statusPosts = (clone $base)
        ->where('type', 'lost')
        ->whereHas('pet')
        ->with('pet')
        ->latest()
        ->take(10)
        ->get();

        return view('owner.dashboard', compact('lostPetsData', 'tips', 'news', 'statusPosts'));
        }
}