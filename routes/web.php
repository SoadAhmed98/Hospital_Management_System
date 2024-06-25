<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('Dashboard.Admins.auth.signin');
})->middleware(['guest.admin','guest.doctor']);


require __DIR__.'/auth-admin.php';
require __DIR__.'/auth-doctor.php';