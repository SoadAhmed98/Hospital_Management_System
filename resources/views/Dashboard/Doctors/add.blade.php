
@extends('Dashboard.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('Dashboard/plugins/sumoselect/sumoselect-rtl.css') }}">
    <link href="{{ URL::asset('Dashboard/plugins/notify/css/notifIt.css') }}" rel="stylesheet"/>
    <style>
        .SumoSelect > .optWrapper > .options li label {
            margin-left: 30px;
        }
        .SumoSelect > .CaptionCont > span {
            margin-left: 20px;
        }
    </style>
@endsection

@section('title')
    {{ trans('doctors.add_doctor') }}
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('main-sidebar_trans.doctors') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{ trans('doctors.add_doctor') }}</span>
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
                                    <label>{{ trans('doctors.name') }}</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" type="text" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <label>{{ trans('doctors.email') }}</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" type="email" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <label>{{ trans('doctors.password') }}</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <input class="form-control @error('password') is-invalid @enderror" name="password" type="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <label>{{ trans('doctors.phone') }}</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <input class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" type="tel" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <label>{{ trans('doctors.departments') }}</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <select name="department_id" class="form-control SlectBox @error('department_id') is-invalid @enderror" required>
                                        <option value="" selected disabled>------</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                               
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <label>Work Schedule</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <select multiple="multiple" class="testselect2 form-control @error('workschedule') is-invalid @enderror" name="workschedule[]">
                                        @foreach($workschedule as $workday)
                                            <option value="{{ $workday->id }}" {{ in_array($workday->id, old('workschedule', [])) ? 'selected' : '' }}>{{ $workday->day }}</option>
                                        @endforeach
                                    </select>
                                    @error('workschedule')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>
                            </div>
                               <!-- New Fields -->
                               <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <label>Expertise</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <input class="form-control @error('expertise') is-invalid @enderror" name="expertise" value="{{ old('expertise') }}" type="text">
                                    @error('expertise')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <label>Education</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <textarea class="form-control @error('education') is-invalid @enderror" name="education">{{ old('education') }}</textarea>
                                    @error('education')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <label>Experience</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <textarea class="form-control @error('experience') is-invalid @enderror" name="experience">{{ old('experience') }}</textarea>
                                    @error('experience')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <label>Profession</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <input class="form-control @error('profession') is-invalid @enderror" name="profession" value="{{ old('profession') }}" type="text">
                                    @error('profession')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- End New Fields -->
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <label>{{ trans('doctors.fees') }}</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <input class="form-control @error('fees') is-invalid @enderror" name="fees" value="{{ old('fees', '0.00') }}" type="text" required>
                                    @error('fees')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <label>{{ trans('Doctors.doctor_photo') }}</label>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <input type="file" accept="image/*" name="photo" onchange="loadFile(event)">
                                    <img style="border-radius: 50%" width="150px" height="150px" id="output"/>
                                </div>
                            </div>
                         
                            <button type="submit" class="btn btn-main-primary pd-x-30 mg-r-5 mg-t-5">{{ trans('Doctors.submit') }}</button>
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
                URL.revokeObjectURL(output.src); // free memory
            };
        };
    </script>
@endsection
