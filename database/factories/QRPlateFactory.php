<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pet;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QRPlate>
 */
class QRPlateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'iDate' => $this->faker->date,
            'eDate' => $this->faker->date,
            'pet_id' => Pet::factory(),
        ];
    }
}
