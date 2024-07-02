<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'department_id',
        'name',
        'email',
        'phone',
        'notes',
        'type', 
        'appointment', 
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function appointmentDoctors()
    {
        return $this->hasMany(AppointmentDoctor::class);
    }
}
