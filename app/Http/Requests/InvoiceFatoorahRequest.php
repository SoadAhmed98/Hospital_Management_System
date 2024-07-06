<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceFatoorahRequest extends FormRequest
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
            'CustomerName'=>'required|string|max:255',
            'CustomerEmail' => 'required|exists:patients,email|email',
            'InvoiceValue'=>'required|integer',
            'doctor_id' => 'required|exists:doctors,id',
            'discount_value' => 'required|numeric',
            'tax_rate' => 'required|numeric',
            'type' => 'required|integer|in:1,2',
            'single_invoice' => 'required|boolean',
            'single_id' => 'required_if:single_invoice,1|exists:single_services,id',
            'group_id' => 'required_if:single_invoice,0|exists:group_services,id',
        ];
    }
}
