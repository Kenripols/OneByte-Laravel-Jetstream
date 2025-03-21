<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\QRPlate;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reading>
 */
class ReadingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cellPhone' => $this->faker->phoneNumber,
            'dateTime' => $this->faker->dateTime,
            'QRPlate_id' => QRPlate::factory(),
        ];
    }
}
