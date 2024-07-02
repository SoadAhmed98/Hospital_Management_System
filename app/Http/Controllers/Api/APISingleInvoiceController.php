<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Service;
use App\Models\FundAccount;
use App\Models\PatientAccount;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APISingleInvoiceController extends Controller
{
    public $InvoiceSaved, $InvoiceUpdated;
    public $show_table = true;
    public $tax_rate = 17;
    public $updateMode = false;
    public $price, $patient_id, $doctor_id, $department_id, $type, $Service_id, $single_invoice_id, $catchError;
    public $discount_value = 0;
    public $tax_value = 0;
    public $total_with_tax = 0;

    public function index(Request $request)
    {
        $patient_id = $request->input('patient_id');

        $single_invoices = Invoice::where('invoice_type', 1)
            ->where('patient_id', $patient_id)
            ->get();

        return response()->json([
            'single_invoices' => $single_invoices,
        ]);
    }

    public function print($patient_id)
    {
        $single_invoices = Invoice::where('invoice_type', 1)
            ->where('patient_id', $patient_id)
            ->get();

        return response()->json([
            'single_invoices' => $single_invoices,
        ]);
    }

    public function getDepartment($doctor_id)
    {
        $doctor = Doctor::with('department')->findOrFail($doctor_id);
        return response()->json([
            'department' => $doctor->department->name,
        ]);
    }

    public function getPrice($service_id)
    {
        $service = Service::findOrFail($service_id);
        return response()->json([
            'price' => $service->price,
        ]);
    }

    public function calculateTotals($price, $discount_value, $tax_rate)
    {
        $subtotal = (is_numeric($price) ? $price : 0) - (is_numeric($discount_value) ? $discount_value : 0);
        $tax_value = $subtotal * ((is_numeric($tax_rate) ? $tax_rate : 0) / 100);
        $total_with_tax = $subtotal + $tax_value;

        return response()->json([
            'tax_value' => $tax_value,
            'total_with_tax' => $total_with_tax,
        ]);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([

            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'Service_id' => 'required|exists:services,id',
            'discount_value' => 'required|numeric',
            'tax_rate' => 'required|numeric',
            'type' => 'required|integer|in:1,2',
            'updateMode' => 'required|boolean',
            'single_invoice_id' => 'sometimes|required_if:updateMode,true|exists:invoices,id'
        ]);

        // Fetch department id and price
        $doctor = Doctor::with('department')->findOrFail($validatedData['doctor_id']);
        $department_id = $doctor->department->id;
        $service = Service::findOrFail($validatedData['Service_id']);
        $price = $service->price;

        // Calculate tax value and total with tax
        $subtotal = $price - $validatedData['discount_value'];
        $tax_value = $subtotal * ($validatedData['tax_rate'] / 100);
        $total_with_tax = $subtotal + $tax_value;

        if ($validatedData['type'] == 1) {
            // Cash invoice
            DB::beginTransaction();
            try {
                if ($validatedData['updateMode']) {
                    // Update mode
                    $single_invoice = Invoice::findOrFail($validatedData['single_invoice_id']);
                } else {
                    // Create mode
                    $single_invoice = new Invoice();
                }

                $single_invoice->invoice_type = 1;
                $single_invoice->invoice_date = date('Y-m-d');
                $single_invoice->patient_id = $validatedData['patient_id'];
                $single_invoice->doctor_id = $validatedData['doctor_id'];
                $single_invoice->department_id = $department_id;
                $single_invoice->service_id = $validatedData['Service_id'];
                $single_invoice->price = $price;
                $single_invoice->discount_value = $validatedData['discount_value'];
                $single_invoice->tax_rate = $validatedData['tax_rate'];
                $single_invoice->tax_value = $tax_value;
                $single_invoice->total_with_tax = $total_with_tax;
                $single_invoice->type = $validatedData['type'];
                $single_invoice->invoice_status = 1;
                $single_invoice->save();

                if ($validatedData['updateMode']) {
                    $fund_account = FundAccount::where('invoice_id', $validatedData['single_invoice_id'])->first();
                } else {
                    $fund_account = new FundAccount();
                }

                $fund_account->date = date('Y-m-d');
                $fund_account->invoice_id = $single_invoice->id;
                $fund_account->Debit = $total_with_tax;
                $fund_account->credit = 0.00;
                $fund_account->save();

                DB::commit();

                return response()->json([
                    'message' => $validatedData['updateMode'] ? 'Invoice updated successfully' : 'Invoice created successfully',
                    'invoice' => $single_invoice
                ], 200);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['error' => $e->getMessage()], 500);
            }
        } else {
            // Credit invoice
            DB::beginTransaction();
            try {
                if ($validatedData['updateMode']) {
                    $single_invoice = Invoice::findOrFail($validatedData['single_invoice_id']);
                } else {
                    $single_invoice = new Invoice();
                }

                $single_invoice->invoice_type = 1;
                $single_invoice->invoice_date = date('Y-m-d');
                $single_invoice->patient_id = $validatedData['patient_id'];
                $single_invoice->doctor_id = $validatedData['doctor_id'];
                $single_invoice->department_id = $department_id;
                $single_invoice->service_id = $validatedData['Service_id'];
                $single_invoice->price = $price;
                $single_invoice->discount_value = $validatedData['discount_value'];
                $single_invoice->tax_rate = $validatedData['tax_rate'];
                $single_invoice->tax_value = $tax_value;
                $single_invoice->total_with_tax = $total_with_tax;
                $single_invoice->type = $validatedData['type'];
                $single_invoice->save();

                if ($validatedData['updateMode']) {
                    $patient_account = PatientAccount::where('invoice_id', $validatedData['single_invoice_id'])->first();
                } else {
                    $patient_account = new PatientAccount();
                }

                $patient_account->date = date('Y-m-d');
                $patient_account->invoice_id = $single_invoice->id;
                $patient_account->patient_id = $validatedData['patient_id'];
                $patient_account->Debit = $total_with_tax;
                $patient_account->credit = 0.00;
                $patient_account->save();

                DB::commit();

                return response()->json([
                    'message' => $validatedData['updateMode'] ? 'Invoice updated successfully' : 'Invoice created successfully',
                    'invoice' => $single_invoice
                ], 200);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    public function edit($id)
{
    try {
        $single_invoice = Invoice::findOrFail($id);

        $data = [
            'single_invoice_id' => $single_invoice->id,
            'patient_id' => $single_invoice->patient_id,
            'doctor_id' => $single_invoice->doctor_id,
            'department_id' => DB::table('departments')->where('id', $single_invoice->department_id)->first()->name,
            'Service_id' => $single_invoice->service_id,
            'price' => $single_invoice->price,
            'discount_value' => $single_invoice->discount_value,
            'type' => $single_invoice->type,
            'invoice_date' => $single_invoice->invoice_date,
        ];

        return response()->json($data, 200);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 404);
    }
}

public function destroy($id)
{
    try {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return response()->json(['message' => 'Invoice deleted successfully.']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    public function show($id)
    {
        $single_invoice = Invoice::findOrFail($id);
        return response()->json([
            'invoice_date' => $single_invoice->invoice_date,
            'doctor_id' => $single_invoice->Doctor->name,
            'department_id' => $single_invoice->Department->name,
            'Service_id' => $single_invoice->Service->name,
            'type' => $single_invoice->type,
            'price' => $single_invoice->price,
            'discount_value' => $single_invoice->discount_value,
            'tax_rate' => $single_invoice->tax_rate,
            'total_with_tax' => $single_invoice->total_with_tax,
        ]);
    }
}
