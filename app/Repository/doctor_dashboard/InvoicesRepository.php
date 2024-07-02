<?php

namespace App\Repository\doctor_dashboard;

use App\Interfaces\doctor_dashboard\InvoicesRepositoryInterface;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class InvoicesRepository implements InvoicesRepositoryInterface
{

    public function index()
    {
        $invoices = Invoice::where('doctor_id', Auth::user()->id)->where('invoice_status',1)->get();
        return view('Dashboard.Doctors.Invoices.index',compact('invoices'));
    }

     // قائمة المراجعات
     public function reviewInvoices()
     {
         $invoices = Invoice::where('doctor_id', Auth::user()->id)->where('invoice_status', 2)->get();
         return view('Dashboard.Doctors.Invoices.review_invoices', compact('invoices'));
     }
 
     // قائمة الفواتير المكتملة
     public function completedInvoices()
 
     {
         $invoices = Invoice::where('doctor_id', Auth::user()->id)->where('invoice_status', 3)->get();
         return view('Dashboard.Doctors.Invoices.completed_invoices', compact('invoices'));
     }
 
}