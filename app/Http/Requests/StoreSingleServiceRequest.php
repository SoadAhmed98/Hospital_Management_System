<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSingleServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    
     public function rules()
     {
         return [
             'name' => 'required|string|max:255',
             'price' => 'required|numeric|min:0',
             'description' => 'required|string',
         ];
     }
 
     public function messages()
     {
         return [
             'name.required' => 'The name field is required.',
             'price.required' => 'The price field is required.',
             'price.numeric' => 'The price must be a number.',
             'description.required' => 'The description field is required.',
         ];
     }
}
