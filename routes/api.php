<?php
use App\Http\Controllers\Api\APIDepartmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::apiResource('departments', APIDepartmentController::class);

