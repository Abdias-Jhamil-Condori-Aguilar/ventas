<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
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
            'papellido' => 'required|string|max:255',
            'sapellido' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'correo_electronico' => 'nullable|email|max:255|unique:clientes,correo_electronico',
            'telefono' => 'required|string|max:15|unique:clientes,telefono',
            'domicilio' => 'required|string|max:255',
            'ciudad' => 'required|string|max:100',
            'tipo_documento_id' => 'required|exists:tipo_documentos,id',
            'numero_identificacion' => 'required|string|max:20|unique:clientes,numero_identificacion',
        ];
    }
}
