<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Patient extends Authenticatable
{
    use HasApiTokens,HasFactory,Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'birth_date',
        'phone',
        'gender',
        'blood_Group',
        'address', 
        'code'
    ];
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
    public function doctor()
    {
        return $this->belongsTo(Invoice::class,'doctor_id');
    }

    
}