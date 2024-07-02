<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientInvoiceController extends Controller
{
    public function index($patientId)
    {
        $invoices = Invoice::where('patient_id', $patientId)
                           ->where('invoice_status', 1)
                           ->get();

        return response()->json($invoices);
    }

    public function reviewInvoices($patientId)
    {
        $invoices = Invoice::where('patient_id', $patientId)
                           ->where('invoice_status', 2)
                           ->with(['patientHistory' => function($query) {
                               $query->select('invoice_id', 'review_date');
                           }])
                           ->get();

        return response()->json($invoices);
    }

    public function completedInvoices($patientId)
    {
        $invoices = Invoice::where('patient_id', $patientId)
                           ->where('invoice_status', 3)
                           ->get();

        return response()->json($invoices);
    }
}
