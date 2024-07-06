<?php

namespace App\Http\Controllers\Api\PatientAuth;

use App\Models\Patient;
use App\Traits\ApiTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthPatientsApi\CheckEmailRequest;
use App\Http\Requests\AuthPatientsApi\SetNewPasswordRequest;

class PasswordController extends Controller
{
    use ApiTrait;
    public function checkEmail(CheckEmailRequest $request)
    {
        $patient = Patient::where('email',$request->email)->first();
        $patient->token = "Bearer " . $patient->createToken('hms_os44')->plainTextToken;
        return ApiTrait::Data(compact('patient'),'Patient email Exists');
    }

    public function setNewPassword(SetNewPasswordRequest $request)
    {
        $token = $request->header('Authorization');
        $patient = Auth::guard('sanctum')->user();
        $patient = patient::find($patient->id);
        $patient->password = Hash::make($request->password);
        $patient->save();
        $patient->token = $token;
        return ApiTrait::Data(compact('patient'),'Password changed Successfully');
    }
}
