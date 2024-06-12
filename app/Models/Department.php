<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable =['name','description'];
    use HasFactory;
    // public function doctors()
    // {
    //     return $this->hasMany(Doctor::class);
    // }
}
