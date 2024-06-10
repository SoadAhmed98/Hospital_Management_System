<?php
namespace App\Repository\Departments;

use App\Interfaces\Departments\DepartmentRepositoryInterface;
use App\Models\Doctor;
use App\Models\Department;

class DepartmentRepository implements DepartmentRepositoryInterface
{

    public function index()
    {
      $departments = Department::all();
      return view('Dashboard.Departments.index',compact('departments'));
    }

    public function store($request)
    {
        Department::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        session()->flash('add');
        return redirect()->route('Departments.index');
    }

    public function update($request)
    {
        $department = Department::findOrFail($request->id);
        $department->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        session()->flash('edit');
        return redirect()->route('Departments.index');
    }


    public function destroy($request)
    {
        Department::findOrFail($request->id)->delete();
        session()->flash('delete');
        return redirect()->route('Departments.index');
    }

    public function show($id)
    {
        $doctors =Department::findOrFail($id)->doctors;
        $department = Department::findOrFail($id);
       // return view('Dashboard.Departments.show_doctors',compact('doctors','department'));
    }

}