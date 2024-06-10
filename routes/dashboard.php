<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DepartmentController;

use Illuminate\Support\Facades\Route;

 

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

            //############################# Departments route ##########################################
        
                Route::resource('Departments', DepartmentController::class);
        
            //############################# end Departments route ######################################
        
        require __DIR__.'/auth.php';
        Route::resource('backend', DashboardController::class);


});