<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'doctype' => 'required|string|max:255',
        'docnum' => 'required|string|max:255',
        'fname' => 'required|string|max:255',
        'fname2' => 'nullable|string|max:255',
        'sname1' => 'required|string|max:255',
        'sname2' => 'nullable|string|max:255',
    ];
}
}
