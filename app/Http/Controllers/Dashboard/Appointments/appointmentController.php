<?php

namespace App\Http\Controllers\Dashboard\Appointments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmation;
use Symfony\Component\Mailer\Bridge\Postmark\Transport\PostmarkApiTransport;
use Twilio\Rest\Client;

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
    //send mail
        Mail::to($appointment->email)->send(new AppointmentConfirmation($appointment->name,$appointment->appointment));
    // //send sms message
    //  // send message mob
    //  $receiverNumber = $appointment->phone;
    //   // Ensure the phone number is in E.164 format
    // if (!preg_match('/^\+/', $receiverNumber)) {
    //     $receiverNumber = '+2' . $receiverNumber; // Egypt country code is +20
    // }
    //  $message = "Dear" . " " . $appointment->name . " " . "Your appointment has been booked on". $appointment->appointment;

    //  $account_sid = getenv("TWILIO_SID");
    //  $auth_token = getenv("TWILIO_TOKEN");
    //  $twilio_number = getenv("TWILIO_FROM");
    //  $client = new Client($account_sid, $auth_token);
    //  $client->messages->create($receiverNumber,[
    //      'from' => $twilio_number,
    //      'body' => $message
    //  ]);
        session()->flash('add');
        return back();
    }
    public function destroy($id)
{
    $appointment = Appointment::findOrFail($id);
    $appointment->delete();

    session()->flash('delete', 'Appointment deleted successfully');
    return back();
}


}
