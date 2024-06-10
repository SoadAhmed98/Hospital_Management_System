<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\Departments\DepartmentRepositoryInterface;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    private $Departments;

    public function __construct(DepartmentRepositoryInterface $Departments)
    {
        $this->Departments = $Departments;
    }

    public function index()
    {
      return  $this->Departments->index();

    }

    public function show($id)
    {
       return $this->Departments->show($id);
    }


    public function store(Request $request)
    {
        return $this->Departments->store($request);
    }


    public function update(Request $request)
    {
        return $this->Departments->update($request);
    }


    public function destroy(Request $request)
    {
        return $this->Departments->destroy($request);
    }
}