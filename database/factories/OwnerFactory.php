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
<<<<<<< Updated upstream
            'docType' => $this->faker->randomElement(['Cedula', 'Pasaporte']),
            'docNum' => $this->faker->unique()->numerify('##########'),
            'fName1' => $this->faker->firstName,
            'fName2' => $this->faker->optional()->firstName,
            'sName1' => $this->faker->lastName,
            'sName2' => $this->faker->optional()->lastName,
=======
            'doctype' => $this->faker->randomElement(['Cedula', 'Pasaporte']),
            'docnum' => $this->faker->unique()->numerify('##########'),
            'fname' => $this->faker->firstName,
            'fname2' => $this->faker->optional()->firstName,
            'sname1' => $this->faker->lastName,
            'sname2' => $this->faker->optional()->lastName,
>>>>>>> Stashed changes
            'user_id' => User::factory(), // Crea un User y usa su ID
        ];
    }
}
