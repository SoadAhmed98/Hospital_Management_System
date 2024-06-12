<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Patient extends Authenticatable
{
    use HasFactory;
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