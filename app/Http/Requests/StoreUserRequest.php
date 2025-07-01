<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'doctype' => 'required|string|max:255',
            'docnum' => 'required|string|max:255',
            'fname' => 'required|string|max:255',
            'fname2' => 'string|max:255',
            'sname1' => 'required|string|max:255',
            'sname2' => 'string|max:255',
        ];
    }
}

