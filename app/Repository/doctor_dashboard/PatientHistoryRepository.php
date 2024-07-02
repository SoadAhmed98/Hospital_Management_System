<?php

namespace App\Repository\doctor_dashboard;

use App\Interfaces\doctor_dashboard\PatientHistoryRepositoryInterface;
use App\Models\PatientHistory;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class PatientHistoryRepository implements PatientHistoryRepositoryInterface
{
    public function store($request)
    {
        DB::beginTransaction();
        try {

            $this->invoice_status($request->invoice_id,3);
            $patient_history = new PatientHistory();
            $patient_history->date = date('Y-m-d');
            $patient_history->diagnosis = $request->diagnosis;
            $patient_history->medicine = $request->medicine;
            $patient_history->invoice_id = $request->invoice_id;
            $patient_history->patient_id = $request->patient_id;
            $patient_history->doctor_id = $request->doctor_id;
            $patient_history->save();

            DB::commit();

            session()->flash('add');
            return redirect()->back();
        }

        catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $patient_records = PatientHistory::where('patient_id',$id)->get();
        return view('Dashboard.Doctors.invoices.patient_record',compact('patient_records'));
    }

    public function addReview($request)
    {
        //beginTransaction عشان بعمل كويري علي جدولين فلو حصلت مشكلة في الاول متحصلش في التاني واقدر أعمل rollback
        DB::beginTransaction();
        try {

            $this->invoice_status($request->invoice_id,2);
            $patient_history = new PatientHistory();
            $patient_history->date = date('Y-m-d');
            $patient_history->review_date =  $request->review_date;
            $patient_history->diagnosis = $request->diagnosis;
            $patient_history->medicine = $request->medicine;
            $patient_history->invoice_id = $request->invoice_id;
            $patient_history->patient_id = $request->patient_id;
            $patient_history->doctor_id = $request->doctor_id;
            $patient_history->save();

            DB::commit();
            session()->flash('add');
            return redirect()->back();
        }

        catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function invoice_status($invoice_id,$id_status){
        $invoice_status = Invoice::findorFail($invoice_id);
        $invoice_status->update([
            'invoice_status'=>$id_status
        ]);
    }
}