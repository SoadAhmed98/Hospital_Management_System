@extends('Dashboard.layouts.master-doctor')

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
        <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Hi, welcome {{auth()->user()->name}}</h2>
        <p class="mg-b-0">HMS Doctor monitoring dashboard</p>
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
                                {{ App\Models\Invoice::where('doctor_id', auth()->user()->id)
                                    ->whereDate('created_at', Carbon\Carbon::today())
                                    ->count() }}
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
                                ${{ App\Models\Invoice::where('doctor_id', auth()->user()->id)
                                    ->whereDate('created_at', Carbon\Carbon::today())
                                    ->sum('total_with_tax') }}
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
                                ${{ App\Models\Invoice::where('doctor_id', auth()->user()->id)->sum('total_with_tax') }}
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
                                {{ App\Models\Invoice::where('doctor_id', auth()->user()->id)->distinct('patient_id')->count('patient_id') }}
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

<!-- row opened -->
<div class="row row-sm">
    <div class="col-md-12 col-lg-12 col-xl-7">
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
                        <h4>{{ App\Models\Invoice::where('doctor_id', auth()->user()->id)->where('invoice_status', 3)->count() }}</h4>
                        <label><span class="bg-primary"></span>Completed</label>
                    </div>
                    <div>
                        <h4>{{ App\Models\Invoice::where('doctor_id', auth()->user()->id)->where('invoice_status', 1)->count() }}</h4>
                        <label><span class="bg-danger"></span>In Progress</label>
                    </div>
                    <div>
                        <h4>{{ App\Models\Invoice::where('doctor_id', auth()->user()->id)->where('invoice_status', 2)->count() }}</h4>
                        <label><span class="bg-warning"></span>Review</label>
                    </div>
                </div>
                <div id="bar" class="sales-bar mt-4"></div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Section -->
    <div class="row row-sm">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h3 class="card-title mb-2">Recent Orders</h3>
                    <p class="tx-12 mb-0 text-muted">An order is an investor's instructions to a broker or brokerage firm to purchase or sell</p>
                </div>
                <div class="card-body sales-info ot-0 pt-0 pb-0">
                    <div id="chart" class="ht-150"></div>
                    <div class="row sales-infomation pb-0 mb-0 mx-auto wd-100p">
                        @php
                            $recentInvoiceCounts = App\Models\Invoice::getRecentInvoiceCounts(auth()->user()->id);
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
        </div>
    </div>
</div>
<!-- row closed -->

<!-- row closed -->
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
