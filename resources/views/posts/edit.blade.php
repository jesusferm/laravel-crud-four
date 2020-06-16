@extends('layouts.app')
@section('content')
@section('title', 'Editar')
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
						<span><svg class="bi bi-check2-square" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M15.354 2.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L8 9.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
							<path fill-rule="evenodd" d="M1.5 13A1.5 1.5 0 0 0 3 14.5h10a1.5 1.5 0 0 0 1.5-1.5V8a.5.5 0 0 0-1 0v5a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V3a.5.5 0 0 1 .5-.5h8a.5.5 0 0 0 0-1H3A1.5 1.5 0 0 0 1.5 3v10z"/>
						</svg> Edición </span>
					</li>
				</ol>
			</nav>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-md-6">
			<h2>Editar Post</h2>
		</div>
		<div class="col-md-6">
			<!-- div class="float-right">
				<a href="{{route('posts.index')}}" class="btn btn-primary">
					<i class="fa fa-chevron-left"></i> Atrás
				</a>
			</div-->
		</div>
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
			<form action="{{route('posts.update', $todo->id)}}" method="POST" enctype="multipart/form-data" accept-charset="UTF-8">
			<!--form id="form-update" name="form-update" action="" method="POST"-->
				@csrf
				@method('PUT')
				<input type="hidden" class="form-control" id="id" name="id" value="{{$todo->id}}" readonly="">
				<div class="row">
					<div class="col-md-3">
						<div class="card border">
							<div class="box-img-evt">
								<a href="{{($todo->image!=''?asset($todo->files.$todo->image): asset('images/default.svg'))}}" data-lightbox="img-gallery-1" data-title="Imagen">
									<img class="img-fluid" src="{{($todo->image!=''?asset($todo->files.$todo->image): asset('images/default.svg'))}}" alt="Imagen de perfil"/>
								</a>
								<ul class="icon">
									<li>
										<a href="{{($todo->image!=''?asset($todo->files.$todo->image): asset('images/default.svg'))}}" class="btn btn-primary btn-sm" data-lightbox="img-gallery-2" data-title="Imagen">
											<svg class="bi bi-eye" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
												<path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z"/>
												<path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
											</svg>
										</a>
									</li>
								</ul>
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
						<div class="form-group input-group">
							<span class="has-float-label">
								<input type="text" class="form-control" id="title" name="title" value="{{$todo->title}}" required="">
								<label for="title">Título:</label>
							</span>
						</div>
						<div class="form-group input-group">
							<span class="has-float-label">
								<textarea name="desc" class="form-control" id="desc" rows="5" required="">{{ $todo->desc}}</textarea>
								<label for="desc">Descripción:</label>
							</span>
						</div>
						<div class="form-group input-group">
							<span class="has-float-label">
								<select class="form-control" id="status" name="status" required="">
									<option value="pendiente" @if ($todo->status == 'pendiente') selected="" @endif>Pendiente</option>
									<option value="publicado" @if ($todo->status == 'publicado') selected="" @endif>Publicado</option>
								</select>
								<label for="status">Estado:</label>
							</span>
						</div>
					</div>
				</div>
				<button id="btn-update" name="btn-update" type="submit" class="btn btn-primary float-right">
					<svg class="bi bi-check2" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
					</svg> Actualizar
				</button>
			</form>
		</div>
	</div>
</div>
<script src="{{asset('js/ajxtodoapp.js')}}" defer></script>
@endsection