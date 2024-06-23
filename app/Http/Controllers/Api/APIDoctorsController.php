<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
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
        $doctors = $this->doctors->index();
        return DoctorResource::collection($doctors);
    }

    public function show($id)
    {
        $doctor = $this->doctors->show($id);
        return new DoctorResource($doctor);
       
    }


}
