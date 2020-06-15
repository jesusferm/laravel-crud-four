var limite 		= 10;
var filter 		= 2;
var order 		= "desc";
var order_by	= "id";

$('.dropdown-limit .dropdown-menu').find('a').click(function(e) {
	$("#spn-show-list").text($(this).data("total"));
	limite = $(this).data("total");
	load(1);
	e.preventDefault();
});

$('.dropdown-edo .dropdown-menu').find('a').click(function(e) {
	filter 		= $(this).data("edo");
	$("#i-icon-act").removeAttr("class").attr("class", $(this).data("icon"));
	$("#spn-desc-act").text($(this).data("desc"));
	load(1);
	e.preventDefault();
});

$("#form-search").submit(function( event ) {
	var parametros = $(this).serialize();
	load(1);
	event.preventDefault();
});

function load(page) {
	var search 		= $('#txt-search').val();
	$.ajax({
		type: 		'POST',
		url: 		base_url+'/page',
		method: 	'POST',
		dataType: 	'JSON',
		data: {
			page: 	page,
			search: search,
			filter: filter,
			limite: limite,
			order: 	order,
			order_by: order_by,
		},
		beforeSend: function(objeto) {
			$('#btn-search').html('<span class="spinner-border spin-x align-middle" role="status" aria-hidden="true"></span> Buscando...');
			//$("#div-cnt-load").html('<div class="text-center alert alert-info" role="alert">'+
			//'<span class="spinner-border spin-x" role="status" aria-hidden="true"></span> Buscando...</div>');
		},
		success: function(res) {
			$('#div-cnt-load').html(res.data);
			$('#h5-cnt-total').html(res.total);
			$('#btn-search').html('<i class="text-primary fas fa-search"></i>');
		},
		error: function(data) {
			$("#btn-search").html('<i class="text-primary fas fa-search"></i>');
			$("#div-cnt-load").html('<div class="text-center alert alert-danger" role="alert"><i class="fas fa-exclamation-circle"></i> Error interno, intenta más tarde.</div>');
		}
	});
}

$(document).on("click", ".table th.th-link", function () {
	if (order=="asc") {
		order 	= "desc";
	}else{
		order 	= "asc";
	}
	order_by = $(this).attr("data-field");
	load(1);
});

$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$("#form-update").submit(function( e ) {
	$('#btn-update').attr("disabled", true);
	$.ajax({
		url: 			base_url+"/postupdate",
		method: 		'POST',
		dataType: 		'JSON',
		data: 			new FormData(this),
		contentType: 	false,
		cache: 			false,
		processData: 	false,
		beforeSend: function(objeto) {
			$("#btn-update").html('<span class="spinner-border spin-x align-middle" role="status"><span class="sr-only">Loading...</span></span> Actualizando...');
		},
		success:function(response){
			notify_msg(response.icon, " ", response.msg, "#", response.type);
			$('#btn-update').attr("disabled", false);
			$("#btn-update").html('<i class="fa fa-check"></i> Actualizar');
		},
		error:function(error){
			$('#btn-update').attr("disabled", false);
			$("#btn-update").html('<i class="fa fa-check"></i> Actualizar');
			notify_msg("fa fa-exclamation-circle", " ", "Error interno, por favor intenta más tarde.", "#", "danger");
		}
	});
	e.preventDefault();
});

$("#form-add").submit(function( e ) {
	$('#btn-add').attr("disabled", true);
	$.ajax({
		url: 			base_url+"/postinsert",
		method: 		'POST',
		dataType: 		'JSON',
		data: 			new FormData(this),
		contentType: 	false,
		cache: 			false,
		processData: 	false,
		beforeSend: function(objeto) {
			$("#btn-add").html('<span class="spinner-border spin-x align-middle" role="status"><span class="sr-only">Loading...</span></span> Guardando...');
		},
		success:function(response){
			if(response.type=="success"){
				notify_msg(response.icon, " ", response.msg, "#", response.type);
				$("#form-add")[0].reset();
				setTimeout(function(){
					window.location.replace(response.url);
				}, 100);
			}else{
				notify_msg(response.icon, " ", response.msg, "#", response.type);
			}
			$('#btn-add').attr("disabled", false);
			$("#btn-add").html('<i class="fa fa-check"></i> Agregar');
		},
		error:function(error){
			$('#btn-add').attr("disabled", false);
			$("#btn-add").html('<i class="fa fa-check"></i> Agregar');
			notify_msg("fa fa-exclamation-circle", " ", "Error interno, por favor intenta más tarde.", "#", "danger");
		}
	});
	e.preventDefault();
});

$(document).on("click", ".mdl-del-reg", function () {
	$("#txt-id-reg-del").val($(this).data('idreg'));
	$("#txt-nom-reg").text('"'+$(this).data('nomreg')+'"');
});

$(document).on("click", ".btn-open-mdl", function () {
	$("#div-cnt-msg-add-reg").html('');
	$("#div-cnt-imgs-ajx").html('');
});

$("#form-del-reg").submit(function( e ) {
	var data = $(this).serialize();
	var url = base_url+"/postdelete";
	$('#btn-del-reg').attr("disabled", true);
	$.ajax({
		url:url,
		method:'POST',
		dataType: 'JSON',
		data:data,
		beforeSend: function(objeto) {
			$("#btn-del-regs").html('<span class="spinner-border spin-x align-middle" role="status"><span class="sr-only">Loading...</span></span> Eliminando...');
		},
		success:function(response){
			if(response.type=="success"){
				$("#form-del-reg")[0].reset();
				load(1);
				$("#btn-close-mdl-del-reg").trigger("click");
				notify_msg(response.icon, " ", response.msg, "#", response.type);
			}else{
				$("#div-cnt-del-reg").html('<div class="alert alert-'+response.type+'" role="alert"><i class="'+response.icon+'"></i> '+response.msg+'</div>');
			}
			$('#btn-del-reg').attr("disabled", false);
			$("#btn-del-reg").html('<i class="fa fa-trash-alt"></i> Eliminar');
		},
		error:function(error){
			$('#btn-del-reg').attr("disabled", false);
			$("#btn-del-reg").html('<i class="fa fa-trash-alt"></i> Eliminar');
			$("#div-cnt-del-reg").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-circle"></i> Error interno, intenta más tarde.</div>');
		}
	});
	e.preventDefault();
});


$("#form-add-reg").submit(function( e ) {
	$('#btn-add-reg').attr("disabled", true);
	$.ajax({
		url: 			base_url+"/postinsert",
		method: 		'POST',
		dataType: 		'JSON',
		data: 			new FormData(this),
		contentType: 	false,
		cache: 			false,
		processData: 	false,
		beforeSend: function(objeto) {
			$("#btn-add-reg").html('<span class="spinner-border spin-x align-middle" role="status"><span class="sr-only">Loading...</span></span> Guardando...');
		},
		success:function(response){
			if(response.type=="success"){
				$("#form-add-reg")[0].reset();
				load(1);
				$("#btn-close-mdl-add-reg").trigger("click");
				notify_msg(response.icon, " ", response.msg, "#", response.type);
				/*setTimeout(function(){
					window.location.replace(response.url);
				}, 100);*/
				$("#div-cnt-imgs-ajx").html('');
			}else{
				$("#div-cnt-msg-add-reg").html('<div class="alert alert-'+response.type+'" role="alert"><i class="'+response.icon+'"></i> '+response.msg+'</div>');
			}
			$('#btn-add-reg').attr("disabled", false);
			$("#btn-add-reg").html('<i class="fa fa-check"></i> Agregar');
		},
		error:function(error){
			$('#btn-add-reg').attr("disabled", false);
			$("#btn-add-reg").html('<i class="fa fa-check"></i> Agregar');
			$("#div-cnt-msg-add-reg").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-circle"></i> Error interno, intenta más tarde.</div>');
		}
	});
	e.preventDefault();
});

$("#form-up-account").submit(function( e ) {
	$('#btn-up-account').attr("disabled", true);
	var data = $(this).serialize();
	var url = base_url+"/accountupdate";
	$.ajax({
		url: 	url,
		method: 'POST',
		dataType: 'JSON',
		data: 	data,
		beforeSend: function(objeto) {
			$("#btn-up-account").html('<span class="spinner-border spin-x align-middle" role="status"><span class="sr-only">Loading...</span></span> Actualizando...');
		},
		success:function(response){
			notify_msg(response.icon, " ", response.msg, "#", response.type);
			$('#btn-up-account').attr("disabled", false);
			$("#btn-up-account").html('<i class="fa fa-check"></i> Actualizar');
		},
		error:function(error){
			$('#btn-up-account').attr("disabled", false);
			$("#btn-up-account").html('<i class="fa fa-check"></i> Actualizar');
			notify_msg("fa fa-exclamation-circle", " ", "Error interno, por favor intenta más tarde.", "#", "danger");
		}
	});
	e.preventDefault();
});


$("#form-up-imgs-all").submit(function( event ) {
	var myfile 		= $("#files-all").val();
	var formData 	= new FormData();
	var fl 			= document.getElementById('files-all');
	var ln 			= fl.files.length;

	if (ln <= 0) {
		notify_msg("fa fa-exclamation-circle", " ", "Por favor seleccione al menos un archivo.", "#", "danger");
		return;
	}else{
		$("#prg-bar-up-all").removeAttr("class").attr("class", "progress-bar bg-success text-center");
		$("#prg-bar-up-all").css('width', '0');
		$("#btn-up-imgs-all").attr('disabled', 'disabled');
		$.ajax({
			url: 			base_url+"/upimage",
			data: 			new FormData(this),
			contentType: 	false,
			cache: 			false,
			processData: 	false,
			type: 			'POST',
			xhr: function () {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress", function (evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
						percentComplete = parseInt(percentComplete * 100);
						$("#prg-bar-up-all").text(percentComplete + '%');
						$("#prg-bar-up-all").css('width', percentComplete + '%');
					}
				}, false);
				return xhr;
			},
			success: function (data) {
				notify_msg(data.icon, " ", data.msg, "#", data.type);
				$("#prg-bar-up-all").css('width', 100 + '%');
				$("#prg-bar-up-all").text('0%');
				$("#div-cnt-imgs-all").html("");
				if (data.type == 'success') {
					setTimeout(function(){
						$("#prg-bar-up-all").removeAttr("class").attr("class", "progress-bar bg-defult text-center");
					}, 3000);
					loadImg();
				}else{
					setTimeout(function(){
						$("#prg-bar-up-all").removeAttr("class").attr("class", "progress-bar bg-defult text-center");
					}, 3000);
				}
				$("#btn-up-imgs-all").attr("disabled", false);
				$("#form-up-imgs-all")[0].reset();
			},
			error: function(data) {
				$("#div-cnt-imgs-all").html("");
				$("#btn-up-imgs-all").attr("disabled", false);
				$("#prg-bar-up-all").css('width', 100 + '%');
				$("#prg-bar-up-all").text('0%');
				$("#prg-bar-up-all").removeAttr("class").attr("class", "progress-bar bg-danger text-center");
				notify_msg("fa fa-times", " ", "Error en la configuración de ajax.", "#", "danger");
			}
		});
	}
	event.preventDefault();
});

function loadImg(){
	$.ajax({
		type: 		"POST",
		dataType: 	"JSON",
		method: 	"POST",
		url: 		base_url+"/loadimage",
		data: {
			id: "021",
		},
		beforeSend: function(objeto) {
			$("#div-img").html(' <div class="alert alert-info text-center"><span class="spinner-border spin-x align-middle" role="status" aria-hidden="true"></span>'+
				'<span class="sr-only">Loading...</span> Cargando</div>');
		},
		success: function(data) {
			$("#div-img").html(data.img);
		},
		error: function(error){
			$("#div-img").html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Error, intente de nuevo.</div>');
		}
	});
}

$("#form-up-passwd").submit(function( e ) {
	$('#btn-up-passwd').attr("disabled", true);
	var data = $(this).serialize();
	var url = base_url+"/uppassword";
	$.ajax({
		url: 	url,
		method: 'POST',
		data: 	data,
		beforeSend: function(objeto) {
			$("#btn-up-passwd").html('<span class="spinner-border spin-x align-middle" role="status"><span class="sr-only">Loading...</span></span> Actualizando...');
		},
		success:function(response){
			notify_msg(response.icon, " ", response.msg, "#", response.type);
			$('#btn-up-passwd').attr("disabled", false);
			$("#btn-up-passwd").html('<i class="fa fa-check"></i> Actualizar');
			$("#form-up-passwd")[0].reset();
		},
		error:function(error){
			$('#btn-up-passwd').attr("disabled", false);
			$("#btn-up-passwd").html('<i class="fa fa-check"></i> Actualizar');
			notify_msg("fa fa-exclamation-circle", " ", "Error interno, por favor intenta más tarde.", "#", "danger");
		}
	});
	e.preventDefault();
});

function matchPasswd(passwd, confirm){
	var password = document.getElementById(passwd);
	var confirm_password = document.getElementById(confirm);
	function validatePassword(){
		if(password.value != confirm_password.value){
			confirm_password.setCustomValidity("Las contraseñas no coinciden.");
		}else{
			confirm_password.setCustomValidity('');
		}
	}
	password.onchange 			= validatePassword;
	confirm_password.onkeyup 	= validatePassword;
}

function readURL(input, div) {
	var total_files = $(input)[0].files.length;
	$("#"+div).html('');
	for (i = 0; i<total_files; i++) {
		if ($(input)[0].files[i]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#"+div).append('<div class="col-6"><img class="img-fluid" id="img-'+i+'" src="'+e.target.result+'"/></div>')
			};
			reader.readAsDataURL(input.files[i]);
		}
	}
}