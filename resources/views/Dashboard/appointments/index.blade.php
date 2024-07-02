@extends('Dashboard.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('Dashboard/plugins/sumoselect/sumoselect-rtl.css') }}">
    <link href="{{ URL::asset('dashboard/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('Dashboard/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('Dashboard/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('Dashboard/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('Dashboard/plugins/pickerjs/picker.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('Dashboard/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Appointments</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Appointment List</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('Dashboard.messages_alert')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Patient Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Doctor</th>
                                    <th>Phone</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $appointment->name }}</td>
                                        <td>{{ $appointment->email }}</td>
                                        <td>{{ $appointment->department->name }}</td>
                                        <td>{{ $appointment->doctor->name }}</td>
                                        <td>{{ $appointment->phone }}</td>
                                        <td>{{ $appointment->notes }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#approval{{ $appointment->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{ $appointment->id }}">
                                                <i class="fas fa-remove-format"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @include('Dashboard.appointments.approval')
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="delete{{ $appointment->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Appointment</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this appointment?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('Dashboard/js/select2.js') }}"></script>
    <script src="{{ URL::asset('Dashboard/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('Dashboard/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <script src="{{ URL::asset('dashboard/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('dashboard/plugins/notify/js/notifit-custom.js') }}"></script>
    <script src="{{ URL::asset('dashboard/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <script src="{{ URL::asset('dashboard/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <script src="{{ URL::asset('dashboard/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <script src="{{ URL::asset('dashboard/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('dashboard/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ URL::asset('dashboard/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <script src="{{ URL::asset('dashboard/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <script src="{{ URL::asset('dashboard/plugins/pickerjs/picker.min.js') }}"></script>
    <script src="{{ URL::asset('dashboard/js/form-elements.js') }}"></script>
@endsection
