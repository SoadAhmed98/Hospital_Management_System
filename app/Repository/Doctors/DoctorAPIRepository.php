<?php

namespace App\Repository\Doctors;

use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\Doctors\DoctorAPIRepositoryInterface;

class DoctorAPIRepository implements DoctorAPIRepositoryInterface
{
    public function index()
    {
      
        return Doctor::with('image')->where('status', 1)->get();
   
    }

    public function show($id)
    {
        return Doctor::with('image')->where('status', 1)->findOrFail($id);

    }


}
