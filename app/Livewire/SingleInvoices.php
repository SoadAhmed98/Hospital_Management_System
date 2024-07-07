<?php

namespace App\Livewire;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Service;
use Livewire\Component;
use App\Models\FundAccount;
use App\Models\SingleInvoice;
use App\Models\PatientAccount;
use App\Models\single_invoice;
use App\Models\Invoice;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class SingleInvoices extends Component
{
    public $InvoiceSaved,$InvoiceUpdated;
    public $show_table = true;
    public $tax_rate = 17;
    public $updateMode = false;
    public $price,$patient_id,$doctor_id,$department_id,$type,$Service_id,$single_invoice_id,$catchError;
    public $discount_value=0;
    public $tax_value = 0;
    public $total_with_tax = 0; 

    public function mount()
    {
        $this->calculateTotals();
    }

    public function render()
    {
        return view('livewire.SingleInvoices.single-invoices', [
            'single_invoices'=> Invoice::where('invoice_type',1)->get(),
            'Patients'=> Patient::all(),
            'Doctors'=> Doctor::all(),
            'Services'=> Service::all(),
            'subtotal' => $Total_after_discount = ((is_numeric($this->price) ? $this->price : 0)) - ((is_numeric($this->discount_value) ? $this->discount_value : 0)),
            'tax_value'=> $Total_after_discount * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100)
        ]);
    }

    public function show_form_add(){
        $this->show_table = false;
    }

    public function get_department()
    {
        $doctor_id = Doctor::with('department')->where('id', $this->doctor_id)->first();
        $this->department_id = $doctor_id->department->name;

    }

    public function get_price()
    {
        $this->price = Service::where('id', $this->Service_id)->first()->price;
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $subtotal = (is_numeric($this->price) ? $this->price : 0) - (is_numeric($this->discount_value) ? $this->discount_value : 0);
        $this->tax_value = $subtotal * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
        $this->total_with_tax = $subtotal + $this->tax_value;
    }

    public function edit($id){

        $this->show_table = false;
        $this->updateMode = true;
        $single_invoice = Invoice::findorfail($id);
        $this->single_invoice_id = $single_invoice->id;
        $this->patient_id = $single_invoice->patient_id;
        $this->doctor_id = $single_invoice->doctor_id;
        $this->department_id = DB::table('departments')->where('id', $single_invoice->department_id)->first()->name;
        $this->Service_id = $single_invoice->Service_id;
        // dd($single_invoice,$single_invoice->Service_id);
        $this->price = $single_invoice->price;
        $this->discount_value = $single_invoice->discount_value;
        $this->type = $single_invoice->type;
        $this->discount_value = $single_invoice->discount_value;
        $this->tax_rate = $single_invoice->tax_rate;
        $this->tax_value = $single_invoice->tax_value;


    }

    // public function store(){

    //     $single_invoices = new SingleInvoice();
    //     $single_invoices->invoice_date = date('Y-m-d');
    //     $single_invoices->patient_id = $this->patient_id;
    //     $single_invoices->doctor_id = $this->doctor_id;
    //     $single_invoices->department_id = DB::table('departments')->where('name', $this->department_id)->first()->id;
    //     $single_invoices->service_id = $this->Service_id;
    //     $single_invoices->price = $this->price;
    //     $single_invoices->discount_value = $this->discount_value;
    //     $single_invoices->tax_rate = $this->tax_rate;
    //     // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
    //     $single_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
    //     // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
    //     $single_invoices->total_with_tax = $single_invoices->price -  $single_invoices->discount_value + $single_invoices->tax_value;
    //     $single_invoices->type = $this->type;
    //     $single_invoices->save();
    //     $this->InvoiceSaved =true;
    //     $this->show_table =true;
    // }
    public function store(){

        // في حالة كانت الفاتورة نقدي
        if($this->type == 1){

            DB::beginTransaction();
            try {

                // في حالة التعديل
                if($this->updateMode){

                    $single_invoices = Invoice::findorfail($this->single_invoice_id);
                    $single_invoices->invoice_type = 1;
                    $single_invoices->invoice_date = date('Y-m-d');
                    $single_invoices->patient_id = $this->patient_id;
                    $single_invoices->doctor_id = $this->doctor_id;
                    $single_invoices->department_id = DB::table('departments')->where('name', $this->department_id)->first()->id;
                    $single_invoices->service_id = $this->Service_id;
                    $single_invoices->price = $this->price;
                    $single_invoices->discount_value = $this->discount_value;
                    $single_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $single_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $single_invoices->total_with_tax = $single_invoices->price -  $single_invoices->discount_value + $single_invoices->tax_value;
                    $single_invoices->type = $this->type;
                    $single_invoices->invoice_status = 1;
                    $single_invoices->save();

                    $fund_accounts = FundAccount::where('invoice_id',$this->single_invoice_id)->first();
                    $fund_accounts->date = date('Y-m-d');
                    $fund_accounts->invoice_id = $single_invoices->id;
                    $fund_accounts->Debit = $single_invoices->total_with_tax;
                    $fund_accounts->credit = 0.00;
                    $fund_accounts->save();
                    $this->InvoiceUpdated =true;
                    $this->show_table =true;

                }

                // في حالة الاضافة
                else{
                    $single_invoices = new Invoice();
                    $single_invoices->invoice_type = 1;
                    $single_invoices->invoice_date = date('Y-m-d');
                    $single_invoices->patient_id = $this->patient_id;
                    $single_invoices->doctor_id = $this->doctor_id;
                    $single_invoices->department_id = DB::table('departments')->where('name', $this->department_id)->first()->id;
                    $single_invoices->service_id = $this->Service_id;
                    $single_invoices->price = $this->price;
                    $single_invoices->discount_value = $this->discount_value;
                    $single_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $single_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $single_invoices->total_with_tax = $single_invoices->price -  $single_invoices->discount_value + $single_invoices->tax_value;
                    $single_invoices->type = $this->type;
                    $single_invoices->invoice_status = 1;
                    $single_invoices->save();

                    $fund_accounts = new FundAccount();
                    $fund_accounts->date = date('Y-m-d');
                    $fund_accounts->invoice_id = $single_invoices->id;
                    $fund_accounts->Debit = $single_invoices->total_with_tax;
                    $fund_accounts->credit = 0.00;
                    $fund_accounts->save();
                    $this->InvoiceSaved =true;
                    $this->show_table =true;
                }
                DB::commit();
            }

            catch (\Exception $e) {
                DB::rollback();
                dd($e->getMessage());
                $this->catchError = $e->getMessage();
            }

        }


        //------------------------------------------------------------------------

        // في حالة كانت الفاتورة اجل
        else{

            DB::beginTransaction();
            try {

                // في حالة التعديل
                if($this->updateMode){

                    $single_invoices = Invoice::findorfail($this->single_invoice_id);
                    $single_invoices->invoice_type = 1;
                    $single_invoices->invoice_date = date('Y-m-d');
                    $single_invoices->patient_id = $this->patient_id;
                    $single_invoices->doctor_id = $this->doctor_id;
                    $single_invoices->department_id = DB::table('departments')->where('name', $this->department_id)->first()->id;
                    $single_invoices->service_id = $this->Service_id;
                    $single_invoices->price = $this->price;
                    $single_invoices->discount_value = $this->discount_value;
                    $single_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $single_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $single_invoices->total_with_tax = $single_invoices->price -  $single_invoices->discount_value + $single_invoices->tax_value;
                    $single_invoices->type = $this->type;
                    $single_invoices->save();

                    $patient_accounts = PatientAccount::where('invoice_id',$this->single_invoice_id)->first();
                    $patient_accounts->date = date('Y-m-d');
                    $patient_accounts->invoice_id = $single_invoices->id;
                    $patient_accounts->patient_id = $single_invoices->patient_id;
                    $patient_accounts->Debit = $single_invoices->total_with_tax;
                    $patient_accounts->credit = 0.00;
                    $patient_accounts->save();
                    $this->InvoiceUpdated =true;
                    $this->show_table =true;

                }

                // في حالة الاضافة
                else{

                    $single_invoices = new Invoice();
                    $single_invoices->invoice_type = 1;
                    $single_invoices->invoice_date = date('Y-m-d');
                    $single_invoices->patient_id = $this->patient_id;
                    $single_invoices->doctor_id = $this->doctor_id;
                    $single_invoices->department_id = DB::table('departments')->where('name', $this->department_id)->first()->id;
                    $single_invoices->service_id = $this->Service_id;
                    $single_invoices->price = $this->price;
                    $single_invoices->discount_value = $this->discount_value;
                    $single_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $single_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $single_invoices->total_with_tax = $single_invoices->price -  $single_invoices->discount_value + $single_invoices->tax_value;
                    $single_invoices->type = $this->type;
                    $single_invoices->invoice_status = 1;
                    $single_invoices->save();

                    $patient_accounts = new PatientAccount();
                    $patient_accounts->date = date('Y-m-d');
                    $patient_accounts->invoice_id = $single_invoices->id;
                    $patient_accounts->patient_id = $single_invoices->patient_id;
                    $patient_accounts->Debit = $single_invoices->total_with_tax;
                    $patient_accounts->credit = 0.00;
                    $patient_accounts->save();
                    $this->InvoiceSaved =true;
                    $this->show_table =true;
                }

                DB::commit();
            }

            catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }


        }

    }


    public function delete($id){

     $this->single_invoice_id = $id;

    }

    public function destroy(){
        Invoice::destroy($this->single_invoice_id);
        return redirect()->route('single_invoices');
    }

    public function print($id)
    {
        $single_invoice = Invoice::findorfail($id);
        return Redirect::route('Print_single_invoices',[
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
