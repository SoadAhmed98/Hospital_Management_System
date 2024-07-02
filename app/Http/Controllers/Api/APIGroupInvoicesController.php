<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Group;
use App\Models\FundAccount;
use App\Models\GroupInvoice;
use App\Models\PatientAccount;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIGroupInvoicesController extends Controller
{
    public $tax_rate = 17;

    public function index(Request $request)
    {
        $patient_id = $request->input('patient_id');
        $group_invoices = Invoice::where('invoice_type', 2)
           ->where('patient_id', $patient_id)
           ->get();
        return response()->json([
            'group_invoices' => $group_invoices,
        ]);
    }

    public function show($id)
    {
        $group_invoice = Invoice::find($id);

        if (!$group_invoice) {
            return response()->json(['error' => 'Group invoice not found'], 404);
        }

        return response()->json($group_invoice);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'Group_id' => 'required|exists:groups,id',
            'type' => 'required|integer|in:1,2',
        ]);

        // Fetch department id and price
        $doctor = Doctor::with('department')->findOrFail($validatedData['doctor_id']);
        $department_id = $doctor->department->id;
        $group = Group::findOrFail($validatedData['Group_id']);
        $price = $group->Total_with_tax;

        // Calculate tax value and total with tax
        $subtotal = $price - $group->discount_value;
        $tax_value = $subtotal * ($group->tax_rate / 100);
        $total_with_tax = $subtotal + $tax_value;

        DB::beginTransaction();

        try {
            $group_invoice = new Invoice();
            $group_invoice->invoice_type = 2;
            $group_invoice->invoice_date = date('Y-m-d');
            $group_invoice->patient_id = $validatedData['patient_id'];
            $group_invoice->doctor_id = $validatedData['doctor_id'];
            $group_invoice->department_id = $department_id;
            $group_invoice->group_id = $validatedData['Group_id'];
            $group_invoice->price = $price;
            $group_invoice->discount_value = $group->discount_value;
            $group_invoice->tax_rate = $group->tax_rate;
            $group_invoice->tax_value = $tax_value;
            $group_invoice->total_with_tax = $total_with_tax;
            $group_invoice->type = $validatedData['type'];
            $group_invoice->invoice_status = 1;
            $group_invoice->save();

            if ($validatedData['type'] == 1) {
                // Cash invoice
                $fund_account = new FundAccount();
                $fund_account->date = date('Y-m-d');
                $fund_account->invoice_id = $group_invoice->id;
                $fund_account->Debit = $total_with_tax;
                $fund_account->credit = 0.00;
                $fund_account->save();
            } else {
                // Credit invoice
                $patient_account = new PatientAccount();
                $patient_account->date = date('Y-m-d');
                $patient_account->invoice_id = $group_invoice->id;
                $patient_account->patient_id = $validatedData['patient_id'];
                $patient_account->Debit = $total_with_tax;
                $patient_account->credit = 0.00;
                $patient_account->save();
            }

            DB::commit();

            return response()->json([
                'message' => 'Invoice created successfully',
                'invoice' => $group_invoice,
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'Group_id' => 'required|exists:groups,id',
            ]);

        $group_invoice = Invoice::find($id);

        if (!$group_invoice) {
            return response()->json(['error' => 'Group invoice not found'], 404);
        }

        // Fetch department id and price
        $doctor = Doctor::with('department')->findOrFail($validatedData['doctor_id']);
        $department_id = $doctor->department->id;
        $group = Group::findOrFail($validatedData['Group_id']);
        $price = $group->Total_with_tax;

        // Calculate tax value and total with tax
        $subtotal = $price -  $group->discount_value;
        $tax_value = $subtotal * ($group->tax_rate / 100);
        $total_with_tax = $subtotal + $tax_value;

        DB::beginTransaction();

        try {
            $group_invoice->invoice_date = date('Y-m-d');
            $group_invoice->patient_id = $validatedData['patient_id'];
            $group_invoice->doctor_id = $validatedData['doctor_id'];
            $group_invoice->department_id = $department_id;
            $group_invoice->group_id = $validatedData['Group_id'];
            $group_invoice->price = $price;
            $group_invoice->discount_value =  $group->discount_value;
            $group_invoice->tax_rate = $group->tax_rate;
            $group_invoice->tax_value = $tax_value;
            $group_invoice->total_with_tax = $total_with_tax;
            $group_invoice->type = $group_invoice->type;
            $group_invoice->save();

            if ($group_invoice->type == 1) {
                // Cash invoice
                $fund_account = FundAccount::where('invoice_id', $group_invoice->id)->first();
                $fund_account->date = date('Y-m-d');
                $fund_account->Debit = $total_with_tax;
                $fund_account->credit = 0.00;
                $fund_account->save();
            } else {
                // Credit invoice
                $patient_account = PatientAccount::where('invoice_id', $group_invoice->id)->first();
                $patient_account->date = date('Y-m-d');
                $patient_account->patient_id = $validatedData['patient_id'];
                $patient_account->Debit = $total_with_tax;
                $patient_account->credit = 0.00;
                $patient_account->save();
            }

            DB::commit();

            return response()->json([
                'message' => 'Invoice updated successfully',
                'invoice' => $group_invoice,
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $group_invoice = Invoice::find($id);

        if (!$group_invoice) {
            return response()->json(['error' => 'Group invoice not found'], 404);
        }

        DB::beginTransaction();

        try {
            $group_invoice->delete();

            DB::commit();

            return response()->json(['message' => 'Group invoice deleted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
