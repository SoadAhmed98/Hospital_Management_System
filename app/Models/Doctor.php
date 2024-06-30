<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Doctor extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    public $fillable= ['email','email_verified_at','password','phone','consultation_fees','name','department_id','status'];
   
     /**
     * Get the Doctor's image.
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
     // One To One get section of Doctor
     public function department()
     {
         return $this->belongsTo(Department::class);
     }
     public function doctorworkschedule()
     {
         return $this->belongsToMany(WorkSchedule::class,'doctor_work_schedule');
     }
     public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function appointmentDoctors()
    {
        return $this->hasMany(AppointmentDoctor::class);
    }
         /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
