<?php

namespace App\Http\Controllers\Doctor;
use App\Models\Doctor;
use App\Interfaces\Doctors\DoctorRepositoryInterface;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    private $Doctors;

    public function __construct(DoctorRepositoryInterface $Doctors)
    {
        $this->Doctors = $Doctors;
    }
   
    public function index()
    {
        // $doctors=Doctor::all();
        // // dd($doctor);
        // return view('Dashboard.Doctors.index', ['doctors' => $doctors]);
        return  $this->Doctors->index();
    }

    public function create()
    {
        return $this->Doctors->create();
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:doctors,email',
            'password' => 'required|min:8',
            'department_id' => 'required|exists:departments,id',
            'phone' => 'required|numeric|digits_between:10,15',
            'fees' => 'required|numeric|min:0',
            'name' => 'required|string|max:255',
            'workschedule' => 'required|array|min:1', // Ensure at least one work schedule is selected
            'workschedule.*' => 'exists:work_schedules,id',
            'expertise' => 'required|string|max:255', 
            'education' => 'required|string', 
            'experience' => 'required|string', 
            'profession' => 'required|string|max:255', 
        ]);
        return $this->Doctors->store($request);
        return redirect()->route('doctors.index')->with('success', 'Doctor added successfully.');
    }

    
    public function show(string $id)
    {
        //
    }

   
    public function edit($id)
    {
        return $this->Doctors->edit($id);
    }


   
    public function update(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email|unique:doctors,email,'.$request->id,
            'department_id' => 'required|exists:departments,id',
            'phone' => 'required|numeric|digits_between:10,15',
            'fees' => 'required|numeric|min:0',
            'name' => 'required|string|max:255',
            'workschedule' => 'required|array|min:1', // Ensure at least one work schedule is selected
            'workschedule.*' => 'exists:work_schedules,id',
            'expertise' => 'required|string|max:255', 
            'education' => 'required|string', 
            'experience' => 'required|string', 
            'profession' => 'required|string|max:255', 
        ]);
        return $this->Doctors->update($request);
    }


   
    public function destroy(Request $request)
    {
        return $this->Doctors->destroy($request);
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);

        return $this->Doctors->update_password($request);
    }

    public function update_status(Request $request)
    {
        $request->validate([
            'status' => 'required|in:0,1',
        ]);
        return $this->Doctors->update_status($request);
    }
}
