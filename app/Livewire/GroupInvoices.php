<?php

namespace App\Livewire;

use App\Models\Group;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use Livewire\Component;
use App\Models\FundAccount;
use App\Models\GroupInvoice;
use App\Models\group_invoice;
use App\Models\PatientAccount;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class GroupInvoices extends Component
{
    public $InvoiceSaved,$InvoiceUpdated;
    public $show_table = true;
    public $tax_rate = 17;
    public $updateMode = false;
    public $price,$patient_id,$doctor_id,$department_id,$type,$Group_id,$catchError;
    public $discount_value=0;
    public $tax_value = 0;
    public $total_with_tax = 0; 
    public $group_invoice_id;
    public function mount()
    {
        $this->calculateTotals();
    }

    public function render()
    {
        return view('livewire.GroupInvoices.group-invoices', [
            'group_invoices'=> Invoice::where('invoice_type',2)->get(),
            'Patients'=> Patient::all(),
            'Doctors'=> Doctor::all(),
            'Groups'=>Group::all(),
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
        $this->price =Group::where('id', $this->Group_id)->first()->Total_before_discount;
        $this->discount_value = Group::where('id', $this->Group_id)->first()->discount_value;
        $this->tax_rate = Group::where('id', $this->Group_id)->first()->tax_rate;
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
        $group_invoices = Invoice::findorfail($id);
        $this->group_invoice_id = $group_invoices->id;
        $this->patient_id = $group_invoices->patient_id;
        $this->doctor_id = $group_invoices->doctor_id;
        $this->department_id = DB::table('departments')->where('id', $group_invoices->department_id)->first()->name;
        $this->Group_id = $group_invoices->Group_id;
        $this->price = $group_invoices->price;
        $this->discount_value = $group_invoices->discount_value;
        $this->tax_rate = $group_invoices->tax_rate;
        $this->tax_value = $group_invoices->tax_value;
        $this->type = $group_invoices->type;


    }

    // public function store(){

    //     $group_invoices = new GroupInvoice();
    //     $group_invoices->invoice_date = date('Y-m-d');
    //     $group_invoices->patient_id = $this->patient_id;
    //     $group_invoices->doctor_id = $this->doctor_id;
    //     $group_invoices->department_id = DB::table('departments')->where('name', $this->department_id)->first()->id;
    //     $group_invoices->group_id = $this->Group_id;
    //     $group_invoices->price = $this->price;
    //     $group_invoices->discount_value = $this->discount_value;
    //     $group_invoices->tax_rate = $this->tax_rate;
    //     // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
    //     $group_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
    //     // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
    //     $group_invoices->total_with_tax = $group_invoices->price -  $group_invoices->discount_value + $group_invoices->tax_value;
    //     $group_invoices->type = $this->type;
    //     $group_invoices->save();
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

                    $group_invoices = Invoice::findorfail($this->group_invoice_id);
                    $group_invoices->invoice_type = 2;
                    $group_invoices->invoice_date = date('Y-m-d');
                    $group_invoices->patient_id = $this->patient_id;
                    $group_invoices->doctor_id = $this->doctor_id;
                    $group_invoices->department_id = DB::table('departments')->where('name', $this->department_id)->first()->id;
                    $group_invoices->Group_id = $this->Group_id;
                    $group_invoices->price = $this->price;
                    $group_invoices->discount_value = $this->discount_value;
                    $group_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $group_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $group_invoices->total_with_tax = $group_invoices->price -  $group_invoices->discount_value + $group_invoices->tax_value;
                    $group_invoices->type = $this->type;
                    $group_invoices->save();

                    $fund_accounts = FundAccount::where('invoice_id',$this->group_invoice_id)->first();
                    $fund_accounts->date = date('Y-m-d');
                    $fund_accounts->invoice_id = $group_invoices->id;
                    $fund_accounts->Debit = $group_invoices->total_with_tax;
                    $fund_accounts->credit = 0.00;
                    $fund_accounts->save();
                    $this->InvoiceUpdated =true;
                    $this->show_table =true;

                }

                // في حالة الاضافة
                else{
                    $group_invoices = new Invoice();
                    $group_invoices->invoice_type = 2;
                    $group_invoices->invoice_date = date('Y-m-d');
                    $group_invoices->patient_id = $this->patient_id;
                    $group_invoices->doctor_id = $this->doctor_id;
                    $group_invoices->department_id = DB::table('departments')->where('name', $this->department_id)->first()->id;
                    $group_invoices->Group_id = $this->Group_id;
                    $group_invoices->price = $this->price;
                    $group_invoices->discount_value = $this->discount_value;
                    $group_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $group_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $group_invoices->total_with_tax = $group_invoices->price -  $group_invoices->discount_value + $group_invoices->tax_value;
                    $group_invoices->type = $this->type;
                    $group_invoices->save();

                    $fund_accounts = new FundAccount();
                    $fund_accounts->date = date('Y-m-d');
                    $fund_accounts->invoice_id = $group_invoices->id;
                    $fund_accounts->Debit = $group_invoices->total_with_tax;
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

                    $group_invoices = Invoice::findorfail($this->group_invoice_id);
                    $group_invoices->invoice_type = 2;
                    $group_invoices->invoice_date = date('Y-m-d');
                    $group_invoices->patient_id = $this->patient_id;
                    $group_invoices->doctor_id = $this->doctor_id;
                    $group_invoices->department_id = DB::table('departments')->where('name', $this->department_id)->first()->id;
                    $group_invoices->Group_id = $this->Group_id;
                    $group_invoices->price = $this->price;
                    $group_invoices->discount_value = $this->discount_value;
                    $group_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $group_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $group_invoices->total_with_tax = $group_invoices->price -  $group_invoices->discount_value + $group_invoices->tax_value;
                    $group_invoices->type = $this->type;
                    $group_invoices->save();

                    $patient_accounts = PatientAccount::where('invoice_id',$this->group_invoice_id)->first();
                    $patient_accounts->date = date('Y-m-d');
                    $patient_accounts->invoice_id = $group_invoices->id;
                    $patient_accounts->patient_id = $group_invoices->patient_id;
                    $patient_accounts->Debit = $group_invoices->total_with_tax;
                    $patient_accounts->credit = 0.00;
                    $patient_accounts->save();
                    $this->InvoiceUpdated =true;
                    $this->show_table =true;

                }

                // في حالة الاضافة
                else{

                    $group_invoices = new Invoice();
                    $group_invoices->invoice_type = 2;
                    $group_invoices->invoice_date = date('Y-m-d');
                    $group_invoices->patient_id = $this->patient_id;
                    $group_invoices->doctor_id = $this->doctor_id;
                    $group_invoices->department_id = DB::table('departments')->where('name', $this->department_id)->first()->id;
                    $group_invoices->Group_id = $this->Group_id;
                    $group_invoices->price = $this->price;
                    $group_invoices->discount_value = $this->discount_value;
                    $group_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $group_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $group_invoices->total_with_tax = $group_invoices->price -  $group_invoices->discount_value + $group_invoices->tax_value;
                    $group_invoices->type = $this->type;
                    $group_invoices->invoice_status = 1;
                    $group_invoices->save();

                    $patient_accounts = new PatientAccount();
                    $patient_accounts->date = date('Y-m-d');
                    $patient_accounts->invoice_id = $group_invoices->id;
                    $patient_accounts->patient_id = $group_invoices->patient_id;
                    $patient_accounts->Debit = $group_invoices->total_with_tax;
                    $patient_accounts->credit = 0.00;
                    $patient_accounts->save();
                    $this->InvoiceSaved =true;
                    $this->show_table =true;
                }

                DB::commit();
            }

            catch (\Exception $e) {
                DB::rollback();
                $this->catchError = $e->getMessage();
            }


        }

    }


    public function delete($id){

        $this->group_invoice_id = $id;

    }

    public function destroy(){
        Invoice::destroy($this->group_invoice_id);
        return redirect()->route('group_invoices');
    }

    public function print($id)
    {
        $group_invoice = Invoice::findorfail($id);
        return Redirect::route('group_Print_single_invoices',[
            'invoice_date' => $group_invoice->invoice_date,
            'doctor_id' => $group_invoice->Doctor->name,
            'department_id' => $group_invoice->Department->name,
            'Group_id' => $group_invoice->Group->name,
            'type' => $group_invoice->type,
            'price' => $group_invoice->price,
            'discount_value' => $group_invoice->discount_value,
            'tax_rate' => $group_invoice->tax_rate,
            'total_with_tax' => $group_invoice->total_with_tax,
        ]);

    }
}
