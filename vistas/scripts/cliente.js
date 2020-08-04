'use strict';

var tabla;
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function(e){
		guardaryeditar(e);
	})
}
//funcion limpiar
function limpiar(){
	$("#nombre").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#idpersona").val("");
}

//funcion mostrar formulario
function mostrarform(flag){
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnAgregar").hide();
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnAgregar").show();
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
					url: '../ajax/persona.php?op=listarCliente',
					type : "get",
					dataType : "json",
					error: function(e){
						console.log(e.responseText);
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//PaginaciÃ³n
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

//funcion para guardar o edita
function guardaryeditar(e){
	e.preventDefault();// no se activara la accion predeterminada del evetto
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: '../ajax/persona.php?op=guardaryeditar',
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
function mostrar(idpersona)
{
	$.post("../ajax/persona.php?op=mostrar",{idpersona : idpersona}, function(data, status)
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
 		$("#idpersona").val(data.idpersona);

 	})
}

//funcion para  desactivar
function eleminar(idpersona){

	swal({
		title: "segurlo que quieres eleminar el cliente?",
		text: "Segur@ que quieres Eliminarl@!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.post('../ajax/persona.php?op=eleminar', {idpersona: idpersona}, function(e) {
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

