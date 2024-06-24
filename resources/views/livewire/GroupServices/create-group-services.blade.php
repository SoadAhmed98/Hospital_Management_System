<div>

    @if ($ServiceSaved)
        <div class="alert alert-info">Data saved successfully.</div>
    @endif
    @if ($show_table)
         @include('livewire.GroupServices.index')
    @else
    <form wire:submit.prevent="saveGroup" autocomplete="off">
        @csrf
        <div class="form-group">
            <label>Group Name</label>
            <input wire:model="name_group" type="text" name="name_group" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Notes</label>
            <textarea wire:model="notes" name="notes" class="form-control" rows="5"></textarea>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <div class="col-md-12">
                    <button class="btn btn-outline-primary"
                            wire:click.prevent="addService">Add Sub-Service
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="table-primary">
                            <th>Service Name</th>
                            <th width="200">Quantity</th>
                            <th width="200">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($GroupsItems as $index => $groupItem)
                                <tr>
                                    <td>
                                        @if ($groupItem['is_saved'])
                                            <input type="hidden" name="GroupsItems[{{$index}}][service_id]" wire:model="GroupsItems.{{$index}}.service_id" />
                                            {{ $groupItem['service_name'] }} ({{ number_format($groupItem['service_price'], 2) }})
                                        @else
                                            <select name="GroupsItems[{{$index}}][service_id]" class="form-control" wire:model="GroupsItems.{{$index}}.service_id">
                                                <option value="">-- Select Service --</option>
                                                @foreach ($allServices as $service)
                                                    <option value="{{ $service->id }}">{{ $service->name }} ({{ number_format($service->price, 2) }})</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($groupItem['is_saved'])
                                            {{ $groupItem['quantity'] }}
                                        @else
                                            <input type="number" name="GroupsItems[{{$index}}][quantity]" class="form-control" wire:model="GroupsItems.{{$index}}.quantity" />
                                        @endif
                                    </td>
                                    <td>
                                        @if ($groupItem['is_saved'])
                                            <button class="btn btn-sm btn-primary" wire:click.prevent="editService({{$index}})">Edit</button>
                                        @elseif ($groupItem['service_id'])
                                            <button class="btn btn-sm btn-success mr-1" wire:click.prevent="saveService({{$index}})">Confirm</button>
                                        @endif
                                        <button class="btn btn-sm btn-danger" wire:click.prevent="removeService({{$index}})">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="col-lg-4 text-right">
                    <table class="table pull-right">
                        <tr>
                            <td style="color: red">Subtotal</td>
                            <td>{{ number_format($subtotal, 2) }}</td>
                        </tr>

                        <tr>
                            <td style="color: red">Discount Value</td>
                            <td width="125">
                                <input type="number" name="discount_value" class="form-control w-75 d-inline" wire:model="discount_value">
                            </td>
                        </tr>

                        <tr>
                            <td style="color: red">Tax Rate</td>
                            <td>
                                <input type="number" name="taxes" class="form-control w-75 d-inline" min="0" max="100" wire:model="taxes"> %
                            </td>
                        </tr>
                        <tr>
                            <td style="color: red">Total with Tax</td>
                            <td>{{ number_format($total, 2) }}</td>
                        </tr>
                    </table>
                </div> <br/>
                <div>
                    <input class="btn btn-outline-success" type="submit" value="Confirm Data">
                </div>
            </div>
        </div>

    </form>
    @endif
    

</div>

