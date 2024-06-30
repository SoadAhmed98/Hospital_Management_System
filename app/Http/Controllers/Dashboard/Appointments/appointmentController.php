<?php

namespace App\Http\Controllers\Dashboard\Appointments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmation;
use Symfony\Component\Mailer\Bridge\Postmark\Transport\PostmarkApiTransport;

class appointmentController extends Controller
{
    public function index(){

        $appointments = Appointment::where('type','Unconfirmed')->get();
        return view('Dashboard.appointments.index',compact('appointments'));
    }

    public function index2(){

        $appointments = Appointment::where('type','Confirmed')->get();
        return view('Dashboard.appointments.index2',compact('appointments'));
    }

    public function approval(Request $request, $id){
        $appointment = Appointment::findOrFail($id);
        \Log::info('Appointment found:', ['appointment' => $appointment]);
    
        $appointment->update([
            'type' => 'Confirmed',
            'appointment' => $request->appointment
        ]);
    
        Mail::to($appointment->email)->send(new AppointmentConfirmation($appointment->name,$appointment->appointment));
    
        session()->flash('add');
        return back();
    }
    
}
