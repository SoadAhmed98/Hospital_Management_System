<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'fees' => $this->consultation_fees,
            'department_id' => $this->department->id,
            'department_name' => $this->department->name,
            'image' => $this->image ? "http://127.0.0.1:80/Dashboard/img/doctors/" . $this->image->filename : null,
            'works_day' => $this->doctorworkschedule->pluck('day'),
          
        ];
    }
}
