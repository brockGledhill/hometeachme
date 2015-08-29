<!doctype html>
<html>
	<head>
		@section('head')
			@include('includes.pre_login.head')
		@show
	</head>

	<body id="{{ $bodyId or '' }}">
		@yield('content')
	</body>
</html>