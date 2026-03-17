<?php

namespace App\Policies;

use App\Models\Pet;
use App\Models\User;

class PetPolicy
{
    // El dueño solo puede ver sus propias mascotas, el admin puede ver todas
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('owner');
    }

    public function view(User $user, Pet $pet): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->hasRole('owner') && $pet->owner?->user_id === $user->id;
    }
//Solamente el dueño puede crear una mascota
    public function create(User $user): bool
    {
        return $user->hasRole('owner');
    }
//Solamente el dueño puede actualizar o eliminar una mascota suya
    public function update(User $user, Pet $pet): bool
    {
        return $user->hasRole('owner') && $pet->owner?->user_id === $user->id;
    }

    public function delete(User $user, Pet $pet): bool
    {
        return $user->hasRole('owner') && $pet->owner?->user_id === $user->id;
    }
}