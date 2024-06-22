<?php
use App\Http\Controllers\Api\APIDepartmentController;
use App\Http\Controllers\Api\APIPatientController;
use App\Http\Controllers\Api\APIPaymentController;
use App\Http\Controllers\Api\APIReceiptController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('departments', APIDepartmentController::class);
Route::apiResource('patients', APIPatientController::class);
Route::apiResource('payments', APIPaymentController::class);
Route::apiResource('receipts', APIReceiptController::class);



