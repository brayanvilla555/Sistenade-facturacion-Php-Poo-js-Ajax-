<?php
require_once '../modelos/Consulta.php';

	$consulta = new Consulta();
	switch ($_GET["op"]) {
		case 'comprasfecha':
		//creaos dos variables para la fecha con el metodo REQUEST
		$fecha_inicio = $_REQUEST["fecha_inicio"];
		$fecha_fin = $_REQUEST["fecha_fin"];
			$respuesta = $consulta->comprasfecha($fecha_inicio, $fecha_fin);
			//declaramos una rray para por ahi mostrar los datos
			$data = Array();
			//recorrer cada fila
			while ($reg = $respuesta->fetch_object()) {
				$data[] = array(
					            "0"=>$reg->fecha,
					            "1"=>$reg->usuario,
					            "2"=>$reg->proveedor,
					            "3"=>$reg->tipo_comprobante,
					            "4"=>$reg->serie_comprobante.' '.$reg->num_comprobante,
					            "5"=>$reg->total_compra,
					            "6"=>$reg->impuesto,
					            "7"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
					            '<span class="label bg-red">Anulado</span>'
				               );
			}
			$results = array(
				"sEcho"=>1, // informacion para el detalle
				"iTotalRecords"=>count($data),//enviamos el totat de registros al detalle
				"iTotalDisplayRecords"=>count($data),//enviar el total de registros a visualizar
				"aaData"=>$data);
			    echo json_encode($results);
		break;
		case 'ventasfechacliente':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$idcliente=$_REQUEST["idcliente"];

		$rspta=$consulta->ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
			 				"0"=>$reg->fecha,
			 				"1"=>$reg->usuario,
			 				"2"=>$reg->cliente,
			 				"3"=>$reg->tipo_comprobante,
			 				"4"=>$reg->serie_comprobante.' '.$reg->num_comprobante,
			 				"5"=>$reg->total_venta,
			 				"6"=>$reg->impuesto,
			 				"7"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
			 				'<span class="label bg-red">Anulado</span>'
			 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	}

?>