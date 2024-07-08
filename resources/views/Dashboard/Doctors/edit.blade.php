@extends('Dashboard.layouts.master')
@section('css')
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('Dashboard/plugins/sumoselect/sumoselect-rtl.css') }}">
    <link href="{{URL::asset('dashboard/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>

    <!-- Internal Select2 css -->
    <link href="{{URL::asset('Dashboard/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{URL::asset('Dashboard/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}"
          rel="stylesheet">
    <link href="{{URL::asset('Dashboard/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}"
          rel="stylesheet">
    <link href="{{URL::asset('Dashboard/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{URL::asset('Dashboard/plugins/spectrum-colorpicker/spectrum.css')}}" rel="stylesheet">
      
    <style>
        .SumoSelect>.optWrapper>.options li label {
           margin-left: 30px;
        }
        .SumoSelect>.CaptionCont>span{
            margin-left: 20px;
        }
    </style>
@section('title')
    Edit doctor
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> {{trans('main-sidebar_trans.doctors')}}</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/
               {{trans('doctors.add_doctor')}}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    {{-- @include('Dashboard.messages_alert') --}}

    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('Doctors.update', $doctor->id) }}" method="post" autocomplete="off"
                          enctype="multipart/form-data">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <div class="pd-30 pd-sm-40 bg-gray-200">
                            <div>
                                @if($doctor->image)
                                    <img style="border-radius:20%"
                                         src="{{Url::asset('Dashboard/img/doctors/'.$doctor->image->filename)}}"
                                         height="150px" width="150px" alt="">
                                @else
                                    <img style="border-radius:50%"
                                         src="{{Url::asset('Dashboard/img/doctor_default.png')}}"
                                         height="50px"
                                         width="50px" alt="">
                                @endif
                            </div>
                            <br><br>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label for="exampleInputEmail1">
                                        {{trans('doctors.name')}}</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $doctor->name) }}" type="text">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                   @enderror
                                </div>
                               
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label for="exampleInputEmail1">
                                        {{trans('doctors.email')}}</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <input class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $doctor->email) }}" name="email" type="email">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                   @enderror
                                </div>
                              
                            </div>


                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label for="exampleInputEmail1">
                                        {{ trans('doctors.phone') }}</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <input class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $doctor->phone) }}" name="phone" type="tel">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <input class="form-control" value="{{$doctor->id}}" name="id" type="hidden">
                                </div>
                               
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label for="exampleInputEmail1">
                                        Fees</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <input class="form-control @error('fee') is-invalid @enderror" value="{{ old('consultation_fees', $doctor->consultation_fees) }}" name="fees" type="text">
                                </div>
                                @error('fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                               @enderror
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label for="exampleInputEmail1">
                                        Departments</label>
                                </div>

                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <select name="department_id" class="form-control SlectBox @error('department_id') is-invalid @enderror">
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}"
                                                    {{ $department->id == old('department_id', $doctor->department_id) ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>

                            <div class=" row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label for="exampleInputEmail1">
                                        Work Schedule</label>
                                </div>

                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <select multiple="multiple" class="testselect2 @error('workschedule') is-invalid @enderror" name="workschedule[]">
                                        @foreach($workschedule as $workday)
                                            @php $isSelected = in_array($workday->id, old('workschedule', $doctor->doctorworkschedule->pluck('id')->toArray()) ?? []); @endphp
                                            <option value="{{$workday->id}}" {{ $isSelected ? 'selected' : '' }}>
                                                {{$workday->day}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('workschedule')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <!-- New Fields -->
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label>Expertise</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <input class="form-control @error('expertise') is-invalid @enderror" name="expertise" value="{{ old('expertise', $doctor->expertise) }}" type="text">
                                    @error('expertise')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label>Education</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <textarea class="form-control @error('education') is-invalid @enderror" name="education">{{ old('education', $doctor->education) }}</textarea>
                                    @error('education')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label>Experience</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <textarea class="form-control @error('experience') is-invalid @enderror" name="experience">{{ old('experience', $doctor->experience) }}</textarea>
                                    @error('experience')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label>Profession</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <input class="form-control @error('profession') is-invalid @enderror" name="profession" value="{{ old('profession', $doctor->profession) }}" type="text">
                                    @error('profession')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- End New Fields -->
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label for="exampleInputEmail1">
                                        {{ trans('Doctors.doctor_photo') }}</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <input type="file" accept="image/*" name="photo" onchange="loadFile(event)">
                                    <img style="border-radius:50%" width="150px" height="150px" id="output"/>
                                </div>
                            </div>


                            <button type="submit"
                                    class="btn btn-main-primary pd-x-30 mg-r-5 mg-t-5">{{ trans('Doctors.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')

    <script>
        var loadFile = function (event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>

    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('Dashboard/js/select2.js') }}"></script>
    <script src="{{ URL::asset('Dashboard/js/advanced-form-elements.js') }}"></script>

    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('Dashboard/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('dashboard/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>


    <!--Internal  Datepicker js -->
    <script src="{{URL::asset('dashboard/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{URL::asset('dashboard/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{URL::asset('dashboard/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{URL::asset('dashboard/plugins/select2/js/select2.min.js')}}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{URL::asset('dashboard/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{URL::asset('dashboard/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
    <!-- Ionicons js -->
    <script src="{{URL::asset('dashboard/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{URL::asset('dashboard/plugins/pickerjs/picker.min.js')}}"></script>
    <!-- Internal form-elements js -->
    <script src="{{URL::asset('dashboard/js/form-elements.js')}}"></script>


@endsection
