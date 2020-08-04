'use strict';

var tabla;
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function(e){
		guardaryeditar(e);
	});
	//cargamos los itrms al selec proveedor
	$.post("../ajax/ingreso.php?op=selectProveedor", function(r){
		$("#idproveedor").html(r);
		$("#idproveedor").selectpicker('refresh');
	});
}
//funcion limpiar
function limpiar(){
	$("#idproveedor").val("");
	$("#proveedor").val("");
	$("#serie_comprobante").val("");
	$("#num_comprobante").val("");
	$("#impuesto").val("0");

	$("#total_compra").val("");
	$(".filas").remove();
	$("#total").html("0");

	//obtener la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day);
	$('#fecha_hora').val(today);

	//mostrar el primer tipo de comprobante
	$("#tipo_comprobante").val("Boleta");
	$("#tipo_comprobante").selectpicker('refresh');

}
//funcion mostrar formulario
function mostrarform(flag){
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnAgregar").hide();
		listarArticulos();

		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		detalles=0;
		$("#btnAgregarArt").show();
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
					url: '../ajax/ingreso.php?op=listar',
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
//funcion listar los articulos
function listarArticulos()
{
	tabla=$('#tblarticulos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [

		        ],
		"ajax":
				{
					url: '../ajax/ingreso.php?op=listarArticulos',
					type : "get",
					dataType : "json",
					error: function(e){
						console.log(e.responseText);
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//funcion para guardar o edita
function guardaryeditar(e){
	e.preventDefault();// no se activara la accion predeterminada del evetto
	//$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: '../ajax/ingreso.php?op=guardaryeditar',
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
			listar(); // funcion para actualizar a la tabla y ostrar los datos por pantalla
			//tabla.ajax.reload();
		}
	});
	limpiar();
}
//funcion para mostrar y editas
function mostrar(idingreso)
{
	$.post("../ajax/ingreso.php?op=mostrar",{idingreso : idingreso}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);

		$("#idproveedor").val(data.idproveedor);
		$("#idproveedor").selectpicker('refresh');
		$("#tipo_comprobante").val(data.tipo_comprobante);
		$("#tipo_comprobante").selectpicker('refresh');
		$("#serie_comprobante").val(data.serie_comprobante);
		$("#num_comprobante").val(data.num_comprobante);
		$("#fecha_hora").val(data.fecha);
		$("#impuesto").val(data.impuesto);
		$("#idingreso").val(data.idingreso);

		//ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();

 	});
 	$.post("../ajax/ingreso.php?op=listarDetalle&id="+idingreso, function(r) {
 		$("#detalles").html(r);
 	});
}

//funcion para  anular
function anular(idingreso){

	swal({
		title: "segurlo que lo quieres anular el ingreso?",
		text: "Segur@ que quieres anular el ingreso!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.post('../ajax/ingreso.php?op=anular', {idingreso: idingreso}, function(e) {
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
//declaracion de variables necesarias para trabajar con las comprasy
//sus detalles
var impuesto = 18; //variable impuesto
var cont = 0; //variable contador
var detalles = 0; //variable del detalle

$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);

function marcarImpuesto(){
	var tipo_comprobante = $("#tipo_comprobante option:selected").text();
	//activar o descativar el imput del impuesto segun el caso
	var caja = document.querySelector("#impuesto");
	if (tipo_comprobante == 'Factura') {
		$(caja).val(impuesto);
		caja.disabled = false;
	}else{
		caja.disabled = false;
		$("#impuesto").val("0");
	}
}
//funcion par agregar los productos al detalle
function agregarDetalle(idarticulo, articulo){
	var cantidad = 1;
	var precio_compra = 1;
	var precio_venta = 1;
	if (idarticulo != "") {
		var subtotal = cantidad * precio_compra;
		var fila = '<tr class="filas" id="fila'+cont+'">'+
						'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
						'<td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td>'+
						'<td><input type="number" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
						'<td><input type="number" name="precio_compra[]" id="precio_compra[]" value="'+precio_compra+'"></td>'+
						'<td><input type="number" name="precio_venta[]" value="'+precio_venta+'"></td>'+
						'<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></td>'+
						'<td><button type="button" class="btn btn-info" onclick="modificarSubtotales()"><i class="fa fa-refresh"></i></button></td>'+
					'</tr>';
					cont ++;
					detalles = detalles+1;
					$('#detalles').append(fila);
					modificarSubtotales();
	}else{
		alert('Error al ingresar el detalle, revisa los datos del articulo');
	}
}
//funcion para modificar los subtotales de los ingreoso
function modificarSubtotales(){
	var cantidad = document.getElementsByName("cantidad[]");
	var precio = document.getElementsByName("precio_compra[]");
	var subtotal = document.getElementsByName("subtotal");
	//recorrer y sumar la cantidad
	for (var i = 0; i < cantidad.length; i++) {
		var inputCantidad = cantidad[i];
		var inputPrecioCompra = precio[i];
		var inputSubtotal = subtotal[i];

		inputSubtotal.value = inputCantidad.value * inputPrecioCompra.value;
		document.getElementsByName("subtotal")[i].innerHTML = inputSubtotal.value;
		//document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
	}
	calcularTotales();
}

//funcion para calcular los subtotales y luego sumarles para sacar el total
function calcularTotales(){
	var subtotal = document.getElementsByName("subtotal");
	var total = 0.0;

	for (var i = 0; i < subtotal.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
	}
	//mostrar el total en la vista
	$("#total").html("S/. "+total);
	$("#total_compra").val(total);
	evaluar();
}

/*funcion evaluar para que cuando como minimo tengas un producto que guardar te a
paresca el boton guardar*/
function evaluar(){
	if (detalles > 0) {
		$("#btnGuardar").show();
	}else{
		$("#btnGuardar").hide();
		cont = 0;
	}
}

//funcion para eliminar el detalle de la lista de ingresos si por error agrego uno que no era
function eliminarDetalle(indice){
	$("#fila" + indice).remove();
	calcularTotales();
	detalles = detalles-1;
}
//para que siempre se ejecute prmero
init();

