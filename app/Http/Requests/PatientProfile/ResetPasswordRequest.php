<?php

namespace App\Http\Requests\PatientProfile;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
        'password' => 'required|regex:/^(?=.*?[A-Za-z])(?=.*?[@$!%*?&])(?=.*?[0-9]).{8,}$/|confirmed',
        ];
    }
    public function messages()
    {
        return [
            'password.regex' => 'Password must be at least 8 characters and contain a mix of lowercase and uppercase letters, numbers, and at least one special character.',
        ];
    }
}
