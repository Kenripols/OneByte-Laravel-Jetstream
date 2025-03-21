<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Owner;
use App\Models\Breed;
use App\Models\Pet;
use App\Models\Reading;
use App\Models\QRPlate;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear owners asociados a un usuario (Detallado en el ownerfactory )
        //Owner::factory(10)->create();
        User::factory(10)->create()->each(function ($user) {
            Owner::factory()->create([
                'user_id' => $user->id, // Asigna el mismo ID que el usuario
            ]);
        });

        // Crear razas de perros precargadas
        $breeds = Breed::factory()->createMany([
            ['animalType' => 'Perro','breedName' => 'Pitbull', 'size' => 'Grande'],
            ['animalType' => 'Perro','breedName' => 'Chihuahua', 'size' => 'Pequeño'],
            ['animalType' => 'Perro','breedName' => 'Labrador', 'size' => 'Mediano'],
            ['animalType' => 'Perro','breedName' => 'Pastor Alemán', 'size' => 'Grande'],
            ['animalType' => 'Perro','breedName' => 'Bulldog', 'size' => 'Mediano'],
            ['animalType' => 'Gato','breedName' => 'Persa', 'size' => 'Pequeño'],
            ['animalType' => 'Gato','breedName' => 'Maine Coon', 'size' => 'Grande'],
        ]);
       
        // Crear 10 propietarios, cada uno con 3 mascotas
        Owner::all()->each(function ($owner) use ($breeds) {
            // Cada propietario tendrá 3 mascotas
            Pet::factory(3)->create([
                'owner_id' => $owner->user_id,  // Asigna el owner actual
                'breed_id' => $breeds->random()->id, // Asigna una raza aleatoria
            ])->each(function ($pet) {
                // Cada mascota tendrá una placa QR
                QRPlate::factory()->create([
                    'pet_id' => $pet->id,
                ])->each(function ($qrPlate) {
                    // Cada placa QR tendrá una lectura
                    Reading::factory()->create([
                        'QRPlate_id' => $qrPlate->id,
                    ]);
                });
            });
        });
       
    
    }
}
