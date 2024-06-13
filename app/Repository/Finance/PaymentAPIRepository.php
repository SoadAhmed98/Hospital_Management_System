<?php

namespace App\Repository\Finance;

use App\Interfaces\Finance\PaymentAPIRepositoryInterface;
use App\Models\FundAccount;
use App\Models\Patient;
use App\Models\PatientAccount;
use App\Models\PaymentAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class PaymentAPIRepository implements PaymentAPIRepositoryInterface
{

    public function index(): JsonResponse
    {
        $payments = PaymentAccount::all();
        return response()->json($payments);
    }

    public function show($id): JsonResponse
    {
        $payment_account = PaymentAccount::findOrFail($id);
        return response()->json($payment_account);
    }

    public function store($request): JsonResponse
    {
        DB::beginTransaction();

        try {
            // store payment_accounts
            $payment_accounts = new PaymentAccount();
            $payment_accounts->date = date('Y-m-d');
            $payment_accounts->patient_id = $request->patient_id;
            $payment_accounts->amount = $request->amount;
            $payment_accounts->description = $request->description;
            $payment_accounts->save();

            // store fund_accounts
            $fund_accounts = new FundAccount();
            $fund_accounts->date = date('Y-m-d');
            $fund_accounts->Payment_id = $payment_accounts->id;
            $fund_accounts->credit = $request->amount;
            $fund_accounts->Debit = 0.00;
            $fund_accounts->save();

            // store patient_accounts
            $patient_accounts = new PatientAccount();
            $patient_accounts->date = date('Y-m-d');
            $patient_accounts->patient_id = $request->patient_id;
            $patient_accounts->Payment_id = $payment_accounts->id;
            $patient_accounts->Debit = $request->amount;
            $patient_accounts->credit = 0.00;
            $patient_accounts->save();

            DB::commit();
            return response()->json(['message' => 'Payment created successfully'], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update($request, $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            // update payment_accounts
            $payment_accounts = PaymentAccount::findOrFail($id);
            $payment_accounts->date = date('Y-m-d');
            $payment_accounts->patient_id = $request->patient_id;
            $payment_accounts->amount = $request->amount;
            $payment_accounts->description = $request->description;
            $payment_accounts->save();

            // update fund_accounts
            $fund_accounts = FundAccount::where('Payment_id', $payment_accounts->id)->first();
            $fund_accounts->date = date('Y-m-d');
            $fund_accounts->Payment_id = $payment_accounts->id;
            $fund_accounts->credit = $request->amount;
            $fund_accounts->Debit = 0.00;
            $fund_accounts->save();

            // update patient_accounts
            $patient_accounts = PatientAccount::where('Payment_id', $payment_accounts->id)->first();
            $patient_accounts->date = date('Y-m-d');
            $patient_accounts->patient_id = $request->patient_id;
            $patient_accounts->Payment_id = $payment_accounts->id;
            $patient_accounts->Debit = $request->amount;
            $patient_accounts->credit = 0.00;
            $patient_accounts->save();

            DB::commit();
            return response()->json(['message' => 'Payment updated successfully'], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            PaymentAccount::destroy($id);
            return response()->json(['message' => 'Payment deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
