<?php

namespace App\Repository\LaboratorieEmployee;

use App\Interfaces\LaboratorieEmployee\LaboratorieEmployeeRepositoryInterface;
use App\Models\LaboratoryEmployee;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class LaboratorieEmployeeRepository implements LaboratorieEmployeeRepositoryInterface
{

    public function index()
    {
        $laboratorie_employees = LaboratoryEmployee::all();
        return view('Dashboard.LaboratoryEmployee.index',compact('laboratorie_employees'));
    }

    public function store($request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:laboratory_employees|max:255',
                'password' => 'required|string|min:8',
            ]);

            $laboratorie_employee = new LaboratoryEmployee();
            $laboratorie_employee->name = $validatedData['name'];
            $laboratorie_employee->email = $validatedData['email'];
            $laboratorie_employee->password = Hash::make($validatedData['password']);
            $laboratorie_employee->save();

            session()->flash('add', 'Employee added successfully.');

            return back();
        } catch (ValidationException $e) {
            throw $e; // Let Laravel handle validation exceptions
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update($request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:laboratory_employees,email,' . $id,
                'password' => 'nullable|string|min:8',
            ]);
    
            $laboratorie_employee = LaboratoryEmployee::find($id);
            $laboratorie_employee->name = $validatedData['name'];
            $laboratorie_employee->email = $validatedData['email'];
    
            // Update password only if provided
            if (!empty($validatedData['password'])) {
                $laboratorie_employee->password = Hash::make($validatedData['password']);
            }
    
            $laboratorie_employee->save();
    
            session()->flash('edit', 'Employee updated successfully.');
    
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    


    public function destroy($id)
    {
        try {
            LaboratoryEmployee::destroy($id);
            session()->flash('delete');
            return redirect()->back();
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}