
<!-- Edit Modal -->
<div class="modal fade" id="edit{{ $service->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('Services.edit_Service') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('Service.update', $service->id) }}" method="post">
                {{ method_field('patch') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <label for="name">{{ trans('Services.name') }}</label>
                    <input type="text" name="name" id="name" value="{{ $service->name }}" class="form-control">
                    @if ($errors->has('name'))
                        <div class="text-danger">{{ $errors->first('name') }}</div>
                    @endif
                    <br>

                    <input type="hidden" name="id" value="{{ $service->id }}" class="form-control">
                    <br>

                    <label for="price">{{ trans('Services.price') }}</label>
                    <input type="number" name="price" id="price" value="{{ $service->price }}" class="form-control">
                    @if ($errors->has('price'))
                        <div class="text-danger">{{ $errors->first('price') }}</div>
                    @endif
                    <br>

                    <label for="description">{{ trans('Services.description') }}</label>
                    <textarea class="form-control" name="description" id="description" rows="5">{{ $service->description }}</textarea>
                    @if ($errors->has('description'))
                        <div class="text-danger">{{ $errors->first('description') }}</div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('Dashboard/sections_trans.Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('Dashboard/sections_trans.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
<script src="{{ URL::asset('dashboard/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('dashboard/plugins/notify/js/notifit-custom.js') }}"></script>
<script>
    $(document).ready(function () {
        @if ($errors->any())
            @if (old('id'))
                $('#edit' + {{ old('id') }}).modal('show');
            @else
                $('#add').modal('show');
            @endif
        @endif
    });
</script>
@endsection