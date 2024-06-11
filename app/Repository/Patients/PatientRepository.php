<?php
namespace App\Repository\Patients;

use App\Interfaces\Patients\PatientRepositoryInterface;
use App\Models\Doctor;
use App\Models\Patient;

class PatientRepository implements PatientRepositoryInterface
{

    public function index()
    {
      $patients = Patient::all();
      return view('Dashboard.Patients.index',compact('Patients'));
    }

    public function store($request)
    {
        Patient::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        session()->flash('add');
        return redirect()->route('Patients.index');
    }

    public function update($request)
    {
        $patient = Patient::findOrFail($request->id);
        $patient->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        session()->flash('edit');
        return redirect()->route('Patients.index');
    }


    public function destroy($request)
    {
        Patient::findOrFail($request->id)->delete();
        session()->flash('delete');
        return redirect()->route('Patients.index');
    }

    public function show($id)
    {
        $doctors =Patient::findOrFail($id)->doctors;
        $patient = Patient::findOrFail($id);
       // return view('Dashboard.Patients.show_doctors',compact('doctors','Patient'));
    }

}