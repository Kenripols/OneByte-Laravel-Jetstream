<?php

namespace App\Policies;

use App\Models\QRPlate;
use App\Models\User;

class QRPlatePolicy
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

    public function view(User $user, QRPlate $qrPlate): bool
    {
        return $user->hasRole('owner')
            && $qrPlate->pet?->owner?->owner_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('owner');
    }

    public function update(User $user, QRPlate $qrPlate): bool
    {
        return $user->hasRole('owner')
            && $qrPlate->pet?->owner?->owner_id === $user->id;
    }

    public function delete(User $user, QRPlate $qrPlate): bool
    {
        return $user->hasRole('owner')
            && $qrPlate->pet?->owner?->owner_id === $user->id;
    }
}