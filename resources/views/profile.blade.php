@extends('layouts.app')
@section('content')
@section('title', 'Perfil')
<script>
	var base_url = "{{url('/')}}";
</script>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="{{url('/')}}"><i class="fa fa-home"></i> Inicio</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Perfil de usuario</li>
				</ol>
			</nav>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-md-12">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
						<i class="fa fa-info-circle"></i> Perfil
					</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
						<i class="fa fa-lock"></i> Seguridad
					</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
					<div class="row mt-3">
						<div class="col-md-3">
							<div class="row">
								<div id="div-img" class="col-md-12 mb-2"></div>
							</div>
							<form name="form-up-imgs-all" id="form-up-imgs-all" method="post" accept-charset="utf-8" enctype="multipart/form-data">
								@csrf
								<div class="form-row">
									<div class="col-md-9">
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="files-all" name="images[]" required="required" accept=".png, .jpg, .jpeg">
											<label class="custom-file-label" for="files-all" data-browse="Elegir">
												Seleccionar archivos...
											</label>
										</div>
									</div>
									<div class="col-md-3">
										<button type="submit" id="btn-up-imgs-all" class="btn btn-success btn-block">
											<svg class="bi bi-cloud-upload" width="1.2em" height="1.2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
												<path d="M4.887 6.2l-.964-.165A2.5 2.5 0 1 0 3.5 11H6v1H3.5a3.5 3.5 0 1 1 .59-6.95 5.002 5.002 0 1 1 9.804 1.98A2.501 2.501 0 0 1 13.5 12H10v-1h3.5a1.5 1.5 0 0 0 .237-2.981L12.7 7.854l.216-1.028a4 4 0 1 0-7.843-1.587l-.185.96z"/>
												<path fill-rule="evenodd" d="M5 8.854a.5.5 0 0 0 .707 0L8 6.56l2.293 2.293A.5.5 0 1 0 11 8.146L8.354 5.5a.5.5 0 0 0-.708 0L5 8.146a.5.5 0 0 0 0 .708z"/>
												<path fill-rule="evenodd" d="M8 6a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0v-8A.5.5 0 0 1 8 6z"/>
											</svg>
										</button>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 mt-1">
										<div class="progress">
											<div id="prg-bar-up-all" class="progress-bar bg-defult" role="progressbar" style="width:100%;">0%</div>
										</div>
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-9">
							<form id="form-up-account" name="form-up-account" action="" method="POST" action="">
								@csrf
								<div class="form-row">
									<div class="col-md-4">
										<div class="form-group input-group">
											<span class="has-float-label">
												<input type="email" class="form-control" name="email" id="txt-email" placeholder="Nombre" required="required" value="{{$profile->email}}" autocomplete="off" readonly="">
												<label for="txt-email">Email</label>
											</span>
										</div>
									</div>
									<div class="col-md-8">
										<div class="form-group input-group">
											<span class="has-float-label">
												<input type="text" class="form-control" name="name" id="txt-name" placeholder="Nombre" required="required" value="{{$profile->name}}" autocomplete="off">
												<label for="txt-name">Nombre</label>
											</span>
										</div>
									</div>
									<div class="col-md-12">
										<button id="btn-up-account" name="btn-up-account" type="submit" class="btn btn-primary float-right">
											<svg class="bi bi-check2" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
												<path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
											</svg> Actualizar
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					<form id="form-up-passwd" name="form-up-passwd" action="" method="POST">
						@csrf
						<div class="form-row mt-3">
							<div class="col-md-3">
								<div class="form-group input-group">
									<span class="has-float-label">
										<input type="password" class="form-control" name="current" id="txt-curret" placeholder="Nombre" required="required" autocomplete="off">
										<label for="txt-curret">Contraseña Actual</label>
									</span>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group input-group">
									<span class="has-float-label">
										<input type="password" class="form-control" name="password" id="txt-passwd" placeholder="Nombre" required="required" autocomplete="off" minlength="8">
										<label for="txt-passwd">Nueva Contraeña</label>
									</span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group input-group">
									<span class="has-float-label">
										<input type="password" class="form-control" name="confirmed" id="txt-passwd-cofirm" placeholder="Nombre" required="required" autocomplete="off" minlength="8">
										<label for="txt-passwd-cofirm">Confirmar Contraeña</label>
									</span>
								</div>
							</div>
							<div class="col-md-2">
								<button id="btn-up-passwd" name="btn-up-passwd" type="submit" class="btn btn-primary float-right btn-block">
									<svg class="bi bi-check2" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
									</svg> Actualizar
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{asset('js/ajxtodoapp.js')}}" defer></script>
<script type="text/javascript">
	$(document).ready(function() {
		loadImg();
		matchPasswd('txt-passwd', 'txt-passwd-cofirm');
	});
</script>
@endsection