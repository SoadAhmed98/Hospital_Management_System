<?php
namespace App\Interfaces\Departments;


interface DepartmentAPIRepositoryInterface
{

    public function index();

    public function show($id);

    public function store($request);

    public function update($request, $id);

    public function destroy($id);

}