<?php

namespace App\Http\Controllers\Api;

use App\Models\Group;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Service;
use App\Traits\ApiTrait;
use App\Models\FundAccount;
use Illuminate\Http\Request;
use App\Models\PatientAccount;
use App\Models\ReceiptAccount;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\FatoorahServices;
use App\Http\Requests\InvoiceFatoorahRequest;
use Illuminate\Support\Facades\Log;

class InvoiceFatoorahController extends Controller
{
   

    private $fatoorahServices;

    public function __construct(FatoorahServices $fatoorahServices)
    {
        $this->fatoorahServices = $fatoorahServices;
    }

    public function payment(InvoiceFatoorahRequest $request)
    {
        

        $token = $request->header('authorization');
        $patient = Auth::guard('sanctum')->user();
        $patient = Patient::find($patient->id);

        $PaymentData = $request->only('CustomerName', 'CustomerEmail', 'InvoiceValue');

       
        $additionalData = [
            'CallBackUrl'        => env('invoice_success_url').'?single_id=' . $request->single_id .
                                     '&group_id=' . $request->group_id.
                                     '&InvoiceValue='.$request->InvoiceValue.
                                     '&invoiceType='.$request->type.
                                     '&doctor='. $request->doctor_id.
                                     '&patient='.$patient->id.
                                     '&discount_value='.$request->discount_value.
                                     '&tax_rate='.$request->tax_rate
                                     ,

            'ErrorUrl'           => env('invoice_error_url'), // or 'https://example.com/error.php'
            'Language'           => 'en', // or 'ar'
            'NotificationOption' => 'LNK', // 'SMS', 'EML', or 'ALL'
            'DisplayCurrencyIso' => 'EGP',
        ];

        $data = array_merge($PaymentData, $additionalData);

        return $this->fatoorahServices->sendPayment($data);
    }

    public function PaymentCallback(Request $request)
    {
       
        $data = [
            'Key' => $request->paymentId,
            'KeyType' => 'paymentId'
        ];

        $paymentStatus = $this->fatoorahServices->getPaymentStatus($data);

        // Log payment status for debugging
        Log::info('Payment status:', $paymentStatus);

        // Save invoice in db
        DB::beginTransaction();
        try {
            $single_id = $request->query('single_id');
            $group_id = $request->query('group_id');
            $InvoiceValue = $request->query('InvoiceValue');
            $invoiceType = $request->query('invoiceType');
            $doctor = $request->query('doctor');
            $doctor=Doctor::with('department')->findOrFail($doctor);
            $department_id=$doctor->department->id;
            $patient = $request->query('patient');
            $discount_value = $request->query('discount_value');
            $tax_rate = $request->query('tax_rate');
            // dd($single_id, $group_id, $InvoiceValue, $invoiceType, $doctor, $department_id, $patient, $discount_value, $tax_rate);
            if ($single_id) {

                $service = Service::findOrFail($single_id);
                $price = $service->price;

                $subtotal = $price - $discount_value;
                $tax_value = $subtotal * ($tax_rate / 100);
                $total_with_tax = $subtotal + $tax_value;

                $invoice = new Invoice();
                $invoice->invoice_type = 1;
                $invoice->invoice_date = date('Y-m-d');
                $invoice->patient_id = $patient;
                $invoice->doctor_id = $doctor->id;
                $invoice->department_id = $department_id;
                $invoice->service_id = $service->id;
                $invoice->price = $price;
                $invoice->discount_value = $discount_value;
                $invoice->tax_rate = $tax_rate;
                $invoice->tax_value = $tax_value;
                $invoice->total_with_tax = $total_with_tax;
                $invoice->type = $invoiceType;
                $invoice->invoice_status = 1;
                $invoice->save();

                if ($invoiceType == 1) {
                    $fund_account = new FundAccount();
                    $fund_account->date = date('Y-m-d');
                    $fund_account->invoice_id = $invoice->id;
                    $fund_account->Debit = $total_with_tax;
                    $fund_account->credit = 0.00;
                    $fund_account->save();
                } else {
                    $patient_account = new PatientAccount();
                    $patient_account->date = date('Y-m-d');
                    $patient_account->invoice_id = $invoice->id;
                    $patient_account->patient_id = $patient;
                    $patient_account->Debit = $total_with_tax;
                    $patient_account->credit = 0.00;
                    $patient_account->save();

                    $receipt_account = new ReceiptAccount();
                    $receipt_account->date = date('Y-m-d');
                    $receipt_account->patient_id =$patient;
                    $receipt_account->description = "A deposit";
                    $receipt_account->amount = $InvoiceValue;
                    $receipt_account->save();

                    $fund_account = new FundAccount();
                    $fund_account->date = date('Y-m-d');
                    $fund_account->receipt_id = $receipt_account->id;
                    $fund_account->Debit = $InvoiceValue;
                    $fund_account->credit = 0.00;
                    $fund_account->save();

                    $patient_account2 = new PatientAccount();
                    $patient_account2->date = date('Y-m-d');
                    $patient_account2->patient_id = $patient;
                    $patient_account2->receipt_id = $receipt_account->id;
                    $patient_account2->Debit = 0.00;
                    $patient_account2->credit = $InvoiceValue;
                    $patient_account2->save();
                }
            } elseif ($group_id) {
                $group = Group::findOrFail($group_id);
                $price = $group->Total_with_tax;

                $subtotal = $price - $group->discount_value;
                $tax_value = $subtotal * ($group->tax_rate / 100);
                $total_with_tax = $subtotal + $tax_value;

                $invoice = new Invoice();
                $invoice->invoice_type = 2;
                $invoice->invoice_date = date('Y-m-d');
                $invoice->patient_id = $patient;
                $invoice->doctor_id = $doctor->id;
                $invoice->department_id = $department_id;
                $invoice->group_id = $group->id;
                $invoice->price = $price;
                $invoice->discount_value = $group->discount_value;
                $invoice->tax_rate = $group->tax_rate;
                $invoice->tax_value = $tax_value;
                $invoice->total_with_tax = $total_with_tax;
                $invoice->type = $invoiceType;
                $invoice->invoice_status = 1;
                $invoice->save();

                if ($invoiceType == 1) {
                    $fund_account = new FundAccount();
                    $fund_account->date = date('Y-m-d');
                    $fund_account->invoice_id = $invoice->id;
                    $fund_account->Debit = $total_with_tax;
                    $fund_account->credit = 0.00;
                    $fund_account->save();
                } else {
                    $patient_account = new PatientAccount();
                    $patient_account->date = date('Y-m-d');
                    $patient_account->invoice_id = $invoice->id;
                    $patient_account->patient_id = $patient;
                    $patient_account->Debit = $total_with_tax;
                    $patient_account->credit = 0.00;
                    $patient_account->save();

                    $receipt_account = new ReceiptAccount();
                    $receipt_account->date = date('Y-m-d');
                    $receipt_account->patient_id =$patient;
                    $receipt_account->amount = $InvoiceValue;
                    $receipt_account->description = "A deposit";
                    $receipt_account->save();

                    $fund_account = new FundAccount();
                    $fund_account->date = date('Y-m-d');
                    $fund_account->receipt_id = $receipt_account->id;
                    $fund_account->Debit = $InvoiceValue;
                    $fund_account->credit = 0.00;
                    $fund_account->save();

                    $patient_account2 = new PatientAccount();
                    $patient_account2->date = date('Y-m-d');
                    $patient_account2->patient_id = $patient;
                    $patient_account2->receipt_id = $receipt_account->id;
                    $patient_account2->Debit = 0.00;
                    $patient_account2->credit = $InvoiceValue;
                    $patient_account2->save();
                }
            }

            DB::commit();
            return ApiTrait::SuccessMessage('Payment happened successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error during payment callback: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function PaymentError()
    {
        return ApiTrait::ErrorMessage([], 'Failed Payment Attempt', 400);
    }
}