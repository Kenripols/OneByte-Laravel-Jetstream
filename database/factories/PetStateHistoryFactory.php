<?php

namespace Database\Factories;

use App\Models\PetStateHistory;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\PetState;

class PetStateHistoryFactory extends Factory
{
    protected $model = PetStateHistory::class;

    public function definition()
    {
        $states = [
            PetState::NORMAL,
            PetState::LOST,
            PetState::FOUND,
            PetState::DEAD,
        ];
        $started_at = $this->faker->dateTimeBetween('-2 years', 'now');
        $ended_at = $this->faker->boolean(30) ? $this->faker->dateTimeBetween($started_at, 'now') : null;

        return [
            'pet_id' => Pet::factory(), // Se asigna en el seeder
            'state' => $this->faker->randomElement($states),
            'started_at' => $started_at,
            'ended_at' => $ended_at,
        ];
    }
}
