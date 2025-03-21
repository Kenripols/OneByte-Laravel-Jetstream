<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Owner;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Owner>
 */
class OwnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Owner::class;
    public function definition(): array
    {
       
        return [
            'docType' => $this->faker->randomElement(['Cedula', 'Pasaporte']),
            'docNum' => $this->faker->unique()->numerify('##########'),
            'fName' => $this->faker->firstName,
            'fName2' => $this->faker->optional()->firstName,
            'sName1' => $this->faker->lastName,
            'sName2' => $this->faker->optional()->lastName,
            'user_id' => User::factory(), // Crea un User y usa su ID
        ];
    }
}
