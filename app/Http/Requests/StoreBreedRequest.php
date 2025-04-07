<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBreedRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true; // Cambia esto si necesitas lógica de autorización
    }

    /**
     * Reglas de validación para la solicitud.
     */
    public function rules(): array
    {
        return [
            'animalType' => 'required|string|max:255',
            'breedName' => 'required|string|max:255',
            'size' => 'required|string|max:255',
        ];
    }
}
