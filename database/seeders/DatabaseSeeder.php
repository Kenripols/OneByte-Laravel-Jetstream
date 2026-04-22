<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Owner;
use App\Models\Breed;
use App\Models\Pet;
use App\Models\Reading;
use App\Models\QRPlate;
use App\Models\QrMessage;

use App\Enums\QREventType;
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
        $adminUser = User::firstOrCreate(
            ['email' => 'ken.rip2@gmail.com'],
            ['password' => bcrypt('12345678')]// Creo usuario Admin precargado
        );

        $adminUser->assignRole('admin');// Asigno el rol de admin al usuario creado

        //Usuario Owner de prueba
        $ownerUser = User::firstOrCreate(
            ['email' => 'gvilarino1727@gmail.com'],
            ['password' => bcrypt('12345678')]
        );

        $ownerUser->assignRole('owner');

       

        //QR DE REGISTRO         
        $qr = QRPlate::create([
            'code' => (string) Str::uuid(),
            'batch_id' => 1,
        ]);

        $qr->addEvent(QREventType::GENERATED, now()->subDays(10));
        $qr->addEvent(QREventType::DOWNLOADED, now()->subDays(5));
        $qr->addEvent(QREventType::CLAIMED, now(), [
            'user_id' => $ownerUser->id,
        ]);
           
         //Crear registro en owners
       Owner::updateOrCreate([
            'user_id' => $ownerUser->id],
        [
            'docType' => 1,
            'docNum' => '12345678',
            'fName1' => 'Gabriel',
            'sName1' => 'Vila',
            'registration_qr_id' => $qr->id//a mi owner le pongo un qr
        ]
        );

        // Crear registro en owners
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
                'owner_id' => $owner->id,
                'breed_id' => $breeds->random()->id,
            ])->each(function ($pet) {

                // Creo la placa QR para la mascota
                $qrPlate = QRPlate::create([
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

                // Creo varias lecturas para la placa QR (esto lo hizo "ella" porque yo ni idea, pero anda)
                $lat = -34.9011;
                $lng = -56.1645;

                $steps = rand(15, 40);

                for ($i = 0; $i < $steps; $i++) {

                    // movimiento suave (simula paseo / fuga)
                    $lat += rand(-20, 20) / 10000;
                    $lng += rand(-20, 20) / 10000;

                    Reading::create([
                        'qr_plate_id' => $qrPlate->id,
                        'user_id' => rand(0, 1) ? $pet->owner->user_id : null,
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
            });
        }
}