<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}"/>
		<title>Laravel</title>

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

			<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- Scripts -->
		<!--script src="{{ asset('js/app.js') }}" defer></script-->

		<!-- Fonts -->
		<link rel="dns-prefetch" href="//fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

		<!-- Styles -->
		<link rel="stylesheet" href="{{asset('vendor/bootstrap/css/animate.css')}}">
		<link rel="stylesheet" href="{{asset('vendor/bootstrap/css/animation.css')}}">
		<link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
			<link rel="stylesheet" href="{{asset('vendor/lightbox/css/lightbox.css')}}">
		<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
		<!-- Styles -->

		<script src="{{asset('vendor/jquery/jquery-3.5.1.min.js')}}"></script>
		<script src="{{asset('vendor/notify/notify-custom.js')}}"></script>
		<style>
			html, body {
				background-color: #fff;
				color: #636b6f;
				font-family: 'Nunito', sans-serif;
				font-weight: 200;
				height: 100vh;
				margin: 0;
			}

			.full-height {
				height: 100vh;
			}

			.flex-center {
				align-items: center;
				display: flex;
				justify-content: center;
			}

			.position-ref {
				position: relative;
			}

			.top-right {
				position: absolute;
				right: 10px;
				top: 18px;
			}

			.content {
				text-align: center;
			}

			.title {
				font-size: 84px;
			}

			.links > a {
				color: #636b6f;
				padding: 0 25px;
				font-size: 13px;
				font-weight: 600;
				letter-spacing: .1rem;
				text-decoration: none;
				text-transform: uppercase;
			}

			.m-b-md {
				margin-bottom: 30px;
			}
		</style>
	</head>
	<body>
		@include('navbar')
		<div class="flex-center position-ref full-height mt-5">
			<div class="content">
				<div class="title m-b-md">
					Laravel
				</div>

				<div class="links">
					<a href="https://laravel.com/docs">Docs</a>
					<a href="https://laracasts.com">Laracasts</a>
					<a href="https://laravel-news.com">News</a>
					<a href="https://blog.laravel.com">Blog</a>
					<a href="https://nova.laravel.com">Nova</a>
					<a href="https://forge.laravel.com">Forge</a>
					<a href="https://vapor.laravel.com">Vapor</a>
					<a href="https://github.com/laravel/laravel">GitHub</a>
				</div>
			</div>
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
