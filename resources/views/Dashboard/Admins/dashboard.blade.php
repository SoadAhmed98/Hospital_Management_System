@extends('Dashboard.layouts.master')

@section('css')
<!-- Owl-carousel css-->
<link href="{{URL::asset('Dashboard/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
<!-- Maps css -->
<link href="{{URL::asset('Dashboard/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="left-content">
						<div>
						<br>
						<h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Hi, welcome {{auth()->user()->name}}</h2>
						<p class="mg-b-0">HMS monitoring dashboard</p>
						</div>
					</div>
					<div class="main-dashboard-header-right">
						<div>
							<label class="tx-13">Number of Individual Services</label>
							<h5>{{\App\Models\Service::count()}}</h5>
						</div>
						<div>
							<label class="tx-13">Number of Group Services</label>
							<h5>{{\App\Models\Group::count()}}</h5>
						</div>
					</div>
				</div>
				<!-- /breadcrumb -->
@endsection

@section('content')
<!-- row -->
<div class="row row-sm">
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-primary-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">Number of Invoices Today</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                {{ App\Models\Invoice::whereDate('created_at', Carbon\Carbon::today())->count() }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <span id="compositeline" class="pt-1"></span>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-danger-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">Total Earnings Today</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                ${{ App\Models\Invoice::whereDate('created_at', Carbon\Carbon::today())->sum('total_with_tax') }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <span id="compositeline2" class="pt-1"></span>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-success-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">Total Earnings</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                ${{ App\Models\Invoice::sum('total_with_tax') }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <span id="compositeline3" class="pt-1"></span>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-warning-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white">Number of Patients with Invoices</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                {{ App\Models\Invoice::distinct('patient_id')->count('patient_id') }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <span id="compositeline4" class="pt-1"></span>
        </div>
    </div>
</div>
<!-- row closed -->


   
<!-- row closed -->

<!-- New row for Recent Patients -->
<div class="row row-sm">
    <div class="col-xl-4 col-md-12 col-lg-12">
        <!-- Recent Patients Card -->
        <div class="card">
            <div class="card-header pb-1">
                <h3 class="card-title mb-2">Recent Patients</h3>
                <p class="tx-12 mb-0 text-muted">A patient is an individual who seeks medical care or treatment.</p>
            </div>
            <div class="card-body p-0 customers mt-1">
                <div class="list-group list-lg-group list-group-flush">
                    @foreach(App\Models\Patient::recentPatients(5) as $patient)
                    @php
                        $latestAccount = $patient->patientAccount->first();
                        $statusClass = ($latestAccount && $latestAccount->debit < $latestAccount->credit) ? 'text-success' : 'text-danger';
                        $statusLabel = ($latestAccount && $latestAccount->debit < $latestAccount->credit) ? 'Paid' : 'Pending';
                    @endphp
                    <div class="list-group-item list-group-item-action" href="#">
                        <div class="media mt-0">
                            <img class="avatar-lg rounded-circle ml-3 my-auto" src="{{ URL::asset('Dashboard/img/faces/placeholder.jpg') }}" alt="Image description">
                            <div class="media-body">
                                <div class="d-flex align-items-center">
                                    <div class="mt-0">
                                        <h5 class="mb-1 tx-15">{{ $patient->name }}</h5>
                                        <p class="mb-0 tx-13 text-muted">Patient ID: #{{ $patient->id }} <span class="{{ $statusClass }} ml-2">{{ $statusLabel }}</span></p>
                                    </div>
                                    <span class="mr-auto wd-45p fs-16 mt-2">
                                        <!-- Include your line strip view here -->
                                        <div id="spark{{ $loop->index + 1 }}" class="wd-100p"></div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-12 col-lg-6">
        <!-- Total Numbers Card -->
        <div class="card">
            <div class="card-header pb-1">
                <h3 class="card-title mb-2">Total Numbers</h3>
                <p class="tx-12 mb-0 text-muted">Here are some key metrics:</p>
				<br>
            </div>
            <div class="product-timeline card-body pt-2 mt-1">
                <ul class="timeline-1 mb-0">
                    <li class="mt-0">
                        <i class="ti-user bg-primary-gradient text-white product-icon"></i>
                        <span class="font-weight-semibold mb-4 tx-14">Number of Doctors</span>
                        <a href="#" class="float-left tx-11 text-muted">Last update</a>
                        <p class="mb-0 text-muted tx-12">{{ \App\Models\Doctor::count() }}</p>
                    </li>
                    <li class="mt-0">
                        <i class="ti-wheelchair bg-danger-gradient text-white product-icon"></i>
                        <span class="font-weight-semibold mb-4 tx-14">Number of Patients</span>
                        <a href="#" class="float-left tx-11 text-muted">Last update</a>
                        <p class="mb-0 text-muted tx-12">{{ \App\Models\Patient::count() }}</p>
                    </li>
                    <li class="mt-0">
                        <i class="ti-folder bg-success-gradient text-white product-icon"></i>
                        <span class="font-weight-semibold mb-4 tx-14">Number of Departments</span>
                        <a href="#" class="float-left tx-11 text-muted">Last update</a>
                        <p class="mb-0 text-muted tx-12">{{ \App\Models\Department::count() }}</p>
                    </li>
                    <li class="mt-0">
                        <i class="ti-book bg-warning-gradient text-white product-icon"></i>
                        <span class="font-weight-semibold mb-4 tx-14">Number of Diagnoses</span>
                        <a href="#" class="float-left tx-11 text-muted">Last update</a>
                        <p class="mb-0 text-muted tx-12">{{ \App\Models\PatientHistory::count() }}</p>
                    </li>
                    <li class="mt-0">
                        <i class="ti-file bg-purple-gradient text-white product-icon"></i>
                        <span class="font-weight-semibold mb-4 tx-14">Number of Laboratory Reports</span>
                        <a href="#" class="float-left tx-11 text-muted">Last update</a>
                        <p class="mb-0 text-muted tx-12">{{ \App\Models\Laboratorie::count() }}</p>
                    </li>
					<br>
                </ul>
            </div>
        </div>
    </div>

<!-- Recent Orders Section -->
    <!-- First set of cards -->
    <div class="col-xl-4 col-md-12 col-lg-6">
        <div class="card">
            <div class="card-header pb-0">
                <h3 class="card-title mb-2">Recent Orders</h3>
                <p class="tx-12 mb-0 text-muted">An order is an investor's instructions to a broker or brokerage firm to purchase or sell</p>
            </div>
            <div class="card-body sales-info ot-0 pt-0 pb-0">
                <div id="chart" class="ht-150"></div>
                <div class="row sales-infomation pb-0 mb-0 mx-auto wd-100p">
                    @php
                        $recentInvoiceCounts = App\Models\Invoice::getRecentInvoiceCount();
                    @endphp
                    <div class="col-md-6 col">
                        <p class="mb-0 d-flex"><span class="legend bg-primary brround"></span>Group</p>
                        <h3 class="mb-1">{{ $recentInvoiceCounts['group'] }}</h3>
                        <div class="d-flex">
                            <p class="text-muted">Last 6 months</p>
                        </div>
                    </div>
                    <div class="col-md-6 col">
                        <p class="mb-0 d-flex"><span class="legend bg-info brround"></span>Single</p>
                        <h3 class="mb-1">{{ $recentInvoiceCounts['single'] }}</h3>
                        <div class="d-flex">
                            <p class="text-muted">Last 6 months</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Second set of cards -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @php
                        $deferredCount = App\Models\Invoice::where('type', 2)->count();
                        $cashCount = App\Models\Invoice::where('type', 1)->count();
                    @endphp

                    <div class="col-md-6">
                        <div class="d-flex align-items-center pb-2">
                            <p class="mb-0">Deferred Invoices</p>
                        </div>
                        <h4 class="font-weight-bold mb-2">{{ $deferredCount }}</h4>
                        <div class="progress progress-style progress-sm">
                            <div class="progress-bar bg-primary-gradient wd-{{ ($deferredCount / ($deferredCount + $cashCount)) * 100 }}p" role="progressbar" aria-valuenow="{{ ($deferredCount / ($deferredCount + $cashCount)) * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-4 mt-md-0">
                        <div class="d-flex align-items-center pb-2">
                            <p class="mb-0">Cash Invoices</p>
                        </div>
                        <h4 class="font-weight-bold mb-2">{{ $cashCount }}</h4>
                        <div class="progress progress-style progress-sm">
                            <div class="progress-bar bg-danger-gradient wd-{{ ($cashCount / ($deferredCount + $cashCount)) * 100 }}p" role="progressbar" aria-valuenow="{{ ($cashCount / ($deferredCount + $cashCount)) * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- row opened -->
<div class="row row-sm">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="card">
            <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mb-0">Invoice Status</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <p class="tx-12 text-muted mb-0">Overview of Invoice Status</p>
            </div>
            <div class="card-body">
                <div class="total-revenue">
                    <div>
                        <h4>{{ App\Models\Invoice::where('invoice_status', 3)->count() }}</h4>
                        <label><span class="bg-primary"></span>Completed</label>
                    </div>
                    <div>
                        <h4>{{ App\Models\Invoice::where('invoice_status', 1)->count() }}</h4>
                        <label><span class="bg-danger"></span>In Progress</label>
                    </div>
                    <div>
                        <h4>{{ App\Models\Invoice::where('invoice_status', 2)->count() }}</h4>
                        <label><span class="bg-warning"></span>Review</label>
                    </div>
                </div>
                <div id="bar" class="sales-bar mt-4"></div>
            </div>
        </div>
    </div>



@endsection

@section('js')
<!-- Chart.js and ApexCharts scripts -->
<script src="{{ URL::asset('Dashboard/plugins/chart.js/Chart.bundle.min.js') }}"></script>
<script src="{{ URL::asset('Dashboard/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ URL::asset('Dashboard/plugins/morris.js/morris.min.js') }}"></script>
<script src="{{ URL::asset('Dashboard/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ URL::asset('Dashboard/plugins/peity/jquery.peity.min.js') }}"></script>
<script src="{{ URL::asset('Dashboard/plugins/apexcharts/apexcharts.js') }}"></script>
<script src="{{ URL::asset('Dashboard/plugins/apexcharts/irregular-data-series.js') }}"></script>
<script src="{{ URL::asset('Dashboard/js/apexcharts.js') }}"></script>
<!-- Internal Map -->
<script src="{{ URL::asset('Dashboard/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ URL::asset('Dashboard/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ URL::asset('Dashboard/js/modal-popup.js') }}"></script>
<script src="{{ URL::asset('Dashboard/js/jquery.vmap.sampledata.js') }}"></script>
<script src="{{ URL::asset('Dashboard/js/apexcharts.js') }}"></script>
<script src="{{ URL::asset('Dashboard/js/index.js') }}"></script>
@endsection

