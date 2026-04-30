<?php


namespace Database\Factories; //faltaba namespace


use App\Models\Post;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $pet = Pet::inRandomOrder()->first();

        if (!$pet) {
            throw new \Exception('No hay mascotas para generar posts');
        }

//        $zone = $pet->owner->neighborhood ?? 'Montevideo';

        $templates = [
            "{$pet->name}, {$pet->breed->name}, perdido",
            "Seguimos buscando a {$pet->name}",
            "{$pet->name} volvió a casa ",
        ];

        return [
            'title' => $this->faker->randomElement($templates),
            'type' => 'news',
            'pet_id' => $pet->id,            
            'is_active' => true,
            'publish_at' => now()->subHours(rand(1, 72)),
        ];
    }
}