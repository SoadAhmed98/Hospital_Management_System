<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\ReceiptAccount;
use App\Models\PatientHistory;
use App\Models\Laboratorie;
use App\Models\PatientAccount;
use Illuminate\Http\Request;

class APIPatientAccountsController extends Controller
{
    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        $invoices = Invoice::where('patient_id', $id)->get();
        $receipt_accounts = ReceiptAccount::where('patient_id', $id)->get();
        $patient_accounts = PatientAccount::where('patient_id', $id)->get();
        $patient_records = PatientHistory::where('patient_id', $id)->get();
        $patient_laboratories = Laboratorie::where('patient_id', $id)->get();

        return response()->json([
            'patient' => $patient,
            'invoices' => $invoices,
            'receipt_accounts' => $receipt_accounts,
            'patient_accounts' => $patient_accounts,
            'patient_records' => $patient_records,
            'patient_laboratories' => $patient_laboratories
        ]);
    }
}
