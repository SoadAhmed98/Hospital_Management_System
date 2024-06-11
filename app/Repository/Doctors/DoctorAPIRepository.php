<?php

namespace App\Repository\Departments;

use App\Interfaces\Departments\DoctorAPIRepositoryInterface;
use App\Models\Doctor;

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

    // public function update($request, $id)
    // {
    //     $department = Department::findOrFail($id);
    //     $department->update([
    //         'name' => $request->input('name'),
    //         'description' => $request->input('description'),
    //     ]);
    //     return $department;
    // }

    // public function destroy($id)
    // {
    //     $department = Department::findOrFail($id);
    //     $department->delete();
    //     return $department;
    // }
}
