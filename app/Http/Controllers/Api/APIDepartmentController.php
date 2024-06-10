<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\Departments\DepartmentAPIRepositoryInterface;
use Illuminate\Http\Request;

class APIDepartmentController extends Controller
{
    private $departments;

    public function __construct(DepartmentAPIRepositoryInterface $departments)
    {
        $this->departments = $departments;
    }

    public function index()
    {
        return response()->json($this->departments->index());
    }

    public function show($id)
    {
        return response()->json($this->departments->show($id));
    }

    public function store(Request $request)
    {
        return response()->json($this->departments->store($request), 201);
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->departments->update($request, $id));
    }

    public function destroy($id)
    {
        return response()->json($this->departments->destroy($id), 204);
    }

}
