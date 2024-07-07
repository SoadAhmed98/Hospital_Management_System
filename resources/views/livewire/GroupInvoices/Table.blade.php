<button class="btn btn-primary pull-right" wire:click="show_form_add" type="button">Add New Invoice</button><br><br>
<div class="table-responsive">
    <table class="table text-md-nowrap" id="example2" data-page-length="50" style="text-align: center">
        <thead>
        <tr>
            <th>#</th>
            <th>Service Name</th>
            <th>Patient Name</th>
            <th>Invoice Date</th>
            <th>Doctor Name</th>
            <th>Department</th>
            <th>Service Price</th>
            <th>Discount Value</th>
            <th>Tax Rate</th>
            <th>Tax Value</th>
            <th>Total with Tax</th>
            <th>Invoice Type</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($group_invoices as $group_invoice)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $group_invoice->Group->name }}</td>
                <td>{{ $group_invoice->Patient->name }}</td>
                <td>{{ $group_invoice->invoice_date }}</td>
                <td>{{ $group_invoice->Doctor->name }}</td>
                <td>{{ $group_invoice->Department->name }}</td>
                <td>{{ number_format($group_invoice->price, 2) }}</td>
                <td>{{ number_format($group_invoice->discount_value, 2) }}</td>
                <td>{{ $group_invoice->tax_rate }}%</td>
                <td>{{ number_format($group_invoice->tax_value, 2) }}</td>
                <td>{{ number_format($group_invoice->total_with_tax, 2) }}</td>
                <td>{{ $group_invoice->type == 1 ? 'Cash' : 'Credit' }}</td>
                <td>
                    <button wire:click="edit({{ $group_invoice->id }})" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_invoice" wire:click="delete({{ $group_invoice->id }})"><i class="fa fa-trash"></i></button>
                    <button wire:click="print({{ $group_invoice->id }})" class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                </td>
            </tr>
        @endforeach
    </table>
    @include('livewire.GroupInvoices.delete')
</div>
