<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Interfaces\Doctors\DoctorAPIRepositoryInterface;

class APIDoctorsController extends Controller
{
    private $doctors;

    public function __construct(DoctorAPIRepositoryInterface $doctors)
    {
        $this->doctors = $doctors;
    }

    public function index()
    {
        return response()->json($this->doctors->index());
    }

    public function show($id)
    {
        return response()->json($this->doctors->show($id));
    }

    // public function store(Request $request)
    // {
    //     return response()->json($this->departments->store($request), 201);
    // }

    // public function update(Request $request, $id)
    // {
    //     return response()->json($this->departments->update($request, $id));
    // }

    // public function destroy($id)
    // {
    //     return response()->json($this->departments->destroy($id), 204);
    // }

}
