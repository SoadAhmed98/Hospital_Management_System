<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('Dashboard.Admin.auth.signin');
});


require __DIR__.'/auth-admin.php';
require __DIR__.'/auth-doctor.php';