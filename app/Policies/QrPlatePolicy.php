<?php

namespace App\Policies;

use App\Models\QrPlate;
use App\Models\User;

class QrPlatePolicy
{
    public function before(User $user)
    {
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return $user->hasRole('owner');
    }

    public function view(User $user, QrPlate $qrPlate): bool
    {
        return $user->hasRole('owner')
            && $qrPlate->pet?->owner?->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('owner');
    }

    public function update(User $user, QrPlate $qrPlate): bool
    {
        return $user->hasRole('owner')
            && $qrPlate->pet?->owner?->user_id === $user->id;
    }

    public function delete(User $user, QrPlate $qrPlate): bool
    {
        return $user->hasRole('owner')
            && $qrPlate->pet?->owner?->user_id === $user->id;
    }
}