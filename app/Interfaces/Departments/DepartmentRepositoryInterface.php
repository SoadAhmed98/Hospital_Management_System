<?php
namespace App\Interfaces\Departments;


interface DepartmentRepositoryInterface
{

    // get All Departments
    public function index();

    // store Departments
    public function store($request);

    // Update Departments
    public function update($request);

    // destroy Departments
    public function destroy($request);

    // destroy Departments
    public function show($id);

}