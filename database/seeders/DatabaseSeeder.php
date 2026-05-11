<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Owner;
use App\Models\Breed;
use App\Models\Pet;
use App\Models\Reading;
use App\Models\QRPlate;
use App\Models\QrMessage;
use App\Models\Post;

use App\Enums\QrEventType;
use App\Models\PetStateHistory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Creo los roles necesarios administrador y dueño
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleOwner = Role::firstOrCreate(['name' => 'owner']);

        // Creo usuario Admin precargado
        $adminUser = User::factory()->create([
            //'name' => 'Admin',
            'email' => 'lean@gmail.com',
            'password' => bcrypt('12345678'), // Contraseña por defecto
        ]);
        $adminUser->assignRole($roleAdmin); // Asigno el rol de admin al usuario creado
        // Creo owners asociados a un usuario (Detallado en el ownerfactory )
        //Owner::factory(10)->create();
        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('owner');

            Owner::factory()->create([
                'user_id' => $user->id,
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
        // Creo 10 propietarios, cada uno con 3 mascotas
            Pet::factory(3)->create([
                // owners.user_id es la PK; pets.owner_id guarda ese mismo id de usuario
                'owner_id' => $owner->user_id,
                'breed_id' => $breeds->random()->id,
            ])->each(function ($pet) {

                // Creo la placa QR para la mascota
                $qrPlate = QrPlate::create([
                    'code' => (string) Str::uuid(),
                    'status' => QRPlate::STATUS_ASSIGNED,
                    'pet_id' => $pet->id,
                    //'owner_user_id' => $pet->owner->user_id,
                    'batch_id' => rand(1, 3),
                    ]);

                    $generatedDate = now()->subDays(rand(10, 30));
                    $downloadedDate = (clone $generatedDate)->addDays(rand(1, 5)); //genero a partir de la anterior para no hacer lio de fechas
                    $assignedDate = (clone $downloadedDate)->addDays(rand(1, 3));

                // Creo entre 1 estado para cada mascota
                $isLost = rand(0, 1); // 50% probabilidad
                PetStateHistory::create([ 'pet_id' => $pet->id,'state' => $isLost ? 'LOST' : 'NORMAL','created_at' => now()->subDays(rand(0, 5)),]);

                if ($isLost) {//aca si hay una perdida la muestra en el feed de todos
                    Post::create([
                        'title' => "{$pet->name}, {$pet->breed->breedName}, perdido",
                        'type' => 'news',
                        'pet_id' => $pet->id,
                        'is_active' => true,
                        'publish_at' => now()->subHours(rand(1, 24)),
                        'expires_at' => now()->addDays(14),
                    ]);
                }

                if (!$isLost && rand(0, 1)) {//cuando aparece una hace un post

                    Post::create([
                        'title' => "{$pet->name} volvió a casa ",
                        'type' => 'news',
                        'pet_id' => $pet->id,
                        'is_active' => true,
                        'publish_at' => now()->subHours(rand(1, 48)),
                    ]);
                }

                // Creo varias lecturas para la placa QR (esto lo hizo "ella" porque yo ni idea, pero anda)
                $lat = -34.9011;
                $lng = -56.1645;

                $steps = rand(2, 5);

                for ($i = 0; $i < $steps; $i++) {

                    // movimiento suave (simula paseo / fuga)
                    $lat += rand(-20, 20) / 10000;
                    $lng += rand(-20, 20) / 10000;

                    Reading::create([
                        'qr_plate_id' => $qrPlate->id,
                        'user_id' => rand(0, 1) ? ($pet->owner?->user_id ?? $pet->owner_id) : null,
                        'cell_phone' => rand(0, 1) ? '099'.rand(100000,999999) : null,

                        'ip' => fake()->ipv4(),
                        'user_agent' => fake()->userAgent(),

                        'lat' => $lat,
                        'lng' => $lng,

                        'metadata' => ['source' => 'seed','event' => 'scan',],
                        'created_at' => now()->subMinutes($steps - $i),
                        'updated_at' => now(),
                    ]);

                }
                });
   }); // ← termina el each de owners

        
        // post de consejos  TIPS
        Post::updateOrCreate(
            ['title' => 'Escaneá el QR para ayudar a una mascota'],
            ['type' => 'tip', 'is_active' => true]
        );

        Post::updateOrCreate(
            ['title' => 'Si encontrás una mascota, reportala'],
            ['type' => 'tip', 'is_active' => true]
        );

        Post::updateOrCreate(
            ['title' => 'Mantené actualizada la info de tu mascota'],
            ['type' => 'tip', 'is_active' => true]
        );

        // Novedades (careteadas que escribe el admin)
        
        Post::create([
            'title' => 'ya somos 3000 (hechos con faker), gracias por sumarte ',
            'type' => 'news',
            'is_active' => true,
            'publish_at' => now()->subDays(1),
        ]);

        Post::create([
            'title' => 'Primera mascota recuperada usando QR',
            'type' => 'news',
            'is_active' => true,
            'publish_at' => now()->subHours(6),
        ]);
        }


}