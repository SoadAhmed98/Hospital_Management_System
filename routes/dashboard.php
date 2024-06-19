<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DepartmentController;

use App\Http\Controllers\Dashboard\SingleServiceController;
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
            Route::post('update_password', [DoctorController::class, 'update_password'])->name('update_password');
            Route::post('update_status', [DoctorController::class, 'update_status'])->name('update_status');
            //############################# end Doctors route ######################################
        
             //############################# Services route ##########################################
        
             Route::resource('Service', SingleServiceController::class);
        
             //############################# end Services route ######################################
             
       
        Route::resource('backend', DashboardController::class);


});
