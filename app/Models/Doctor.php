<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;

class Doctor extends Model
{
    use HasFactory;
    public $fillable= ['email','email_verified_at','password','phone','price','name','appointments'];

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
}
