<?php

namespace App\Http\Controllers\Api;

use App\Models\Patient;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\FatoorahServices;
use App\Http\Requests\AppointmentFatoorahRequest;

class AppointmentFatoorahController extends Controller
{
    private $fatoorahServices;
    public function __construct(FatoorahServices $fatoorahServices)
    {
        $this->fatoorahServices = $fatoorahServices;
    }
    public function payment(AppointmentFatoorahRequest $request)
    {
        $token = $request->header('authorization');
        $patient = Auth::guard('sanctum')->user();
        $patient = Patient::find($patient->id);

        $validatedData = $request->validated();

        $additionalData = [
            'CallBackUrl'        => env('invoice_success_url'),
            'ErrorUrl'           => env('invoice_error_url'), //or 'https://example.com/error.php'
            'Language'           => 'en', //or 'ar'
            'NotificationOption' => 'LNK', //'SMS', 'EML', or 'ALL'
            'DisplayCurrencyIso' => 'EGP',
        ];

        $data = array_merge($validatedData, $additionalData);

      return  $this->fatoorahServices->sendPayment($data);
    }

     public function PaymentCallback(Request $request) {
       $data=[
        'Key'=>$request->paymentId,
        'KeyType'=>'paymentId'
       ];
       
       $paymentStatus= $this->fatoorahServices->getPaymentStatus($data);

       //save appointment in db
        
        return ApiTrait::SuccessMessage('Payment happened successfully');
    }

    public function PaymentError() {
        return ApiTrait::ErrorMessage([],'Failed Payment Attempt',400);
    }
}
