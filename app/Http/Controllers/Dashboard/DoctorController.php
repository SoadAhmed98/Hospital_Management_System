<?php

namespace App\Http\Controllers\Dashboard;
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

   
    public function edit(string $id)
    {
        //
    }

   
    public function update(Request $request, string $id)
    {
        //
    }

   
    public function destroy(string $id)
    {
        //
    }
}
