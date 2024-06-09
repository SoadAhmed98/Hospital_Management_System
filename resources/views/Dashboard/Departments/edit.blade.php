<!-- Modal -->
<div class="modal fade" id="edit{{ $department->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('Departments.update', $department->id) }}" method="post">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <label for="exampleInputPassword1">Department Name</label>
                    <input type="hidden" name="id" value="{{ $department->id }}">
                    <input type="text" name="name" value="{{ $department->name }}" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
