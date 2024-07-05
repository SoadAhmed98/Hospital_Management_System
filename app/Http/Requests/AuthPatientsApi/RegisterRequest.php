<?php

namespace App\Http\Requests\AuthPatientsApi;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|regex:/^[a-zA-Z0-9]+@[a-zA-Z]+(\.[a-zA-Z]{2,})+$/|unique:patients,email',
            'password' => 'required|regex:/^(?=.*?[A-Za-z])(?=.*?[@$!%*?&])(?=.*?[0-9]).{8,}$/|confirmed',
            'phone' => 'required|regex:/^01[0125][0-9]{8}$/',
            'address' => 'required|string|max:255',
            'birth_date' => 'required|date|before_or_equal:today',
            'gender' => 'required|in:male,female',
            'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        ];
    }
    public function messages()
    {
        return [
            'email.regex' => 'The email format is invalid.',
            'password.regex' => 'Password must be at least 8 characters and contain a mix of lowercase and uppercase letters, numbers, and at least one special character.',
            'phone.regex' => 'The phone number format is invalid.',
        ];
    }
}
