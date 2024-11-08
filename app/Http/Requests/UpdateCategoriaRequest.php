<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoriaRequest extends FormRequest
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
            'nombre' => 'required|string|max:255',
            'interes' => 'required|numeric|min:0|max:100', // Validación para el porcentaje de interés
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no puede superar los 255 caracteres.',
            'interes.required' => 'El interés es obligatorio.',
            'interes.numeric' => 'El interés debe ser un número.',
            'interes.min' => 'El interés no puede ser menor que 0.',
            'interes.max' => 'El interés no puede ser mayor que 100.',
        ];
    }
}
