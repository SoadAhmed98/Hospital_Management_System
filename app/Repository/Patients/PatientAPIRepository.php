<?php

namespace App\Repository\Patients;

use App\Interfaces\Patients\PatientAPIRepositoryInterface;
use App\Models\Patient;

class PatientAPIRepository implements PatientAPIRepositoryInterface
{
    public function index()
    {
        return Patient::all();
    }

    public function show($id)
    {
        return Patient::findOrFail($id);
    }

    public function store($request)
    {
        return Patient::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'birth_date' => $request->input('birth_date'),
            'phone' => $request->input('phone'),
            'gender' => $request->input('gender'),
            'blood_group' => $request->input('blood_group'),
            'address' => $request->input('address'),
        ]);
    }

    public function update($request, $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'birth_date' => $request->input('birth_date'),
            'phone' => $request->input('phone'),
            'gender' => $request->input('gender'),
            'blood_group' => $request->input('blood_group'),
            'address' => $request->input('address'),
        ]);
        return $patient;
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return $patient;
    }
    public function create()
    {
        return new Patient();
    }
}
