<?php

namespace App\Enums;

enum PetState: string
{
    case NORMAL = 'NORMAL';
    case LOST   = 'LOST';
    case FOUND  = 'FOUND';
    case DEAD = 'DEAD';
    public function label(): string
    {
        return match ($this) {
            self::NORMAL => 'NORMAL',
            self::LOST   => 'PERDIDA',
            self::FOUND  => 'ENCONTRADA',
            self::DEAD  => 'FALLECIDA',
        };
    }
}