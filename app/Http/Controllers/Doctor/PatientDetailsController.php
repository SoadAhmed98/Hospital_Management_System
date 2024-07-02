<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\PatientHistory;
use App\Models\Laboratorie;
use Illuminate\Http\Request;

class PatientDetailsController extends Controller
{
    public function index($id){

        $patient_records = PatientHistory::where('patient_id',$id)->get();
        $patient_Laboratories  = Laboratorie::where('patient_id',$id)->get();
        return view('Dashboard.Doctors.Invoices.patient_details',compact('patient_records','patient_Laboratories'));
    }
}