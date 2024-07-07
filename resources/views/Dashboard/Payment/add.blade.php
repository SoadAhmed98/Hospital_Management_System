@extends('Dashboard.layouts.master')

@section('css')
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('dashboard/plugins/notify/css/notifIt.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('Dashboard/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('title')
    Add New Payment Voucher
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Accounts</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Add New Payment Voucher</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- Form -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('Payment.store') }}" method="post" autocomplete="off" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="pd-30 pd-sm-40 bg-gray-200">

                            <!-- Patient Name -->
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label>Patient Name</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <select name="patient_id" class="form-control select2 {{ $errors->has('patient_id') ? 'is-invalid' : '' }}" >
                                        <option value=""></option>
                                        @foreach($Patients as $Patient)
                                            <option value="{{ $Patient->id }}" {{ old('patient_id') == $Patient->id ? 'selected' : '' }}>{{ $Patient->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('patient_id'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('patient_id') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Amount -->
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label>Amount</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <input class="form-control {{ $errors->has('credit') ? 'is-invalid' : '' }}" name="credit" type="number" value="{{ old('credit') }}" >
                                    @if($errors->has('credit'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('credit') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label>Description</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" rows="3" >{{ old('description') }}</textarea>
                                    @if($errors->has('description'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('description') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-main-primary pd-x-30 mg-r-5 mg-t-5">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Form -->
@endsection

@section('js')
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('dashboard/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('/plugins/notify/js/notifit-custom.js') }}"></script>
    <script src="{{ URL::asset('Dashboard/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <script src="{{ URL::asset('Dashboard/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <script src="{{ URL::asset('Dashboard/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <script src="{{ URL::asset('Dashboard/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('Dashboard/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ URL::asset('Dashboard/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <script src="{{ URL::asset('Dashboard/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <script src="{{ URL::asset('Dashboard/js/form-elements.js') }}"></script>
@endsection
