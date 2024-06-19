<?php
use App\Http\Controllers\Api\APIDepartmentController;
use App\Http\Controllers\Api\APIDoctorsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::apiResource('departments', APIDepartmentController::class);
Route::apiResource('doctors', APIDoctorsController::class);

