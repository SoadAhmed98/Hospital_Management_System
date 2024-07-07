<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    // protected $table = 'Services';

    public $fillable= ['price','description','status','name'];
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'service_group')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
                       