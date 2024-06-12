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
        return $this->Doctors->store($request);
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
