<?php

namespace App\Http\Controllers\Api\PatientAuth;

use App\Models\Patient;
use App\Traits\ApiTrait;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthPatientsApi\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\TryCatch;

class RegisterController extends Controller
{
    use ApiTrait;
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        $data = $request->only('name', 'email','address','phone','birth_date','gender','blood_group');
        $data['password'] = Hash::make($request->password);
        try {
            // dd($data);
            $patient = Patient::create($data);
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return  ApiTrait::ErrorMessage([], 'something went wrong', 500);
        }
        $patient->token = "Bearer ".$patient->createToken('hms_os44')->plainTextToken;
        return ApiTrait::Data(compact('patient'), 'Patient Register Successfully');
    }
}
