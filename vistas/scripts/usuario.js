'use strict';

var tabla;
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function(e){
		guardaryeditar(e);
	})

	$("#imagenmuestra").hide();
	//mostrar permisos
	$.post("../ajax/usuario.php?op=permisos&id=", function(r){
		$("#permisos").html(r);
	})
}
//funcion limpiar
function limpiar(){
	$("#nombre").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#cargo").val("");
	$("#login").val("");
	$("#clave").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
	$("#idusuario").val("");
}

//funcion mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}
//funcion para canselar el formulario
function canselarform(){
	limpiar();
	mostrarform(false);
}

//FunciÃ³n Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//PaginaciÃ³n y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/usuario.php?op=listar',
					type : "get",
					dataType : "json",
					error: function(e){
						console.log(e.responseText);
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//PaginaciÃ³n
	    "order": [[ 0, "DESC" ]]//Ordenar (columna,orden)
	}).DataTable();
}

//funcion para guardar o edita
function guardaryeditar(e){
	e.preventDefault();// no se activara la accion predeterminada del evetto
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: '../ajax/usuario.php?op=guardaryeditar',
		type: 'POST',
		data: formData,
		contentType: false,
		processData: false,

		success:function (datos){
			swal({
				title: datos,
				text: datos,
				icon: "success",
				button: "ok!",
			});
			mostrarform(false);
			tabla.ajax.reload();
		}
	});
	limpiar();
}
//funcion para mostrar y editas
function mostrar(idusuario)
{
	$.post("../ajax/usuario.php?op=mostrar",{idusuario : idusuario}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);

		$("#nombre").val(data.nombre);
		$("#tipo_documento").val(data.tipo_documento);
		$("#tipo_documento").selectpicker('refresh');
		$("#num_documento").val(data.num_documento);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#email").val(data.email);
		$("#cargo").val(data.cargo);
		$("#login").val(data.login);
		$("#clave").val(data.clave);
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/usuarios/"+data.imagen);
		$("#imagenactual").val(data.imagen);
		$("#idusuario").val(data.idusuario);

 	});
 	$.post("../ajax/usuario.php?op=permisos&id="+idusuario, function(r){
		$("#permisos").html(r);
	})
}

//funcion para  desactivar
function desactivar(idusuario){

	swal({
		title: "seguro que lo quieres desactivar el usuario?",
		text: "Segur@ que quieres desactivarlo!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.post('../ajax/usuario.php?op=desactivar', {idusuario: idusuario}, function(e) {
				swal( e, {
					icon: "success",
				});
			});
			tabla.ajax.reload();
		} else {
			swal("Accion canselada!");
		}
	});
}

//funcion para activar
function activar(idusuario){

	swal({
		title: "segurl@ que quieres activarla el Usuario?",
		text: "Segura que quieres activarla!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.post("../ajax/usuario.php?op=activar", {idusuario : idusuario}, function(e){
        		swal( e, {
					icon: "success",
				});
        	});
			tabla.ajax.reload();
		} else {
			swal("Accion canselada!");
		}
	});
}

//para que siempre se ejecute prmero
init();

