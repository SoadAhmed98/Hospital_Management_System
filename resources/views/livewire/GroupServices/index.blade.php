@livewireStyles


<button class="btn btn-primary pull-right" wire:click="show_form_add" type="button">Add Group Services</button><br><br>
<div class="table-responsive">
<table class="table text-md-nowrap" id="example1" data-page-length="50" style="text-align: center">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Total</th>
            <th>Notes</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($groups as $group)
            @if ($group->Total_with_tax > 0)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $group->name }}</td>
                    <td>{{ number_format($group->Total_with_tax, 2) }}</td>
                    <td>{{ $group->notes }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" wire:click="edit({{ $group->id }})" type="button"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" wire:click="delete({{ $group->id }})" type="button"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>

</div>
@livewireScripts
