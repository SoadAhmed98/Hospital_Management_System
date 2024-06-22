@extends('Dashboard.layouts.master')

@section('css')
    <link href="{{ URL::asset('dashboard/plugins/notify/css/notifIt.css') }}" rel="stylesheet"/>
@endsection

@section('page-header')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Patients</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Patients List</span>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->
@endsection

@section('content')
    @include('Dashboard.messages_alert')

    <!-- Row opened -->
    <div class="row row-sm">
        <!-- Column -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('Patients.create') }}" class="btn btn-primary">Add New Patient</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Patient Name</th>
                                    <th>Email</th>
                                    <th>Date of Birth</th>
                                    <th>Phone Number</th>
                                    <th>Gender</th>
                                    <th>Blood Group</th>
                                    <th>Address</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patients as $patient)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="{{ route('Patients.show', $patient->id) }}">{{ $patient->name }}</a></td>
                                        <td>{{ $patient->email }}</td>
                                        <td>{{ $patient->birth_date }}</td>
                                        <td>{{ $patient->phone }}</td>
                                        <td>{{ $patient->gender}}</td>
                                        <td>{{ $patient->blood_group }}</td>
                                        <td>{{ $patient->address }}</td>
                                        <td>
                                            <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"  data-toggle="modal" href="#edit{{ $patient->id }}"><i class="las la-pen"></i></a>
                                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#Deleted{{ $patient->id }}"><i class="fas fa-trash"></i></button>
                                            <a href="{{ route('Patients.show', $patient->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    @include('Dashboard.Patients.edit')
                                    @include('Dashboard.Patients.delete')
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Column -->
    </div>
    <!-- End Row -->
@endsection

@section('js')
    <!--Internal Notify js -->
    <script src="{{ URL::asset('dashboard/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
