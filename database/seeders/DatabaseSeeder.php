<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Owner;
use App\Models\Breed;
use App\Models\Pet;
use App\Models\Reading;
use App\Models\QRPlate;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Creo los roles necesarios administrador y dueño
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleOwner = Role::create(['name' => 'owner']);
        // Creo usuario Admin precargado
        $adminUser = User::factory()->create([
            'name' => 'Admin',
            'email' => 'gvilarino1727@gmail.com',
            'password' => bcrypt('12345678'), // Contraseña por defecto
        ]);
        $adminUser->assignRole($roleAdmin); // Asigno el rol de admin al usuario creado
        // Creo owners asociados a un usuario (Detallado en el ownerfactory )
        //Owner::factory(10)->create();
        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('owner'); // Asigno el rol de owner a cada usuario creado
            Owner::factory()->create([
                'user_id' => $user->id, // Asigno el mismo ID al dueño que el usuario
            ]);
        });



        // Creo razas de perros precargadas
        $breeds = Breed::factory()->createMany([
            ['animalType' => 'Perro','breedName' => 'Pitbull', 'size' => 'Grande'],
            ['animalType' => 'Perro','breedName' => 'Chihuahua', 'size' => 'Pequeño'],
            ['animalType' => 'Perro','breedName' => 'Labrador', 'size' => 'Mediano'],
            ['animalType' => 'Perro','breedName' => 'Pastor Alemán', 'size' => 'Grande'],
            ['animalType' => 'Perro','breedName' => 'Bulldog', 'size' => 'Mediano'],
            ['animalType' => 'Gato','breedName' => 'Persa', 'size' => 'Pequeño'],
            ['animalType' => 'Gato','breedName' => 'Maine Coon', 'size' => 'Grande'],
        ]);
       
        // Creo 10 propietarios, cada uno con 3 mascotas
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
