<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticuloRequest extends FormRequest
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
            'codigo' => 'required|string|max:20|unique:articulos,codigo', // Validación para el código único
            'nombre' => 'required|string|max:45',
            'descripcion' => 'required|string',
            'estado' => 'nullable|integer|in:0,1', // Validación para el estado (0 o 1)
            'categoria_id' => 'nullable|exists:categorias,id', // Validación para la relación con categorías
            'img_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ];
    }
}
