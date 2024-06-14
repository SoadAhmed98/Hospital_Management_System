<?php

namespace App\Repository\Doctors;

use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\Doctors\DoctorAPIRepositoryInterface;

class DoctorAPIRepository implements DoctorAPIRepositoryInterface
{
    public function index()
    {
      
        $doctors = Doctor::with('image')->get();

        return   $doctorsData = $doctors->map(function($doctor) {
            $doctorData = $doctor->toArray();
            $image = $doctor->image;
            if ($image) {
                $doctorData['image'] = "http://127.0.0.1:80/Dashboard/img/doctors/".$image->filename; 
            } else {
                $doctorData['image'] = null;
            }

            return $doctorData;
        });
       
    }

    public function show($id)
    {
        $doctor = Doctor::with('image')->findOrFail($id);

        $doctorWithimage = $doctor->toArray();
    
        if ($doctor->image) {
            $doctorWithimage['image'] = "http://127.0.0.1:80/Dashboard/img/doctors/" . $doctor->image->filename;
        } else {
            $doctorWithimage['image'] = null;
        }

        return $doctorWithimage;
       
    }

    // public function store($request)
    // {
    //     return Doctor::create([
    //         'name' => $request->input('name'),
    //         'email' => $request->input('description'),
    //     ]);
    // }


}
