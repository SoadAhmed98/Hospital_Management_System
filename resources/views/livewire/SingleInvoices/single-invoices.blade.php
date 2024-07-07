<div>
    @if ($catchError)
        <div class="alert alert-danger" id="success-danger">
            <button type="button" class="close" data-dismiss="alert">x</button>
            {{ $catchError }}
        </div>
    @endif
    @if ($InvoiceSaved)
        <div class="alert alert-info">Data saved successfully.</div>
    @endif
    @if ($InvoiceUpdated)
        <div class="alert alert-info">Data updated successfully.</div>
    @endif
    @if($show_table)
        @include('livewire.SingleInvoices.Table')
    @else
        <form wire:submit.prevent="store" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col">
                    <label>Patient Name</label>
                    <select wire:model="patient_id" class="form-control" required>
                        <option value="">-- Select from list --</option>
                        @foreach($Patients as $Patient)
                            <option value="{{ $Patient->id }}">{{ $Patient->name }}</option>
                        @endforeach
                    </select>
                    @error('patient_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col">
                    <label>Doctor Name</label>
                    <select wire:model="doctor_id" wire:change="get_department" class="form-control" id="exampleFormControlSelect1" required>
                        <option value="">-- Select from list --</option>
                        @foreach($Doctors as $Doctor)
                            <option value="{{ $Doctor->id }}">{{ $Doctor->name }}</option>
                        @endforeach
                    </select>
                    @error('doctor_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col">
                    <label>Department</label>
                    <input wire:model="department_id" type="text" class="form-control" readonly>
                </div>
                <div class="col">
                    <label>Invoice Type</label>
                    <select wire:model="type" class="form-control" {{ $updateMode == true ? 'disabled' : '' }}>
                        <option value="">-- Select from list --</option>
                        <option value="1">Cash</option>
                        <option value="2">Deferred</option>
                    </select>
                    @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div><br>
            <div class="row row-sm">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mg-b-0"></h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mg-b-0 text-md-nowrap" style="text-align: center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Service Name</th>
                                        <th>Service Price</th>
                                        <th>Discount Value</th>
                                        <th>Tax Rate</th>
                                        <th>Tax Value</th>
                                        <th>Total with Tax</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                            <select wire:model="Service_id" class="form-control" wire:change="get_price" id="exampleFormControlSelect1">
                                                <option value="">-- Select service --</option>
                                                @foreach($Services as $Service)
                                                    <option value="{{ $Service->id }}">{{ $Service->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('Service_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td><input wire:model="price" type="text" class="form-control" readonly></td>
                                        <td><input wire:model="discount_value" wire:change="calculateTotals" type="text" class="form-control"></td>
                                        <td><input wire:model="tax_rate" wire:change="calculateTotals" type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control" value="{{ $tax_value }}" readonly></td>
                                        <td><input type="text" class="form-control" value="{{ $total_with_tax }}" readonly></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div><!-- bd -->
                        </div><!-- bd -->
                    </div><!-- bd -->
                </div>
            </div>
            <input class="btn btn-outline-success" type="submit" value="Confirm Data">
        </form>
    @endif
</div>
