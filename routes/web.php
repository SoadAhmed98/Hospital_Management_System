<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('Dashboard.Admins.auth.signin');
})->middleware(['guest:admin','guest:doctor','guest:lab_employee'])->name('/');;

require __DIR__.'/auth-admin.php';
require __DIR__.'/auth-doctor.php';
require __DIR__.'/auth-lab_employee.php';
require __DIR__.'/AdminDashboardRoutes.php';
require __DIR__.'/DoctorDashboardRoutes.php';
require __DIR__.'/LaboratoryEmployeeDashboardRoutes.php';