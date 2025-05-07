<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EntrenamientoRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'min: 5', 'max:1000'],
            'ejercicios' => ['required', 'array'],
            'duracion' => ['required', 'integer', 'min: 1'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es un dato obligatorio',
            'nombre.max' => 'El nombre ha de tener menos de 255 caracteres',
            'descripcion.string' => 'La descripción debe ser una cadena de caracteres',
            'descripcion.min' => 'La descripción debe tener al menos 5 caracteres',
            'descripcion.max' => 'La descripción no puede superar los 1000 caracteres',
            'ejercicios.required' => 'Los ejercicios son un dato obligatorio',
            'ejercicios.json' => 'Los ejercicios deben estar en formato de json',
            'duracion.required' => 'La duración es un dato obligatorio',
            'duracion.integer' => 'La duración debe ser un número entero',
            'duracion.min' => 'La duración debe ser al menos 1 minuto',
        ];
    }
}
