<?php
use App\Http\Controllers\Api\APIDepartmentController;

use App\Http\Controllers\Api\APIPatientController;
use App\Http\Controllers\Api\APIPaymentController;
use App\Http\Controllers\Api\APIReceiptController;
use App\Http\Controllers\Api\APISingleServiceController;
use App\Livewire\CreateGroupServices;
use App\Http\Controllers\Api\APIDoctorsController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiseasePredictionController;
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

