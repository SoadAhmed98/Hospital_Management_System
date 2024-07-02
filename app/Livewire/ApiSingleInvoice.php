<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invoice;

class ApiSingleInvoice extends Component
{
    public function render()
    {
        return view('livewire.api-single-invoice', [
            'single_invoices' => Invoice::where('invoice_type', 1)->get(),
        ]);
    }
}
