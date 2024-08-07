@extends('Dashboard.layouts.master')
@section('css')

@endsection
@section('title')
    Patient Information
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Pages</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Empty</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="card" id="basic-alert">
                <div class="card-body">
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-1">
                                <div class="tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li class="nav-item"><a href="#tab1" class="nav-link active"
                                                                    data-toggle="tab">Patient Information</a></li>
                                            <li class="nav-item"><a href="#tab2" class="nav-link" data-toggle="tab">Invoices</a>
                                            </li>
                                            <li class="nav-item"><a href="#tab3" class="nav-link" data-toggle="tab">Payments</a>
                                            </li>
                                            <li class="nav-item"><a href="#tab4" class="nav-link" data-toggle="tab">Account Statement</a></li>
                                            <li class="nav-item"><a href="#tab5" class="nav-link" data-toggle="tab">History of Diagnosis</a>
                                            </li>
                                            <li class="nav-item"><a href="#tab6" class="nav-link" data-toggle="tab">Laboratory</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                                    <div class="tab-content">

                                        {{-- Start Show Information Patient --}}

                                        <div class="tab-pane active" id="tab1">
                                            <br>
                                            <div class="table-responsive">
                                                <table class="table table-hover text-md-nowrap text-center">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Patient Name</th>
                                                        <th>Phone Number</th>
                                                        <th>Email</th>
                                                        <th>Date of Birth</th>
                                                        <th>Gender</th>
                                                        <th>Blood Group</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>{{$Patient->name}}</td>
                                                        <td>{{$Patient->Phone}}</td>
                                                        <td>{{$Patient->email}}</td>
                                                        <td>{{$Patient->Date_Birth}}</td>
                                                        <td>{{$Patient->Gender == 1 ? 'Male' : 'Female'}}</td>
                                                        <td>{{$Patient->Blood_Group}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {{-- End Show Information Patient --}}



                                        {{-- Start Invoices Patient --}}

                                        <div class="tab-pane" id="tab2">

                                            <div class="table-responsive">
                                                <table class="table table-hover text-md-nowrap text-center">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Service Name</th>
                                                        <th>Invoice Date</th>
                                                        <th>Total with Tax</th>
                                                        <th>Invoice Type</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($invoices as $invoice)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$invoice->Service->name ?? $invoice->Group->name}}</td>
                                                            <td>{{$invoice->invoice_date}}</td>
                                                            <td>{{$invoice->total_with_tax}}</td>
                                                            <td>{{$invoice->type == 1 ? 'Cash' : 'Credit'}}</td>
                                                        </tr>
                                                        <br>
                                                    @endforeach
                                                    <tr>
                                                        <th colspan="4" scope="row" class="alert alert-success">
                                                            Total
                                                        </th>
                                                        <td class="alert alert-primary">{{ number_format($invoices->sum('total_with_tax'), 2)}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {{-- End Invoices Patient --}}



                                        {{-- Start Receipt Patient  --}}

                                        <div class="tab-pane" id="tab3">
                                            <div class="table-responsive">
                                                <table class="table table-hover text-md-nowrap text-center">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Date Added</th>
                                                        <th>Amount</th>
                                                        <th>Description</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($receipt_accounts as $receipt_account)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$receipt_account->date}}</td>
                                                            <td>{{$receipt_account->amount}}</td>
                                                            <td>{{$receipt_account->description}}</td>
                                                        </tr>
                                                        <br>
                                                    @endforeach
                                                    <tr>
                                                        <th scope="row" class="alert alert-success">Total
                                                        </th>
                                                        <td colspan="4"
                                                            class="alert alert-primary">{{ number_format($receipt_accounts->sum('amount'), 2)}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {{-- End Receipt Patient  --}}


                                        {{-- Start Payment Accounts Patient --}}
                                        <div class="tab-pane" id="tab4">
                                            <div class="table-responsive">
                                                <table class="table table-hover text-md-nowrap text-center" id="example1">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Date Added</th>
                                                        <th>Description</th>
                                                        <th>Debit</th>
                                                        <th>Credit</th>
                                                        <th>Final Balance</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($Patient_accounts as $Patient_account)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$Patient_account->date}}</td>
                                                            <td>
                                                                @if($Patient_account->invoice_id == true)
                                                                    {{$Patient_account->invoice->Service->name ?? $Patient_account->invoice->Group->name }}
                                                                @elseif($Patient_account->receipt_id == true)
                                                                    {{$Patient_account->ReceiptAccount->description}}

                                                                @elseif($Patient_account->Payment_id == true)
                                                                    {{$Patient_account->PaymentAccount->description}}
                                                                @endif

                                                            </td>
                                                            <td>{{ $Patient_account->Debit}}</td>
                                                            <td>{{ $Patient_account->credit}}</td>
                                                            <td></td>
                                                        </tr>
                                                        <br>
                                                    @endforeach
                                                    <tr>
                                                        <th colspan="3" scope="row" class="alert alert-success">
                                                            Total
                                                        </th>
                                                        <td class="alert alert-primary">{{ number_format($Debit = $Patient_accounts->sum('Debit'), 2) }}</td>
                                                        <td class="alert alert-primary">{{ number_format($credit = $Patient_accounts->sum('credit'), 2) }}</td>
                                                        <td class="alert alert-danger">
                                                            @php
                                                                $balance = $Debit - $credit;
                                                            @endphp
                                                            <span class="text-danger">
                                                                {{ number_format($balance, 2) }}
                                                                {{ abs($balance) < 0.01 ? 'Credit' : ($balance > 0 ? 'Debit' : 'Credit') }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </div>

                                            <br>

                                        </div>

                                        {{-- End Payment Accounts Patient --}}


                                        <div class="tab-pane" id="tab5">
                                        <br>
                                            <div class="vtimeline">
                                                @foreach($patient_records as $patient_record)
                                                    <div class="timeline-wrapper {{ $loop->iteration % 2 == 0 ? 'timeline-inverted' : '' }} timeline-wrapper-primary">
                                                        <div class="timeline-badge"><i class="las la-check-circle"></i></div>
                                                        <div class="timeline-panel">
                                                            <div class="timeline-heading">
                                                                <h6 class="timeline-title">Art Ramadani posted a status update</h6>
                                                            </div>
                                                            <div class="timeline-body">
                                                                <p>{{$patient_record->diagnosis}}</p>
                                                            </div>
                                                            <div class="timeline-footer d-flex align-items-center flex-wrap">
                                                                <i class="fas fa-user-md"></i>&nbsp;
                                                                <span>{{$patient_record->Doctor->name}}</span>
                                                                <span class="mr-auto"><i class="fe fe-calendar text-muted mr-1"></i>{{$patient_record->date}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab6">
                                        
                                                <!-- breadcrumb -->
                                                <div class="breadcrumb-header justify-content-between">
                                                    <div class="my-auto">
                                                        <div class="d-flex">
                                                            <h4 class="content-title mb-0 my-auto">Lab Reports</h4>
                                                            <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                                                                / {{ optional($patient_Laboratories->first())->Patient->name ?? 'No Patient' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- breadcrumb -->
                                                @if($patient_Laboratories->isEmpty())
                                                    <div class="alert alert-info" role="alert">
                                                        No lab tests have been performed for this patient.
                                                    </div>
                                                @else
                                                    @foreach($patient_Laboratories as $laboratory)
                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1">Lab Technician Notes</label>
                                                            <textarea readonly class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $laboratory->description_employee }}</textarea>
                                                        </div>
                                                        <br><br>
                                                        <!-- Gallery -->
                                                        <div class="demo-gallery">
                                                            <ul id="lightgallery" class="list-unstyled row row-sm pr-0">
                                                                @foreach($laboratory->images as $image)
                                                                    <li class="col-sm-6 col-lg-4" data-responsive="{{ URL::asset('Dashboard/img/laboratories/'.$image->filename) }}" data-src="{{ URL::asset('Dashboard/img/Rays/'.$image->filename) }}">
                                                                        <a href="#">
                                                                            <img width="50px" height="350px" class="img-responsive" src="{{ URL::asset('Dashboard/img/laboratories/'.$image->filename) }}" alt="No Image">
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <!-- /Gallery -->
                                                    @endforeach
                                                @endif

                                                <!-- row closed -->
                                                </div>
                                                <!-- Container closed -->
                                                </div>
                                                <!-- main-content closed -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Prism Precode -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
@endsection
@section('js')
@endsection
