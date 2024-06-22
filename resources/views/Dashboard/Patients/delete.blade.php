<div class="modal fade" id="Deleted{{ $patient->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Patient Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Patients.destroy', $patient->id) }}" method="post">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="id" value="{{ $patient->id }}">
                    <div class="row">
                        <div class="col">
                            <p class="h5 text-danger"> Are you sure you want to delete this patient data ?</p>
                            <input type="text" class="form-control" readonly value="{{ $patient->name }}">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>