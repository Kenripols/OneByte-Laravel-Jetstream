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
<<<<<<< Updated upstream
{
    // iDate entre hace 1 año y hoy
    $iDate = $this->faker->dateTimeBetween('-1 year', 'now');

    // eDate exactamente 2 años después de iDate
    $eDate = (clone $iDate)->modify('+2 years');

    return [
        'iDate' => $iDate,
        'eDate' => $eDate,
        'pet_id' => Pet::factory(),
    ];
}
=======
    {
        return [
            'code' => $this->faker->bothify('???-#####'),
            'iDate' => $this->faker->date,
            'eDate' => $this->faker->date,
            'pet_id' => Pet::factory(),
        ];
    }
>>>>>>> Stashed changes
}
