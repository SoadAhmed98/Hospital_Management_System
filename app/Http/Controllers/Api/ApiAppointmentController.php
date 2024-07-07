<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\Appointmentes\AppointmentAPIRepositoryInterface;

class ApiAppointmentController extends Controller
{
    private $appointment;

    public function __construct(AppointmentAPIRepositoryInterface $appointment)
    {
        $this->appointment = $appointment;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);
        return response()->json($this->appointment->store($validatedData), 201);
    }
}
