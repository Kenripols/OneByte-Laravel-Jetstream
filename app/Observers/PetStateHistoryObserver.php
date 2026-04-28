<?php
namespace App\Observers;

use App\Models\Post;
use App\Models\PetStateHistory;

class PetStateHistoryObserver
{
    public function created(PetStateHistory $state)
    {
        $pet = $state->pet;

        if (!$pet) return;

        // LOST
        if ($state->state === 'LOST') {

            $alreadyActive = Post::where('pet_id', $pet->id)
                ->where('is_active', true)
                ->exists();

            if (!$alreadyActive) {
                Post::create([
                    'title' => "{$pet->name}, {$pet->breed->breedName}, perdido",
                    'type' => 'news',
                    'pet_id' => $pet->id,
                    'is_active' => true,
                    'publish_at' => now(),
                    'expires_at' => now()->addDays(14),
                ]);
            } else {
                // renovación
                Post::where('pet_id', $pet->id)
                    ->update(['is_active' => false]);

                Post::create([
                    'title' => " Seguimos buscando a {$pet->name}",
                    'type' => 'news',
                    'pet_id' => $pet->id,
                    'is_active' => true,
                    'publish_at' => now(),
                    'expires_at' => now()->addDays(14),
                ]);
            }
        }

        // FOUND
        if ($state->state === 'NORMAL') {

            Post::where('pet_id', $pet->id)
                ->update(['is_active' => false]);

            Post::create([
                'title' => " {$pet->name} volvió a casa ",
                'type' => 'news',
                'pet_id' => $pet->id,
                'is_active' => true,
                'publish_at' => now(),
            ]);
        }
    }
}