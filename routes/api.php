<?php
use App\Http\Controllers\Api\APIDepartmentController;

use App\Http\Controllers\Api\APIPatientController;
use App\Http\Controllers\Api\APIPaymentController;
use App\Http\Controllers\Api\APIReceiptController;

use App\Http\Controllers\Api\APIDoctorsController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('departments', APIDepartmentController::class);

Route::apiResource('patients', APIPatientController::class);
Route::apiResource('payments', APIPaymentController::class);
Route::apiResource('receipts', APIReceiptController::class);
Route::apiResource('doctors', APIDoctorsController::class);


