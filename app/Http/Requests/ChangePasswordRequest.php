<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'old_password' => 'required|string',
            'new_password' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'old_password.required' => 'The old password is required',
            'old_password.string' => 'The old password must be a string',
            'new_password.required' => 'The new password is required',
            'new_password.string' => 'The new password must be a string'
        ];
    }
}
