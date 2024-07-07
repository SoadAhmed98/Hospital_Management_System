<?php

namespace App\Repository\Patients;

use App\Interfaces\Patients\PatientRepositoryInterface;
use App\Models\Patient;
use App\Models\Invoice;
use App\Models\PatientAccount;
use App\Models\ReceiptAccount;
use App\Models\PatientHistory;
use App\Models\Laboratorie;

use Illuminate\Support\Facades\Hash;

class PatientRepository implements PatientRepositoryInterface
{
    public function index()
    {
        $patients = Patient::all();
        return view('Dashboard.Patients.index', compact('patients'));
    }

    public function show($id)
    {
        $Patient = Patient::findOrFail($id);
        // You can include other related data if needed
        $invoices = Invoice::where('patient_id', $id)->get();
        $receipt_accounts = ReceiptAccount::where('patient_id', $id)->get();
        $Patient_accounts = PatientAccount::where('patient_id', $id)->get();
        $patient_records = PatientHistory::where('patient_id',$id)->get();
        $patient_Laboratories  = Laboratorie::where('patient_id',$id)->get();

        return view('Dashboard.Patients.show', compact('Patient', 'invoices', 'Patient_accounts','receipt_accounts','patient_records','patient_Laboratories'));

    }

    public function create()
    {
        return view('Dashboard.Patients.create');
    }

    public function store($request)
    {
        try {
            $patient = new Patient();
            $patient->email = $request->email;
            $patient->password = Hash::make($request->phone);
            $patient->birth_date = $request->birth_date;
            $patient->phone = $request->phone;
            $patient->gender = $request->gender;
            $patient->blood_group = $request->blood_group;
            $patient->name = $request->name;
            $patient->address = $request->address; // Added address
            $patient->save();
            session()->flash('add');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('Dashboard.Patients.edit', compact('patient'));
    }

    public function update($request)
    {
        $patient = Patient::findOrFail($request->id);
        $patient->email = $request->email;
        $patient->password = Hash::make($request->phone);
        $patient->birth_date = $request->birth_date;
        $patient->phone = $request->phone;
        $patient->gender = $request->gender;
        $patient->blood_group = $request->blood_group;
        $patient->name = $request->name;
        $patient->address = $request->address; // Added address
        $patient->save();
        session()->flash('edit');
        return redirect()->route('Patients.index');
    }

    public function destroy($request)
    {
        Patient::destroy($request->id);
        session()->flash('delete');
        return redirect()->back();
    }
}
