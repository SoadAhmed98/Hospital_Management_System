<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\Contracts\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Patient extends Model
{
    use HasFactory,Notifiable;
    protected $fillable = [
        'email',
        'Password',
        'birth_date',
        'Phone',
        'Gender',
        'Blood_Group',
        'address', 
    ];
    public function doctor()
    {
        return $this->belongsTo(Invoice::class,'doctor_id');
    }

    
}