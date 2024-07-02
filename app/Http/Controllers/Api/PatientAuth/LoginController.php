<?php

namespace App\Http\Controllers\Api\PatientAuth;

use App\Models\Patient;

use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthPatientsApi\LoginRequest;

class LoginController extends Controller
{
    use ApiTrait;
    public function login(LoginRequest $request) 
    {
        $patient = Patient::where('email', $request->email)->first();
        if (! Hash::check($request->password, $patient->password)) {
            return ApiTrait::ErrorMessage(['password'=>'The provided credentials are invalid.'],'failed attempt',401);
        }
        $patient->token =  'Bearer '.$patient->createToken('hms_os44')->plainTextToken;
        if(! $patient->email_verified_at){
            return ApiTrait::Data(compact('patient'),'Patient Not Verified',401);
        }
        return ApiTrait::Data(compact('patient'),'Admin Loggedin successfully');
    }

    public function logout(Request $request)
    {
        // $patient = Auth::guard('sanctum')->user();
        // $patient->currentAccessToken()->delete();
        // return ApiTrait::SuccessMessage('Patient logout Successfully');
    }




}
