@extends('layouts.app')
@section('content')
@section('title', 'Registros')
<script>
	var base_url = "{{url('/')}}";
</script>

@include('posts.modals')

<div class="container">
	<div class="row">
		<div class="col-md-12">
			@if (session('success'))
				<script type="text/javascript">
					$(document).ready(function() {
						notify_msg("fa fa-check", " ", "{{session('success')}}", "#", "success");
					});
				</script>
			@endif
			@if (session('danger'))
				<script type="text/javascript">
					$(document).ready(function() {
						notify_msg("fa fa-times", " ", "{{session('danger')}}", "#", "danger");
					});
				</script>
			@endif
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="{{url('/')}}"><i class="fa fa-home"></i> Inicio</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">
						 Registros
					</li>
				</ol>
			</nav>
		</div>
	</div>

	<div class="row justify-content-center mt-3">
		<div class="col-md-6">
			<h2>Lista de Posts</h2>
		</div>
		<div class="col-md-6">
			<!--div class="float-right">
				<a href="{{route('posts.create')}}" class="btn btn-primary">
					<i class="fa fa-plus-circle"></i> Agregar
				</a>
			</div-->
		</div>
	</div>

	<div class="form-row mt-2 mb-1">
		<div class="col-lg-1 col-md-2 col-sm-2 col-2">
			<div class="dropdown-limit input-group">
				<button type="button" class="btn btn-primary dropdown-toggle btn-block" data-toggle="dropdown">
					<span class="d-none d-md-inline-block fa fa-list-ol"></span> <span id="spn-show-list">10</span>
				</button>
				<div id="select-list" class="dropdown-menu">
					<a class="dropdown-item" href="#" data-total="10">10</a>
					<a class="dropdown-item" href="#" data-total="20">20</a>
					<a class="dropdown-item" href="#" data-total="30">30</a>
					<a class="dropdown-item" href="#" data-total="40">40</a>
					<a class="dropdown-item" href="#" data-total="50">50</a>
				</div>
			</div>
		</div>						

		<div class="col-lg-9 col-md-8 col-sm-8 col-8">
			<form method="post" enctype="multipart/form-data" accept-charset="utf-8" id="form-search" name="form-search">
				<div class="input-group">
					<div class="dropdown-edo input-group-prepend">
						<button id="btn-search-on" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
							<i id="i-icon-act" class="fas fa-check"></i> <span id="spn-desc-act" class="d-none d-md-inline-block">Activos</span>
						</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="#" data-desc="Todos" data-icon="fas fa-list-ol" data-edo="3">
								<i class="fas fa-list-ol"></i> Todos
							</a>
							<a class="dropdown-item" href="#" data-desc="Activos" data-icon="fas fa-check" data-edo="2">
								<i class="fas fa-check"></i> Activos
							</a>
							<a class="dropdown-item" href="#" data-desc="Inactivos" data-icon="fas fa-times" data-edo="1">
								<i class="fas fa-times"></i> Inactivos
							</a>
						</div>
					</div>
					<input type="text" class="form-control txt-search-nv" name="txt-search" id="txt-search" placeholder="Buscar...">
					<div class="input-group-append">
						<button type="submit" class="btn btn-search-nav" name="btn-search" id="btn-search">
							<i class="fal fa-search"></i>
						</button>
					</div>
				</div>
			</form>
		</div>
		<div class="colg-lg-1 col-md-2 col-sm-2 col-2">
			<button class="btn btn-block btn-success btn-open-mdl" title="Agregar" data-toggle="modal" data-target="#mdl-add-reg">
				<svg class="bi bi-plus-circle" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"/>
					<path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"/>
					<path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
				</svg> <span class="d-none d-md-inline">Agregar</span>
			</button>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 text-right">
			<h5 id="h5-cnt-total"></h5>
		</div>
	</div>
	<div class="row">
		<div id="div-cnt-load" class="col-md-12"></div>
	</div>
</div>
<script src="{{asset('js/ajxtodoapp.js')}}" defer></script>
<script type="text/javascript">
	$(document).ready(function() {
		load(1);
	});
</script>

@endsection