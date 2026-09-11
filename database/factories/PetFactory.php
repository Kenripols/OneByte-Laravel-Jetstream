<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Breed;
use App\Models\Owner;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define el estado predeterminado del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName(),
            'bDate' => $this->faker->date(),
            'breed_id'=>Breed::factory(), //Aqui se asocia una raza a la Mascota
            'owner_id' => Owner::factory(), // Aquí se asocia un Titular a la Mascota
        ];
    }
}
