<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeguidoresRequest extends FormRequest
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
            "id_seguido" => ["required", "integer", "exists:usuarios,id"],
        ];
    }

    public function messages(): array
    {
        return [
            "id_seguido.required" => "The follower ID is required.",
            "id_seguido.integer" => "The follower ID must be an integer.",
            "id_seguido.exists" => "The follower ID does not exist in the users table.",
        ];
    }
}
