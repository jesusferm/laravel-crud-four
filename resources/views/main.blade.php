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
		<div class="container" style="margin-top: 5rem;">
			<div class="row mt-5">
				<div class="col-md-3">
					<ul class="list-group mb-3">
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0"><a href="https://blog.linuxitos.com/iniciando-con-xampp-laravel-7-fedora-32">Laravel parte 1</a></h6>
								<a href="https://blog.linuxitos.com/" target="_blank">
									<small class="text-muted">Linuxitos</small>
								</a>
							</div>
						</li>
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0"><a href="https://blog.linuxitos.com/parte-2-laravel-7-xampp-fedora-32">Laravel parte 2</a></h6>
								<a href="https://blog.linuxitos.com/" target="_blank">
									<small class="text-muted">Linuxitos</small>
								</a>
							</div>
						</li>
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0"><a href="https://blog.linuxitos.com/parte-3-laravel-7-xampp-fedora-32">Laravel parte 3</a></h6>
								<a href="https://blog.linuxitos.com/" target="_blank">
									<small class="text-muted">Linuxitos</small>
								</a>
							</div>
						</li>
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0"><a href="https://blog.linuxitos.com/parte-4-laravel-7-xampp-fedora-32">Laravel parte 4</a></h6>
								<a href="https://blog.linuxitos.com/" target="_blank">
									<small class="text-muted">Linuxitos</small>
								</a>
							</div>
						</li>
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0"><a href="https://blog.linuxitos.com/">Linuxitos</a></h6>
								<a href="https://blog.linuxitos.com/" target="_blank">
									<small class="text-muted">Linuxitos</small>
								</a>
							</div>
						</li>
					</ul>
				</div>
				<div class="col-md-9">
					<div class="row">
						@if(!empty($data) && $data->count())
							@foreach($data as $key => $value)
								<div class="col-lg-3 col-md-3 col-sm-6 col-12 mb-3 d-flex">
									<div id="post-{{ $value->id }}" class="post post-{{ $value->id }} border-bottom-2" style="width:100%;">
										<a href="{{ route('home.view', $value->slug) }}" title="{{ ucfirst($value->title) }}">
											<div class="post-image">
												<img src="{{($value->image!=''?asset($value->files.$value->image): asset('images/default.svg'))}}" class="img-fluid" alt="" sizes="(max-width: 172px) 100vw, 172px">
											</div>
										</a>
										<div class="post-header">
											<a href="{{ route('home.view', $value->slug) }}" title="{{ $value->title }}">
												{{ ucfirst($value->title) }}
											</a>
											<p class="post-meta">
												<a href="{{ route('home.view', $value->slug) }}">May 15, 2020</a> — <a href="{{ route('home.view', $value->slug) }}/#comments">7 Comments</a>
											</p>
										</div>
									</div>
								</div>
							@endforeach
						@else
							<div class="col-md-12">
								<div class="alert alert-danger" role="alert">
									<i class="fa fa-exclamaiton-circle"></i> Sin resultados.
								</div>
							</div>
						@endif
						<div class="col-md-12 text-center">
							{!! $data->links() !!}
						</div>
					</div>
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
