<?php

namespace Database\Factories;

use App\Models\PetHistory;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetHistoryFactory extends Factory
{
    protected $model = PetHistory::class;

    public function definition()
    {
        $states = ['OK', 'Fallecido', 'Perdido'];
        $beginDate = $this->faker->dateTimeBetween('-2 years', 'now');
        $endDate = $this->faker->boolean(30) ? $this->faker->dateTimeBetween($beginDate, 'now') : null;

        return [
            'pet_id' => Pet::factory(), // Se asigna en el seeder
            'state' => $this->faker->randomElement($states),
            'beginDate' => $beginDate,
            'endDate' => $endDate,
        ];
    }
}
