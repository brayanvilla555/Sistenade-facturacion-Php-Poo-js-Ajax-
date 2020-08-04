'use strict';

var tabla;
function init(){
	//mostrarform(false);
	listar();

	//recargar en caso cambies las fechas
	$("#fecha_inicio").change(listar);
	$("#fecha_fin").change(listar);
}
//FunciÃ³n Listar
function listar()
{
	//declaramos nuestras dos variables para filtra las fechas
	var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();

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
					url: '../ajax/consulta.php?op=comprasfecha',
					//pasamos nuestros parametros de fecha
					data: {fecha_inicio: fecha_inicio, fecha_fin: fecha_fin},
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

//para que siempre se ejecute prmero
init();

