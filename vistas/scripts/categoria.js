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
	$("#descripcion").val("");
	$("#idcategoria").val("");
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
					url: '../ajax/categoria.php?op=listar',
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
		url: '../ajax/categoria.php?op=guardaryeditar',
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
function mostrar(idcategoria)
{
	$.post("../ajax/categoria.php?op=mostrar",{idcategoria : idcategoria}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);

		$("#nombre").val(data.nombre);
		$("#descripcion").val(data.descripcion);
 		$("#idcategoria").val(data.idcategoria);

 	})
}

//funcion para  desactivar
function desactivar(idcategoria){

	swal({
		title: "segurlo que lo quieres desactivar?",
		text: "Segur@ que quieres desactivarla!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.post('../ajax/categoria.php?op=desactivar', {idcategoria: idcategoria}, function(e) {
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
function activar(idcategoria){

	swal({
		title: "segurl@ que quieres activarla?",
		text: "Segura que quieres activarla!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.post("../ajax/categoria.php?op=activar", {idcategoria : idcategoria}, function(e){
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

