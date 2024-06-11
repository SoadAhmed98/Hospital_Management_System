<?php
namespace App\Interfaces\Patients;


interface PatientRepositoryInterface
{

    // get All Patients
    public function index();

    // store Patients
    public function store($request);

    // Update Patients
    public function update($request);

    // destroy Patients
    public function destroy($request);

    // destroy Patients
    public function show($id);

}