<?php

use Illuminate\Support\Facades\Route;

Route::prefix('website')->group(function () {
    Route::get('/', function () {
       return "welcome to website";
    });
});