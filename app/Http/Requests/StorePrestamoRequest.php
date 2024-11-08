<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrestamoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'intere_id' => 'required|exists:interes,id', // Corregido: interes_id
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'monto' => 'required|numeric|min:0',
            'categoria_producto_id' => 'required|exists:categoria_productos,id',
            'descripcion' => 'required|string|max:255',
            'modelo' => 'required|string|max:50',
            'marca' => 'required|string|max:50',
            'serie' => 'nullable|string|max:255|unique:prendas,serie', // Campo serie puede ser nulo pero único
            'observaciones' => 'nullable|string|max:255',
            'meses' => 'required|integer|min:1', // La duración en meses debe ser al menos 1
            'estado' => 'required|string|in:activo,pagado,vencido', // Validación para estado (activo, pagado, vencido)
            'codigo' => 'required|string|max:255', // Corregido: codigo

        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'cliente_id.required' => 'El cliente es obligatorio.',
            'cliente_id.exists' => 'El cliente seleccionado no existe.',
            'interes_id.required' => 'El tipo de interés es obligatorio.', // Corregido: interes_id
            'interes_id.exists' => 'El interés seleccionado no existe.', // Corregido: interes_id
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio no es válida.',
            'fecha_fin.required' => 'La fecha de fin es obligatoria.',
            'fecha_fin.date' => 'La fecha de fin no es válida.',
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
            'monto.required' => 'El monto del préstamo es obligatorio.',
            'monto.numeric' => 'El monto debe ser un valor numérico.',
            'monto.min' => 'El monto debe ser al menos 0.',
            'categoria_producto_id.required' => 'La categoría del producto es obligatoria.',
            'categoria_producto_id.exists' => 'La categoría seleccionada no existe.',
            'codigo.required' => 'El código del producto es obligatorio.', // Corregido: codigo
            'descripcion.required' => 'La descripción del producto es obligatoria.',
            'descripcion.max' => 'La descripción no puede exceder los 255 caracteres.',
            'modelo.required' => 'El modelo del producto es obligatorio.',
            'modelo.max' => 'El modelo no puede exceder los 50 caracteres.',
            'marca.required' => 'La marca del producto es obligatoria.',
            'marca.max' => 'La marca no puede exceder los 50 caracteres.',
            'serie.unique' => 'El número de serie ya está registrado.',
            'observaciones.max' => 'Las observaciones no pueden exceder los 255 caracteres.',
            'meses.required' => 'El número de meses es obligatorio.',
            'meses.min' => 'El número de meses debe ser al menos 1.',
            'estado.required' => 'El estado del préstamo es obligatorio.',
            'estado.in' => 'El estado debe ser uno de los siguientes: activo, pagado o vencido.'
        ];
    }
}
