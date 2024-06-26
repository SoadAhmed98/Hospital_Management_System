<?php
namespace App\Interfaces\Patients;


interface PatientAPIRepositoryInterface
{

    public function index();

    public function show($id);

    public function store($request);

    public function update($request, $id);

    public function create();

    public function destroy($id);

}