<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BreedFactory extends Factory
{
   public function definition(): array
{
    return [
        'breedName' => $this->faker->word(),
        'animalType' => $this->faker->randomElement(['Perro', 'Gato']),
        'size' => $this->faker->randomElement(['Pequeño', 'Mediano', 'Grande']),
    ];
}
}
