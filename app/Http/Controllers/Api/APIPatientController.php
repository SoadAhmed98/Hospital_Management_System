<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\Patients\PatientAPIRepositoryInterface;
use Illuminate\Http\Request;

class APIPatientController extends Controller
{
    private $patients;

    public function __construct(PatientAPIRepositoryInterface $patients)
    {
        $this->patients = $patients;
    }

    public function index()
    {
        return response()->json($this->patients->index());
    }

    public function show($id)
    {
        return response()->json($this->patients->show($id));
    }

    public function store(StorePatientRequest $request)
    {
        return response()->json($this->patients->store($request), 201);
    }

    public function update(StorePatientRequest $request, $id)
    {
        return response()->json($this->patients->update($request, $id));
    }

    public function destroy($id)
    {
        return response()->json($this->patients->destroy($id), 204);
    }

}
