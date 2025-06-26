<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBreedRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar el request
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para el request
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
