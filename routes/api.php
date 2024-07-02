<?php
use App\Livewire\CreateGroupServices;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\APIDoctorsController;
use App\Http\Controllers\Api\APIPatientController;
use App\Http\Controllers\Api\APIPaymentController;
use App\Http\Controllers\Api\APIReceiptController;
use App\Http\Controllers\Api\APIDepartmentController;
use App\Http\Controllers\DiseasePredictionController;
use App\Http\Controllers\Api\APISingleServiceController;
use App\Http\Controllers\Api\PatientAuth\LoginController;
use App\Http\Controllers\Api\PatientAuth\RegisterController;
use App\Http\Controllers\Api\PatientAuth\EmailVerificationController;

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

