<!doctype html>
<html>
<head>
	@section('head')
		@include('includes.head')
	@show
</head>

<body>
	@section('header')
		@include('includes.header')
	@show
 
	<div id="mainbox">
		@if ($adminStatus)
			@include('includes.admin_menu')
		@endif
		@yield('content')
	</div>
</body>

