<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Doctor\InvoiceController;
use App\Http\Controllers\Doctor\LaboratorieController;
use App\Http\Controllers\Doctor\PatientHistoryController;
use App\Http\Controllers\Doctor\PatientDetailsController;

Route::group(
    [
        'prefix' => 'doctor',
        'middleware' => ['auth:doctor']
    ], function(){


            //############################# completed_invoices route ##########################################
            Route::get('completed_invoices', [InvoiceController::class,'completedInvoices'])->name('completedInvoices');
            //############################# end invoices route ################################################

            //############################# review_invoices route ##########################################
            Route::get('review_invoices', [InvoiceController::class,'reviewInvoices'])->name('reviewInvoices');
            //############################# end invoices route #############################################
            
            //############################# invoices route ##########################################
            Route::resource('invoices', InvoiceController::class)->names([
                'index' => 'Doctors.Invoices.index',
            ]);
            //############################# end invoices route ######################################

            //############################# PatientHistorys route ##########################################

            Route::resource('patient_history', PatientHistoryController::class);

            //############################# end PatientHistorys route ######################################


            //############################# review_invoices route ##########################################
            Route::post('add_review', [ PatientHistoryController::class,'addReview'])->name('add_review');
            //############################# end invoices route #############################################
             
            Route::get('patient_details/{id}', [PatientDetailsController::class,'index'])->name('patient_details');


             //############################# Laboratories route ##########################################

             Route::resource('Laboratories', LaboratorieController::class);

             //############################# end Laboratories route ######################################

       

});



