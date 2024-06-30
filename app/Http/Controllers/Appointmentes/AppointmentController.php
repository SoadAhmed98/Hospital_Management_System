<?php

namespace App\Http\Controllers\Appointmentes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Appointmentes\AppointmentRepositoryInterface;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    protected $appointmentRepository;

    public function __construct(AppointmentRepositoryInterface $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
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

        Log::info('Validated Data:', $validatedData);

        try {
            $appointment = $this->appointmentRepository->create($validatedData);
            Log::info('Appointment Created:', $appointment->toArray());
            return response()->json($appointment, 201);
        } catch (\Exception $e) {
            Log::error('Error Creating Appointment:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error saving data'], 500);
        }
    }
}