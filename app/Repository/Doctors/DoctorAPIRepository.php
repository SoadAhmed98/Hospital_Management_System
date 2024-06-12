<?php

namespace App\Repository\Departments;

use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\Departments\DoctorAPIRepositoryInterface;

class DoctorAPIRepository implements DoctorAPIRepositoryInterface
{public function index()
    {
        return Doctor::all();
    }

    public function show($id)
    {
        return Doctor::findOrFail($id);
    }

    public function store($request)
    {
        return Doctor::create([
            'name' => $request->input('name'),
            'email' => $request->input('description'),
        ]);
    }


}
