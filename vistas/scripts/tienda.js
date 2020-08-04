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
	$("#idtienda").val("");
	$("#nombre").val("");
	$("#ruc").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#rol").val("");
	$("#imagen").val("");
	$("#imagenmuestra").attr("src", "");
}

//funcion mostrar formulario
function mostrarform(flag){
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnAgregar").hide();//actvar boton con show y pder agregar sucursales
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnAgregar").hide();//actvar boton con show y pder agregar sucursales
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
					url: '../ajax/tienda.php?op=listar',
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
		url: '../ajax/tienda.php?op=guardaryeditar',
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
function mostrar(idtienda)
{
	$.post("../ajax/tienda.php?op=mostrar",{idtienda : idtienda}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);
		$("#idtienda").val(data.idtienda);
		$("#nombre").val(data.nombre);
		$("#ruc").val(data.ruc);
 		$("#direccion").val(data.direccion);
 		$("#telefono").val(data.telefono);
 		$("#email").val(data.email);
 		$("#rol").val(data.rol);
		$("#rol").selectpicker('refresh');
 		$("#imagenmuestra").attr("src", "../files/tienda/"+data.imagen);
 		$("#imagenactual").val(data.imagen);
 		$("#imagen").val(data.imagen);

 	})
}

//funcion para  desactivar
function desactivar(idtienda){

	swal({
		title: "segurlo que lo quieres desactivar la tienda?",
		text: "Segur@ que quieres desactivarla la tienda!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.post('../ajax/tienda.php?op=desactivar', {idtienda: idtienda}, function(e) {
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
function activar(idtienda){

	swal({
		title: "segurl@ que quieres activar la tienda?",
		text: "Segura que quieres activar la tienda o sucursal!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.post("../ajax/tienda.php?op=activar", {idtienda : idtienda}, function(e){
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

