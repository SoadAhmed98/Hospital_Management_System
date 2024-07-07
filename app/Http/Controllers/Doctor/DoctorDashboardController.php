<?php

namespace App\Http\Controllers\Doctor;
use App\Models\Doctor;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DoctorDashboardController extends Controller
{
    // public function index()
    // {
    //     $doctor = Auth::user()->doctor; // Assuming doctor relationship exists in User model

    //     // Number of invoices today for this doctor
    //     $invoicesTodayCount = Invoice::where('doctor_id', $doctor->id)
    //         ->whereDate('created_at', today())
    //         ->count();

    //     // Total earnings of today's invoices for this doctor
    //     $earningsToday = Invoice::where('doctor_id', $doctor->id)
    //         ->whereDate('created_at', today())
    //         ->sum('total_with_tax');

    //     // Total earnings of all invoices for this doctor
    //     $totalEarnings = Invoice::where('doctor_id', $doctor->id)
    //         ->sum('total_with_tax');

    //     // Number of patients who made invoices with this doctor
    //     $patientsCount = Invoice::where('doctor_id', $doctor->id)
    //         ->distinct('patient_id')
    //         ->count();

    //     // Number of invoices in progress, under review, and completed
    //     $inProgressCount = Invoice::where('doctor_id', $doctor->id)
    //         ->where('invoice_status', 1) // Adjust status codes as per your application
    //         ->count();

    //     $underReviewCount = Invoice::where('doctor_id', $doctor->id)
    //         ->where('invoice_status', 2)
    //         ->count();

    //     $completedCount = Invoice::where('doctor_id', $doctor->id)
    //         ->where('invoice_status', 3)
    //         ->count();

    //     // Recent invoices (group vs single)
    //     $recentInvoicesGroupCount = Invoice::where('doctor_id', $doctor->id)
    //         ->where('invoice_type', 2) // Assuming type 2 is for group, adjust as per your database
    //         ->count();

    //     $recentInvoicesSingleCount = Invoice::where('doctor_id', $doctor->id)
    //         ->where('invoice_type', 1) // Assuming type 1 is for single, adjust as per your database
    //         ->count();
        
    //     return view('doctor.dashboard', compact(
    //         'invoicesTodayCount',
    //         'earningsToday',
    //         'totalEarnings',
    //         'patientsCount',
    //         'inProgressCount',
    //         'underReviewCount',
    //         'completedCount',
    //         'recentInvoicesGroupCount',
    //         'recentInvoicesSingleCount'
    //     ));
    // }

    public function getData()
{
    // Example logic to fetch data
    $today = Carbon::today();
    $last12Months = Carbon::now()->subMonths(12);
    
    $completedInvoicesCount = Invoice::where('doctor_id', auth()->user()->id)
        ->where('invoice_status', 3)
        ->whereBetween('created_at', [$last12Months, $today])
        ->count();

    $inProgressInvoicesCount = Invoice::where('doctor_id', auth()->user()->id)
        ->where('invoice_status', 1)
        ->whereBetween('created_at', [$last12Months, $today])
        ->count();

    $reviewInvoicesCount = Invoice::where('doctor_id', auth()->user()->id)
        ->where('invoice_status', 2)
        ->whereBetween('created_at', [$last12Months, $today])
        ->count();

    return response()->json([
        'completedInvoicesCount' => $completedInvoicesCount,
        'inProgressInvoicesCount' => $inProgressInvoicesCount,
        'reviewInvoicesCount' => $reviewInvoicesCount,
    ]);
}
}
