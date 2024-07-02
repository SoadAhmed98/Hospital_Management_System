<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invoice;

class ApiGroupInvoice extends Component
{
    public function render()
    {
        return view('livewire.api-group-invoice', [
            'group_invoices' => Invoice::where('invoice_type', 2)->get(),
        ]);
    }
}