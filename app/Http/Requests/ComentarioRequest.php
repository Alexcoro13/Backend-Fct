<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComentarioRequest extends FormRequest
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
            'texto' => 'required|string|max:1000',
            'id_post' => 'required|integer|exists:post,id',
        ];
    }

    public function messages(): array
    {
        return [
            'texto.required' => 'The text field is required.',
            'texto.string' => 'The text field must be a string.',
            'texto.max' => 'The text field cannot be longer than 1000 characters.',
            'id_post.required' => 'The post ID field is required.',
            'id_post.integer' => 'The post ID must be an integer.',
            'id_post.exists' => 'The provided post ID does not exist in the database.',
        ];
    }
}
