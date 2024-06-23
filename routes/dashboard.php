<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DepartmentController;
use App\Http\Controllers\Dashboard\PatientController;
use App\Http\Controllers\Dashboard\PaymentAccountController;
use App\Http\Controllers\Dashboard\ReceiptAccountController;


use App\Http\Controllers\Dashboard\SingleServiceController;
use App\Livewire\CreateGroupServices;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;



Route::group(
    [
        // 'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'auth.all' ]
    ], function(){

            //############################# Departments route ##########################################
        
                Route::resource('Departments', DepartmentController::class);
        
            //############################# end Departments route ######################################


             //############################# 'Patients route ##########################################
        
             Route::resource('Patients', PatientController::class);
        
             //############################# end 'Patients route ######################################

             Route::resource('Payment', PaymentAccountController::class);

             Route::resource('Receipt', ReceiptAccountController::class);

            
            //############################# Doctors route ##########################################
            
            Route::resource('Doctors', DoctorController::class);
            Route::post('update_password', [DoctorController::class, 'update_password'])->name('update_password');
            Route::post('update_status', [DoctorController::class, 'update_status'])->name('update_status');
            //############################# end Doctors route ######################################
        
             //############################# Services route ##########################################
        
             Route::resource('Service', SingleServiceController::class);

        
             //############################# end Services route ######################################
            //############################# GroupServices route ##########################################

                Route::view('Add_GroupServices','livewire.GroupServices.include_create')->name('Add_GroupServices');
           //############################# end GroupServices route ######################################


       
        Route::resource('backend', DashboardController::class);


});
