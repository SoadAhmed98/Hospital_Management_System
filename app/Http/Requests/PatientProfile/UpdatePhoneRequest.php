<?php

namespace App\Http\Requests\PatientProfile;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhoneRequest extends FormRequest
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
           'phone' => 'required|regex:/^01[0125][0-9]{8}$/|unique:patients,phone,' . $this->user()->id,
        ];
    }
    public function messages()
    {
        return [
            'phone.regex' => 'The phone number format is invalid.',
        ];
    }
}
