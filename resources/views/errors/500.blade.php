@extends('Dashboard/layouts.master2')
@section('css')
<!--- Internal Fontawesome css-->
<link href="{{URL::asset('Dashboard/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<!---Ionicons css-->
<link href="{{URL::asset('Dashboard/plugins/ionicons/css/ionicons.min.css')}}" rel="stylesheet">
<!---Internal Typicons css-->
<link href="{{URL::asset('Dashboard/plugins/typicons.font/typicons.css')}}" rel="stylesheet">
<!---Internal Feather css-->
<link href="{{URL::asset('Dashboard/plugins/feather/feather.css')}}" rel="stylesheet">
<!---Internal Falg-icons css-->
<link href="{{URL::asset('Dashboard/plugins/flag-icon-css/css/flag-icon.min.css')}}" rel="stylesheet">
@endsection
@section('content')
		<!-- Main-error-wrapper -->
		<div class="main-error-wrapper  page page-h ">
			<img src="{{URL::asset('Dashboard/img/media/500.png')}}" class="error-page" alt="error">
			<h2>Oopps. Something went Wrong and We're Already Working On It</h2>
			<h6>Try Again Soon Or Contact Our Team If You Need Immediate Help</h6><a class="btn btn-outline-danger" href="{{ route('/') }}">Back to Home</a>
		</div>
		<!-- /Main-error-wrapper -->
@endsection
@section('js')
@endsection