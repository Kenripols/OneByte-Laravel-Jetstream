<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'docType' => 'required|string|max:255',
        'docNum' => 'required|string|max:255',
        'fName1' => 'required|string|max:255',
        'fName2' => 'nullable|string|max:255',
        'sName1' => 'required|string|max:255',
        'sName2' => 'nullable|string|max:255',
    ];
}
}
