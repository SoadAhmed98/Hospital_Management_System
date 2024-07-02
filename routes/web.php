<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('Dashboard.Admins.auth.signin');
});

require __DIR__.'/auth-admin.php';
require __DIR__.'/auth-doctor.php';
require __DIR__.'/auth-lab_employee.php';