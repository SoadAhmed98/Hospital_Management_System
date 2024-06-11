<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Dashboard\DashboardController;

use App\Http\Controllers\Dashboard\DepartmentController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

            //############################# Departments route ##########################################
        
                Route::resource('Departments', DepartmentController::class);
        
            //############################# end Departments route ######################################
            
            //############################# Doctors route ##########################################
            
            Route::resource('Doctors', DoctorController::class);
            
            //############################# end Doctors route ######################################
        
       
        Route::resource('backend', DashboardController::class);


});
