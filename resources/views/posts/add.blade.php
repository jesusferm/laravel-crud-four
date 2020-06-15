@extends('layouts.app')
@section('content')
@section('title', 'Agregar')
<script>
	var base_url = "{{url('/')}}";
</script>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="{{url('/')}}"><svg class="bi bi-house-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M8 3.293l6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
							<path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
						</svg> Inicio</a>
					</li>
					<li class="breadcrumb-item">
						<a href="{{url('posts')}}">
							<svg class="bi bi-list-task" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5H2zM3 3H2v1h1V3z"/>
								<path d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9z"/>
								<path fill-rule="evenodd" d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5V7zM2 7h1v1H2V7zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5H2zm1 .5H2v1h1v-1z"/>
							</svg> Registros</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">
						 <span><svg class="bi bi-plus-circle" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"/>
							<path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"/>
							<path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
						</svg> Agregar </span>
					</li>
				</ol>
			</nav>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-md-6">
			<h2>Agregar</h2>
		</div>
		<div class="col-md-6">
			<div class="float-right">
				<a href="{{ route('posts.index') }}" class="btn btn-primary">
					<svg class="bi bi-chevron-left" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
					</svg> Atrás
				</a>
			</div>
		</div>
		<div class="col-md-12">
			@if (session('success'))
				<div class="alert alert-success" role="alert">
					{{ session('success') }}
				</div>
			@endif
			@if (session('error'))
				<div class="alert alert-error" role="alert">
					{{ session('error') }}
				</div>
			@endif

			<form id="form-add" name="form-add" action="" method="POST" enctype="multipart/form-data" accept-charset="UTF-8">
				@csrf
				<div class="row">
					<div class="col-md-3">
						<div class="card border">
							<div class="box-img-evt">
								<img class="img-fluid" src="{{asset('images/default.svg')}}" alt="Imagen de perfil"/>
							</div>
						</div>
						<div class="custom-file mt-2">
							<input type="file" class="custom-file-input" id="files-all" name="image[]" accept=".png, .jpg, .jpeg">
							<label class="custom-file-label" for="files-all" data-browse="Elegir">
								Seleccionar archivos...
							</label>
						</div>
					</div>
					<div class="col-md-9">
						<div class="form-row">
							<div class="col-md-12">
								<div class="form-group input-group">
									<span class="has-float-label">
										<input type="text" class="form-control" id="title" name="title" required="">
										<label for="title">Título:</label>
									</span>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group input-group mt-3">
									<span class="has-float-label">
										<textarea name="desc" class="form-control" id="desc" rows="4"></textarea>
										<label for="desc">Descripción:</label>
									</span>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group input-group">
									<span class="has-float-label">
										<select class="form-control" id="status" name="status" required="">
											<option value="pendiente">Pendiente</option>
											<option value="publicado">Publicado</option>
										</select>
										<label for="status">Estado:</label>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<button id="btn-add" name="btn-add" type="submit" class="btn btn-success float-right">
					<svg class="bi bi-check2" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
					</svg> Agregar
				</button>
			</form>
		</div>
	</div>
</div>
<script src="{{asset('js/ajxtodoapp.js')}}" defer></script>
@endsection