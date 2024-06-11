<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\Patients\PatientRepositoryInterface;
use Illuminate\Http\Request;

class PatientController extends Controller
{

    private $Patients;

    public function __construct(PatientRepositoryInterface $Patients)
    {
        $this->Patients = $Patients;
    }

    public function index()
    {
      return  $this->Patients->index();

    }

    public function show($id)
    {
       return $this->Patients->show($id);
    }


    public function store(Request $request)
    {
        return $this->Patients->store($request);
    }


    public function update(Request $request)
    {
        return $this->Patients->update($request);
    }


    public function destroy(Request $request)
    {
        return $this->Patients->destroy($request);
    }
}