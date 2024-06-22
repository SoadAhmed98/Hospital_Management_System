<!-- Modal -->
<div class="modal fade" id="delete{{ $doctor->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                   Doctor Delete </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('Doctors.destroy', $doctor->id) }}" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <h5>Are you sure about the deletion process?</h5>
                    <input type="hidden" value="1" name="page_id">
                    @if($doctor->image)
                        <input type="hidden" name="filename" value="{{$doctor->image->filename}}">
                    @endif
                    <input type="hidden" name="id" value="{{ $doctor->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">Delete</button>
                    <button type="submit"
                        class="btn btn-danger">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
