<?php

use App\Http\Controllers\Api\APIPatientController;
use App\Http\Controllers\Api\APIPaymentController;
use App\Http\Controllers\Api\APIReceiptController;
use App\Http\Controllers\Api\APIDepartmentController;

use App\Http\Controllers\Api\APISingleServiceController;

use App\Livewire\CreateGroupServices;
use App\Http\Controllers\Api\APIDoctorsController;
use App\Http\Controllers\Api\APISingleInvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiseasePredictionController;
use App\Http\Controllers\Api\PatientInvoiceController;

use App\Http\Controllers\Api\PatientAuth\LoginController;
use App\Http\Controllers\Api\PatientAuth\RegisterController;
use App\Http\Controllers\Api\PatientAuth\EmailVerificationController;

use App\Http\Controllers\Appointmentes\AppointmentController;

Route::post('/appointments', [AppointmentController::class, 'store']);
Route::apiResource('predict', DiseasePredictionController::class);

Route::apiResource('departments', APIDepartmentController::class);
Route::apiResource('services', APISingleServiceController::class);

Route::apiResource('patients', APIPatientController::class);
Route::apiResource('payments', APIPaymentController::class);
Route::apiResource('receipts', APIReceiptController::class);
Route::apiResource('doctors', APIDoctorsController::class);
Route::get('groupservices', function () {
    $component = app()->make(CreateGroupServices::class);
    return $component->getAllGroupServices();
});

Route::get('groupservices/{id}', function ($id) {
    $component = app()->make(CreateGroupServices::class);
    return $component->getGroupService($id);
});
/****************************** patient auth ***************************************/
Route::prefix('patient')->middleware('AcceptTypeJson')->group(function(){
  
    Route::post('/register',RegisterController::class);

    Route::group(['controller'=>EmailVerificationController::class,'middleware'=>'auth:sanctum'],function(){
        Route::get('/send_code','sendCode');
        Route::post('/check_code','checkCode');
    });

    Route::controller(LoginController::class)->group(function(){
        Route::post('/login','login');
        Route::middleware(['auth:sanctum','emailVerified'])->get('/logout','logout');
    });
});


Route::get('patients/{patientId}/invoices', [PatientInvoiceController::class, 'index']);
Route::get('patients/{patientId}/invoices/review', [PatientInvoiceController::class, 'reviewInvoices']);
Route::get('patients/{patientId}/invoices/completed', [PatientInvoiceController::class, 'completedInvoices']);


Route::apiResource('single-invoices', APISingleInvoiceController::class);
Route::get('single-invoices/print/{id}', [APISingleInvoiceController::class, 'print']);




