<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Owner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;
//Hay que agregar a este formulario de registro la lógica de los QR
    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            //Campos extra para owner
            'docType' => ['required', 'string', 'max:50'],
            'docNum' => ['required', 'string', 'max:50'],
            'fName1' => ['required', 'string', 'max:50'],
            'fName2' => ['nullable', 'string', 'max:50'],
            'sName1' => ['required', 'string', 'max:50'],
            'sName2' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:20'],
            //Terminan campos extra de owner
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();
// Creo el usuario y lo guardo en una variable
        $user = User::create([
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

         // Asignar rol 'owner' al usuario recién creado
        $user->assignRole('owner');

// Crear el owner asociado al usuario registrado
    Owner::create([
        'user_id' => $user->id,
        'docType' => $input['docType'],
        'docNum' => $input['docNum'],
        'fName1' => $input['fName1'],
        'fName2' => $input['fName2'] ?? null,
        'sName1' => $input['sName1'],
        'sName2' => $input['sName2'] ?? null,
        'phone' => $input['phone'] ?? null,
    ]);
        // Devuelvo el usuario
        return $user;
        
    }
}
