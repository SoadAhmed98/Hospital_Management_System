<?php

namespace App\Http\Controllers\Api\PatientAuth;


use App\Mail\SendCode;
use App\Models\Patient;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PatientCodeVerification;
use App\Http\Requests\AuthPatientsApi\CheckCodeRequest;

class EmailVerificationController extends Controller
{
    use ApiTrait;
    public function sendCode(Request $request)
    {
        $token = $request->header('authorization');
        $patient=Auth::guard('sanctum')->user();
        $patient = Patient::find($patient->id);
        $patient->code = rand(10000, 99999);
        
        $patient->code_expired_at = date('Y-m-d H:i:s', strtotime('+'.config('auth.code_timeout').' seconds'));
        $patient->save();
      
        try{
            Mail::to($patient)->send(new PatientCodeVerification($patient));
        }catch(\Exception $e){
            return ApiTrait::ErrorMessage([],'some thing went wrong ,please try again',471);
        }
       
        $patient->token = $token;
        return ApiTrait::Data(compact('patient'), ' verification code sent Successfully');
    }

    public function checkCode(CheckCodeRequest $request)
    {
        // token => header
        $token = $request->header('Authorization');
        $patient = Auth::guard('sanctum')->user();
        $patient = patient::find($patient->id);
        $now = date('Y-m-d H:i:s');
        // check if code correct in db
        if ($patient->code == $request->code) {
          
            if ($patient->code_expired_at > $now) {
                // update email verified at
                $patient->email_verified_at = $now;
                $patient->save();
                $patient->token = $token;
                return ApiTrait::Data(compact('patient'));
            } else {
                $patient->token = $token;
                return ApiTrait::Data(compact('patient'), 'Code Expired', 401);
            }
        } else {
            $patient->token = $token;
            return ApiTrait::Data(compact('patient'), 'Wrong Code', 401);
        }
    }
}
