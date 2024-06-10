<?php

namespace App\Repository\Departments;

use App\Interfaces\Departments\DepartmentAPIRepositoryInterface;
use App\Models\Department;

class DepartmentAPIRepository implements DepartmentAPIRepositoryInterface
{public function index()
    {
        return Department::all();
    }

    public function show($id)
    {
        return Department::findOrFail($id);
    }

    public function store($request)
    {
        return Department::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
    }

    public function update($request, $id)
    {
        $department = Department::findOrFail($id);
        $department->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        return $department;
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return $department;
    }
}
