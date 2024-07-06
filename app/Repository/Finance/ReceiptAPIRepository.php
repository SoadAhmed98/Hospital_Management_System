<?php

namespace App\Repository\Finance;

use App\Interfaces\Finance\ReceiptAPIRepositoryInterface;
use App\Models\FundAccount;
use App\Models\Patient;
use App\Models\PatientAccount;
use App\Models\ReceiptAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class ReceiptAPIRepository implements ReceiptAPIRepositoryInterface
{
    public function index(): JsonResponse
    {
        $receipts = ReceiptAccount::all();
        return response()->json($receipts);
    }

    public function show($id): JsonResponse
    {
        $receipt_account = ReceiptAccount::findOrFail($id);
        return response()->json($receipt_account);
    }

    public function store($request): JsonResponse
    {
        DB::beginTransaction();

        try {
            // store receipt_accounts
            $receipt_accounts = new ReceiptAccount();
            $receipt_accounts->date = date('Y-m-d');
            $receipt_accounts->patient_id = $request->patient_id;
            $receipt_accounts->amount = $request->amount;
            $receipt_accounts->description = $request->description;
            $receipt_accounts->save();

            // store fund_accounts
            $fund_accounts = new FundAccount();
            $fund_accounts->date = date('Y-m-d');
            $fund_accounts->receipt_id = $receipt_accounts->id;
            $fund_accounts->Debit = $request->amount;
            $fund_accounts->credit = 0.00;
            $fund_accounts->save();

            // store patient_accounts
            $patient_accounts = new PatientAccount();
            $patient_accounts->date = date('Y-m-d');
            $patient_accounts->patient_id = $request->patient_id;
            $patient_accounts->receipt_id = $receipt_accounts->id;
            $patient_accounts->Debit = 0.00;
            $patient_accounts->credit = $request->amount;
            $patient_accounts->save();

            DB::commit();
            return response()->json(['message' => 'Receipt created successfully'], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update($request, $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            // update receipt_accounts
            $receipt_accounts = ReceiptAccount::findOrFail($id);
            $receipt_accounts->date = date('Y-m-d');
            $receipt_accounts->patient_id = $request->patient_id;
            $receipt_accounts->amount = $request->amount;
            $receipt_accounts->description = $request->description;
            $receipt_accounts->save();

            // update fund_accounts
            $fund_accounts = FundAccount::where('receipt_id', $receipt_accounts->id)->first();
            $fund_accounts->date = date('Y-m-d');
            $fund_accounts->Debit = $request->amount;
            $fund_accounts->credit = 0.00;
            $fund_accounts->save();

            // update patient_accounts
            $patient_accounts = PatientAccount::where('receipt_id', $receipt_accounts->id)->first();
            $patient_accounts->date = date('Y-m-d');
            $patient_accounts->patient_id = $request->patient_id;
            $patient_accounts->Debit = 0.00;
            $patient_accounts->credit = $request->amount;
            $patient_accounts->save();

            DB::commit();
            return response()->json(['message' => 'Receipt updated successfully'], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            ReceiptAccount::destroy($id);
            return response()->json(['message' => 'Receipt deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getReceiptsByPatient($patientId): JsonResponse
    {
        try {
            $receipts = ReceiptAccount::where('patient_id', $patientId)->get();
            return response()->json($receipts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
