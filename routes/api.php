<?php

use App\Models\Invoice;
use App\Traits\ApiTrait;
use App\Livewire\CreateGroupServices;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FatoorahController;
use App\Http\Controllers\Api\APIDoctorsController;
use App\Http\Controllers\Api\APIPatientController;
use App\Http\Controllers\Api\APIPaymentController;
use App\Http\Controllers\Api\APIReceiptController;
use App\Http\Controllers\Api\APIDepartmentController;
use App\Http\Controllers\DiseasePredictionController;
use App\Http\Controllers\Api\ApiAppointmentController;
use App\Http\Controllers\Api\PatientInvoiceController;
use App\Http\Controllers\Api\InvoiceFatoorahController;
use App\Http\Controllers\Api\APIGroupInvoicesController;

use App\Http\Controllers\Api\APIPatientDetailsController;

use App\Http\Controllers\Api\APISingleInvoiceController;
use App\Http\Controllers\Api\APISingleServiceController;
use App\Http\Controllers\Api\AppointmentFatoorahController;
use App\Http\Controllers\Api\PatientAuth\LoginController;
use App\Http\Controllers\Api\PatientAuth\PasswordController;
use App\Http\Controllers\Api\PatientAuth\RegisterController;
use App\Http\Controllers\Api\PatientAuth\EmailVerificationController;

use App\Http\Controllers\Appointmentes\AppointmentController;
use App\Http\Controllers\Api\APIPatientAccountsController;
use App\Http\Controllers\Api\PatientAuth\PatientProfileController;

Route::post('/appointments', [ApiAppointmentController::class, 'store']);
Route::apiResource('predict', DiseasePredictionController::class);

Route::apiResource('departments', APIDepartmentController::class);
Route::apiResource('services', APISingleServiceController::class);

Route::apiResource('patients', APIPatientController::class);
Route::apiResource('payments', APIPaymentController::class);
Route::apiResource('receipts', APIReceiptController::class);
Route::get('receipts/patient/{patientId}', [APIReceiptController::class, 'getReceiptsByPatient']);

Route::apiResource('doctors', APIDoctorsController::class);
Route::get('groupservices', function () {
    $component = app()->make(CreateGroupServices::class);
    return $component->getAllGroupServices();
});

Route::get('groupservices/{id}', function ($id) {
    $component = app()->make(CreateGroupServices::class);
    return $component->getGroupService($id);
});
/****************************** patient api ***************************************/
Route::prefix('patient')->middleware('AcceptTypeJson')->group(function(){

  /***************************** patient auth **************************/
    //register
    Route::post('/register',RegisterController::class); //guest
    

    //auth
    Route::group(['controller'=>EmailVerificationController::class,'middleware'=>'auth:sanctum'],function(){
        Route::get('/send_code','sendCode');
        Route::post('/check_code','checkCode');
    });

    //login
    Route::controller(LoginController::class)->group(function(){
        Route::post('/login','login'); //guest
        Route::middleware(['auth:sanctum','Verified'])->get('/logout','logout'); //auth , verified
    });
    // forget password
    Route::controller(PasswordController::class)->group(function(){
        Route::post('/check-email','checkEmail');
        Route::middleware(['auth:sanctum','Verified'])->post('/set-new-password','setNewPassword');
    });
    /***************************** end patient auth **************************/
    /********************************* patient profile ***************************************/
    Route::group(['middleware'=>['auth:sanctum','Verified'],'controller'=>PatientProfileController::class],function () {
        Route::post('/update-profile-picture','changePicture');
        
    });
    /**********************************end patient profile ***********************************/
    /******************************  fatoorah payment ***************************************/
    Route::group(['middleware'=>['auth:sanctum','Verified']],function () {
        Route::post('/invoice-payment',[InvoiceFatoorahController::class,'payment']);
        // Route::post('/appointment-payment',[AppointmentFatoorahController::class,'payment']);
    });


  
});
//callback for invoice payment
Route::group(['controller'=>InvoiceFatoorahController::class,'prefix'=>'patient'],function ()  {

    Route::get('/invoice-payment-callback','PaymentCallback');

    Route::get('/invoice-payment-error','PaymentError');
});

// callback for appointment
// Route::group(['controller'=>AppointmentFatoorahController::class,'prefix'=>'patient'],function ()  {

//     Route::get('/appointment-payment-callback','PaymentCallback');

//     Route::get('/appointment-payment-error','PaymentError');
// });
 /****************************** end fatoorah payment ***************************************/

Route::get('patients/{patientId}/invoices', [PatientInvoiceController::class, 'index']);
Route::get('patients/{patientId}/invoices/review', [PatientInvoiceController::class, 'reviewInvoices']);
Route::get('patients/{patientId}/invoices/completed', [PatientInvoiceController::class, 'completedInvoices']);


Route::apiResource('single-invoices', APISingleInvoiceController::class);
Route::get('single-invoices/print/{id}', [APISingleInvoiceController::class, 'print']);

Route::apiResource('group-invoices', ApiGroupInvoicesController::class)->except(['create', 'edit']);

Route::get('patient-details/{id}', [APIPatientDetailsController::class, 'index']);

Route::get('/patient-accounts/{id}', [APIPatientAccountsController::class, 'show']);



