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
            'cellPhone' => $this->faker->phoneNumber(),
            'dateTime' => $this->faker->dateTime(),
            'QRPlate_id' => QRPlate::factory(), // corregido a snake_case ?? Consultar Equispe
        ];
    }
}
