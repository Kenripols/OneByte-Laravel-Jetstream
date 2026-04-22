<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\QRPlate;
use App\Models\Pet;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reading>
 */
class ReadingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'qr_plate_id' => QRPlate::factory(),

            'user_id' => null,

            'ip' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),

            'lat' => $this->faker->latitude(-35, -34),
            'lng' => $this->faker->longitude(-57, -55),
        ];
    }// corregido a snake_case ?? Consultar Equispe
  
    
}
