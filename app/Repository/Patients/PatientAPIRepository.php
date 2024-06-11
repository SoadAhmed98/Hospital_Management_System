<?php

namespace App\Repository\Patients;

use App\Interfaces\Patients\PatientAPIRepositoryInterface;
use App\Models\Patient;

class PatientAPIRepository implements PatientAPIRepositoryInterface
{public function index()
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
            'description' => $request->input('description'),
        ]);
    }

    public function update($request, $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        return $patient;
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return $patient;
    }
}
