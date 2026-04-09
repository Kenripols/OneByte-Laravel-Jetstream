<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\QRPlate;

class QRPlateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => (string) Str::uuid(),

            // estado inicial
            'status' => QRPlate::STATUS_GENERATED,

            'pet_id' => null,
            'batch_id' => null,
        ];
    }
    
    public function generated()
    {
        return $this->afterCreating(function ($qr) {
            $qr->addEvent('generated');
        });
    }
    public function downloaded()
    {
        return $this->afterCreating(function ($qr) {
            $qr->addEvent('downloaded');
        });
    }
    public function assigned($pet = null)
    {
        return $this->afterCreating(function ($qr) use ($pet) {
            if ($pet) {
                $qr->update(['pet_id' => $pet->id]);
            }
            $qr->addEvent('assigned');
        });
    }
}