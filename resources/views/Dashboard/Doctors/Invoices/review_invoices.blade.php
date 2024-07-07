@extends('Dashboard.layouts.master-doctor')
@section('title')
   Reviews
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('Dashboard/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal Notify -->
    <link href="{{URL::asset('dashboard/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
    <link href="{{URL::asset('dashboard/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal Datetimepicker-slider css -->
    <link href="{{URL::asset('dashboard/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}" rel="stylesheet">
    <link href="{{URL::asset('dashboard/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}" rel="stylesheet">
    <link href="{{URL::asset('dashboard/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{URL::asset('dashboard/plugins/spectrum-colorpicker/spectrum.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Reviews</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Invoices</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
@include('Dashboard.messages_alert')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice Date</th>
                                    <th>Service Name</th>
                                    <th>Patient Name</th>
                                    <th>Service Price</th>
                                    <th>Discount Value</th>
                                    <th>Tax Rate</th>
                                    <th>Tax Value</th>
                                    <th>Total with Tax</th>
                                    <th>Invoice Status</th>
                                    <th>Review Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $invoice)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ $invoice->Service->name ?? $invoice->Group->name }}</td>
                                        <td><a href="{{route('patient_details',$invoice->patient_id)}}">{{ $invoice->Patient->name }}</a></td>
                                        <td>{{ number_format($invoice->price, 2) }}</td>
                                        <td>{{ number_format($invoice->discount_value, 2) }}</td>
                                        <td>{{ $invoice->tax_rate }}%</td>
                                        <td>{{ number_format($invoice->tax_value, 2) }}</td>
                                        <td>{{ number_format($invoice->total_with_tax, 2) }}</td>
                                        <td>
                                            @if($invoice->invoice_status == 1)
                                                <span class="badge badge-danger">In Progress</span>
                                            @elseif($invoice->invoice_status == 2)
                                                <span class="badge badge-warning">Review</span>
                                            @else
                                                <span class="badge badge-success">Completed</span>
                                            @endif
                                        </td>
                                        <td>{{\App\Models\PatientHistory::where(['invoice_id' => $invoice->id])->first()->review_date}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-outline-primary btn-sm" data-toggle="dropdown" type="button">Actions<i class="fas fa-caret-down mr-1"></i></button>
                                                <div class="dropdown-menu tx-13">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#add_patient_history{{$invoice->id}}"><i class="text-primary fa fa-stethoscope"></i>&nbsp;&nbsp;Add patient_history</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#add_review{{$invoice->id}}"><i class="text-warning far fa-file-alt"></i>&nbsp;&nbsp;Add Review</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#laboratorie_conversion{{$invoice->id}}"><i class="text-warning fas fa-syringe"></i>&nbsp;&nbsp;Refer to Lab</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete"><i class="text-danger ti-trash"></i>&nbsp;&nbsp;Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @include('Dashboard.Doctors.Invoices.add_patient_history')
                                    @include('Dashboard.Doctors.Invoices.add_review')
                                    @include('Dashboard.Doctors.Invoices.Laboratorie_conversion')
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->

    <!-- /row -->
</div>
<!-- row closed -->

<!-- Container closed -->

<!-- main-content closed -->
@endsection
@section('js')
    <!--Internal Notify js -->
    <script src="{{URL::asset('dashboard/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>

    <!--Internal Datepicker js -->
    <script src="{{URL::asset('dashboard/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!--Internal jquery.maskedinput js -->
    <script src="{{URL::asset('dashboard/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
    <!--Internal spectrum-colorpicker js -->
    <script src="{{URL::asset('dashboard/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{URL::asset('dashboard/plugins/select2/js/select2.min.js')}}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{URL::asset('dashboard/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
    <!--Internal jquery-simple-datetimepicker js -->
    <script src="{{URL::asset('dashboard/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
    <!-- Ionicons js -->
    <script src="{{URL::asset('dashboard/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
    <!--Internal pickerjs js -->
    <script src="{{URL::asset('dashboard/plugins/pickerjs/picker.min.js')}}"></script>
    <!-- Internal form-elements js -->
    <script src="{{URL::asset('dashboard/js/form-elements.js')}}"></script>
@endsection
