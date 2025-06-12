<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuarioUpdateRequest extends FormRequest
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
            'nombre' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', Rule::email(), 'unique:usuarios'],
            'apellidos' => ['nullable', 'string', 'max:255'],
            'nombre_usuario' => ['nullable', 'string', 'max:255', 'unique:usuarios'],
            'visibilidad' => ['nullable', 'boolean'],
            'estado' => ['nullable', 'boolean'],
            'avatar' => 'nullable', 'file', 'max:1024'
         ];
    }

    public function messages(): array
    {
        return [
            'nombre.max' => 'El nombre ha de tener menos de 255 caracteres',
            'email.email' => 'El formato del email debe ser un formato valido',
            'apellidos.max' => 'El apellidos ha de tener menos de 255 caracteres',
            'nombre_usuario.unique' => 'El nombre de usuario ya existe',
            'nombre_usuario.max' => 'El nombre de usuario ha de tener menos de 255 caracteres',
            'visibilidad.boolean' => 'La visibilidad debe ser un valor booleano',
            'estado.boolean' => 'El estado debe ser un valor booleano',
            'avatar.file' => 'El avatar debe ser una imagen válida',
            'avatar.max' => 'La imagen no debe superar 1MB',
        ];
    }
}
