<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    public $fillable= ['Total_before_discount','discount_value','Total_after_discount','tax_rate','Total_with_tax','name','notes'];
    public $timestamps = false;
    public function service_group()
    {
        return $this->belongsToMany(Service::class,'service_group');
    }
}
