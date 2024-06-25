<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Doctor\InvoiceController;

Route::group(
    [
        // 'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['auth:doctor']
    ], function(){

        Route::prefix('doctor')->group(function () {
            //############################# invoices route ##########################################
            Route::resource('invoices', InvoiceController::class)->names([
                'index' => 'Doctors.Invoices.index',
            ]);
            //############################# end invoices route ######################################
        });

});



