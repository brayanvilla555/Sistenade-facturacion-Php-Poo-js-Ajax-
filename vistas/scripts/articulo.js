'use strict';

var tabla;
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function(e){
		guardaryeditar(e);
	})
	//cargar los items  al select de la categoria
	$.post('../ajax/articulo.php?op=selectCategoria', function(r) {
		$("#idcategoria").html(r);
		$("#idcategoria").selectpicker('refresh');
	});

	$("#imagenmuestra").hide();
}
//funcion limpiar
function limpiar(){
	$("#codigo").val("");
	$("#nombre").val("");
	$("#descripcion").val("");
	$("#stock").val("");
	$("#imagenmuestra").attr("src", "");
	$("#imagenactual").val("");
	$("#print").hide();
	$("#idarticulo").val("");
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
					url: '../ajax/articulo.php?op=listar',
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
		url: '../ajax/articulo.php?op=guardaryeditar',
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
function mostrar(idarticulo)
{
	$.post("../ajax/articulo.php?op=mostrar",{idarticulo : idarticulo}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);

		$("#idcategoria").val(data.idcategoria);
		$("#idcategoria").selectpicker('refresh');
		$("#codigo").val(data.codigo);
		$("#nombre").val(data.nombre);
		$("#stock").val(data.stock)
		$("#descripcion").val(data.descripcion);
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src", "../files/articulos/"+data.imagen);
		$("#imagenactual").val(data.imagen);
 		$("#idarticulo").val(data.idarticulo);
 		generarbarcode();

 	})
}

//funcion para  desactivar
function desactivar(idarticulo){

	swal({
		title: "segurlo que lo quieres desactivar el articulo?",
		text: "Segur@ que quieres desactivarla!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.post('../ajax/articulo.php?op=desactivar', {idarticulo: idarticulo}, function(e) {
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
function activar(idarticulo){

	swal({
		title: "segurl@ que quieres activarla el articulo?",
		text: "Segura que quieres activarla!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.post("../ajax/articulo.php?op=activar", {idarticulo : idarticulo}, function(e){
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
//funcion codigo de barras
function generarbarcode(){
	var codigo = $("#codigo").val();
	JsBarcode("#barcode", codigo);
	$("#print").show();
}

//imprimir nuestro codigo de barras
function imprimir(){
	$('#print').printArea();
}


//para que siempre se ejecute prmero
init();

