<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Postrequest extends FormRequest
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
            'titulo' => ['required', 'string', 'max:255'],
            'texto' => ['nullable', 'string'],
            'imagen' => ['nullable', 'file', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título es un dato obligatorio',
            'titulo.max' => 'El título ha de tener menos de 255 caracteres',
            'texto.string' => 'El texto debe ser una cadena de caracteres',
            'imagen.max' => 'La imagen no puede superar los 2MB',
        ];
    }
}
