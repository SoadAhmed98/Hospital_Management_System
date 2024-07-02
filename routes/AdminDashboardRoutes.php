<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DepartmentController;
use App\Http\Controllers\Dashboard\PatientController;
use App\Http\Controllers\Dashboard\PaymentAccountController;
use App\Http\Controllers\Dashboard\ReceiptAccountController;
use App\Http\Controllers\Dashboard\SingleServiceController;
use App\Http\Controllers\Dashboard\appointments\appointmentController;

use App\Livewire\CreateGroupServices;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        // 'prefix' => LaravelLocalization::setLocale(),

        // 'middleware' => [ 'auth:admin']

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

          //############################# SingleInvoices route ##########################################

           Route::view('SingleInvoices','livewire.SingleInvoices.index')->name('single_invoices');
           Route::view('Print_single_invoices','livewire.SingleInvoices.print')->name('Print_single_invoices');
        
           //############################# end SingleInvoices route ##########################################

           //#############################  GroupInvoices route ##########################################

           Route::view('GroupInvoices','livewire.GroupInvoices.index')->name('group_invoices');
        
           //############################# end GroupInvoices route ##########################################
           
           //#############################  appointments route ##########################################

           Route::get('appointments',[AppointmentController::class,'index'])->name('appointments.index');
           Route::put('appointments/approval/{id}',[AppointmentController::class,'approval'])->name('appointments.approval');
           Route::get('appointments/approval',[AppointmentController::class,'index2'])->name('appointments.index2');
           Route::get('appointments/complete',[AppointmentController::class,'index3'])->name('appointments.index3');

           Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

           //############################# end appointments route ##########################################
           
        Route::resource('backend', DashboardController::class);


});
