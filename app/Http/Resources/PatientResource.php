<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request):array
    {
        return [
            "id"=>$this->id,
            "name"=>$this->name,
            "email"=>$this->email,
            "phone"=>$this->phone,
            "address"=>$this->address,
            "birth_date"=>$this->birth_date,
            "gender"=>$this->gender,
            "blood_group"=>$this->blood_group,
            "code"=>$this->code,
            "code_expired_at"=>$this->code_expired_at,
            "email_verified_at"=>$this->email_verified_at,
            'image' => $this->image ? "http://127.0.0.1:80/Dashboard/img/patients/" . $this->image->filename :null,
           
        ];
    }
}
