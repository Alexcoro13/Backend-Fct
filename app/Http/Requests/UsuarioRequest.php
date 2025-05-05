<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UsuarioRequest extends FormRequest
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
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', Rule::email(), 'unique:usuarios'],
            'password' => ['required', 'string'],
            'apellidos' => ['required', 'string', 'max:255'],
            'nombre_usuario' => ['required', 'string', 'max:255', 'unique:usuarios'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es un dato obligatorio',
            'nombre.max' => 'El nombre ha de tener menos de 255 caracteres',
            'email.required' => 'El email es un dato obligatorio',
            'email.email' => 'El formato del email debe ser un formato valido',
            'password.required' => 'La contraseña es un dato obligatorio',
            'apellidos.required' => 'El apellidos es un dato obligatorio',
            'apellidos.max' => 'El apellidos ha de tener menos de 255 caracteres',
            'nombre_usuario.required' => 'El nombre de usuario es un dato obligatorio',
            'nombre_usuario.unique' => 'El nombre de usuario ya existe',
            'nombre_usuario.max' => 'El nombre de usuario ha de tener menos de 255 caracteres',
        ];
    }
}
