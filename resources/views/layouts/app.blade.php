<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}"/>
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Scripts -->
	<!--script src="{{ asset('js/app.js') }}" defer></script-->

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

	<!-- Styles -->
	<!-- CSS only -->
	<link rel="stylesheet" href="{{asset('vendor/bootstrap/css/animate.css')}}">
	<link rel="stylesheet" href="{{asset('vendor/bootstrap/css/animation.css')}}">
	<link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('vendor/lightbox/css/lightbox.css')}}">
	<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
	

	<script src="{{asset('vendor/jquery/jquery-3.5.1.min.js')}}"></script>
	<script src="{{asset('vendor/notify/notify-custom.js')}}"></script>

</head>
<body>
	<div id="app">
		@include('navbar')
		<main class="py-4 mt-5">
			@yield('content')
		</main>
	</div>

	<script>
		window.jQuery || document.write('<script src="{{asset("vendor/jquery/jquery-3.5.1.js")}}"><\/script>')
	</script>
	<!-- JS, Popper.js, and jQuery -->
	<script src="{{asset('vendor/jquery/jquery-3.5.1.min.js')}}"></script>
	<script src="{{asset('vendor/jquery/popper.min.js')}}"></script>
	<script src="{{asset('vendor/jquery/bs-custom-file-input.js')}}"></script>
	<script>
		bsCustomFileInput.init();
	</script>
	<script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('vendor/notify/bootstrap-notify.min.js')}}"></script>
	<!-- Page level plugin lightbox.js-->
	<script src="{{asset('vendor/lightbox/js/lightbox.js')}}"></script>
	<script type="text/javascript">
		// Javascript to enable link to tab
		var url = document.location.toString();
		if (url.match('#')) {
			$('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
		} 
		// Change hash for page-reload
		$('.nav-tabs a').on('shown.bs.tab', function (e) {
			window.location.hash = e.target.hash;
		});
	</script>
</body>
</html>
