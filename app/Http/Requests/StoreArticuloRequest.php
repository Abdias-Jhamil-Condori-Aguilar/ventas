<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticuloRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => 'required|string|max:20|unique:articulos,codigo',
            'nombre' => 'required|string|max:45',
            'descripcion' => 'nullable|string|max:255',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categoria_id' => 'required|integer|exists:categorias,id',
        ];
    }

    public function attributes()
    {
        return [
            'categoria_id' => 'categoría',
        ];
    }

    public function messages()
    {
        return [
            'codigo.required' => 'El campo código es obligatorio.',
            'nombre.required' => 'El nombre del artículo es obligatorio.',
            'descripcion.required' => 'La descripción del artículo es obligatoria.',
            'img_path.image' => 'El archivo debe ser una imagen.',
            'img_path.mimes' => 'La imagen debe ser de tipo jpeg, png o jpg.',
            'img_path.max' => 'La imagen no debe superar los 2MB.',
            'categoria_id.required' => 'Debe seleccionar una categoría.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
        ];
    }
}
