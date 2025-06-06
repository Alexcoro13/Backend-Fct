<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LikeRequest extends FormRequest
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
            'id_post' => [
                'required_without:id_comentario',
                'nullable',
                'prohibits:id_comentario',
                'integer',
                'exists:post,id'
            ],
            'id_comentario' => [
                'required_without:id_post',
                'nullable',
                'prohibits:id_post',
                'integer',
                'exists:comentarios,id'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id_post.integer' => 'El id_post debe ser un número entero',
            'id_post.exists' => 'El id_post no existe en la base de datos',
            'id_post.required_without' => 'El id_post es un dato obligatorio si no se proporciona id_comentario',
            'id_post.prohibits' => 'No se puede proporcionar id_post e id_comentario simultáneamente',
            'id_comentario.integer' => 'El id_comentario debe ser un número entero',
            'id_comentario.exists' => 'El id_comentario no existe en la base de datos',
            'id_comentario.required_without' => 'El id_comentario es un dato obligatorio si no se proporciona id_post',
            'id_comentario.prohibits' => 'No se puede proporcionar id_comentario e id_post simultáneamente',
        ];

    }
}
