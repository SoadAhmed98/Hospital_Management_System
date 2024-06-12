@extends('Dashboard.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('Dashboard/plugins/sumoselect/sumoselect-rtl.css') }}">
    <link href="{{URL::asset('Dashboard/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
    <style>
        .SumoSelect>.optWrapper>.options li label {
           margin-left: 30px;
        }
        .SumoSelect>.CaptionCont>span{
            margin-left: 20px;
        }
    </style>
@endsection

@section('title')
    {{trans('doctors.add_doctor')}}
@stop

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{trans('main-sidebar_trans.doctors')}}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{trans('doctors.add_doctor')}}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-22">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('Doctors.store') }}" method="post" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="pd-30 pd-sm-40 bg-gray-200">
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <label>{{trans('doctors.name')}}</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <input class="form-control" name="name" autofocus type="text" required>
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <label>{{trans('doctors.email')}}</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <input class="form-control" name="email" type="email" required>
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <label>{{trans('doctors.password')}}</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <input class="form-control" name="password" type="password" required>
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <label>{{trans('doctors.phone')}}</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <input class="form-control" name="phone" type="tel" required>
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <label>{{trans('doctors.departments')}}</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <select name="department_id" class="form-control SlectBox" required>
                                        <option value="" selected disabled>------</option>
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}">{{$department->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <label>{{trans('doctors.fees')}}</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <input class="form-control" name="fees" value="0.00" type="text" required>
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <label>{{trans('Doctors.doctor_photo')}}</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <input type="file" accept="image/*" name="photo" onchange="loadFile(event)">
                                    <img style="border-radius:50%" width="150px" height="150px" id="output"/>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-main-primary pd-x-30 mg-r-5 mg-t-5">{{trans('Doctors.submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('Dashboard/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <script>
        $('.testselect2').SumoSelect({ csvDispCount: 3, search: true, searchText: 'Search...' });
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
@endsection
