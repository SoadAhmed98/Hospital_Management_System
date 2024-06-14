<?php

namespace App\Repository\Doctors;

use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\Doctors\DoctorAPIRepositoryInterface;

class DoctorAPIRepository implements DoctorAPIRepositoryInterface
{
    public function index()
    {
        return Doctor::with('image')->get();
    }

    public function show($id)
    {
        return Doctor::with('image')->findOrFail($id);
       
    }

    // public function store($request)
    // {
    //     return Doctor::create([
    //         'name' => $request->input('name'),
    //         'email' => $request->input('description'),
    //     ]);
    // }


}
