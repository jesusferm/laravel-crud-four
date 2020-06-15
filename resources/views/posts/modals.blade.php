<div class="modal fade app-mdl" id="mdl-del-reg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-mdl-del">
				<h5 class="modal-title">
					<svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
						<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
					</svg> Eliminando registro
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<form method="post" id="form-del-reg" name="form-del-reg" action="">
				@csrf
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12 text-center" id="div-cnt-del-reg"></div>
					</div>
					<input type="hidden" id="txt-id-reg-del" name="id" readonly="" value="0">
					<div class="row">
						<div class="col-md-12 text-center" id="div-cnt-del-reg">
							<h5>
								¿Está seguro de eliminar <b class="text-danger" id="txt-nom-reg"></b>?
							</h5>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="btn-close-mdl-del-reg" class="btn btn-secondary" data-dismiss="modal">
						<i class="fa fa-times"></i> Cerrar
					</button>
					<button type="submit" class="btn btn-danger" id="btn-del-reg">
						<i class="fa fa-trash-alt"></i> Eliminar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="mdl-add-reg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-mdl-add">
				<h5 class="modal-title" id="exampleModalLabel">
					<svg class="bi bi-plus-circle" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"/>
						<path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"/>
						<path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
					</svg> Agregando registro
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-add-reg" name="form-add-reg" enctype="multipart/form-data" accept-charset="UTF-8">
				@csrf
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12 text-center" id="div-cnt-msg-add-reg"></div>
					</div>
					<div class="form-row">
						<div class="col-md-12">
							<div class="form-group input-group">
								<span class="has-float-label">
									<input type="text" class="form-control" name="title" id="txt-nom-add" placeholder="Nombre" required="required" value="" autocomplete="off">
									<label for="txt-nom-add">Nombre</label>
								</span>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group input-group">
								<span class="has-float-label">
									<input type="text" class="form-control" name="desc" id="desc" placeholder="Descripción" required="required" value="" autocomplete="off">
									<label for="desc">Descripción</label>
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
						<div class="col-md-6">
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="image" name="image[]" required="required" accept=".png, .jpg, .jpeg" onchange="readURL(this, 'div-cnt-imgs-ajx');">
								<label class="custom-file-label" for="image" data-browse="Elegir">
									Seleccionar...
								</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row" id="div-cnt-imgs-ajx" style="height: 100px;"></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-close-mdl-add-reg" name="btn-close-form-add-reg">
						<i class="fa fa-times"></i> Cancelar
					</button>
					<button type="submit" class="btn btn-success" id="btn-add-reg" name="btn-add-reg">
						<i class="fa fa-check"></i> Agregar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>