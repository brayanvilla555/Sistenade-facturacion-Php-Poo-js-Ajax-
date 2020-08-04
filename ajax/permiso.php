<?php
require_once '../modelos/Permiso.php';

	$permiso = new Permiso();

	switch ($_GET["op"]) {
		case 'listar':
			$respuesta = $permiso->listar();
			//declaramos una rray para por ahi mostrar los datos
			$data = Array();
			//recorrer cada fila
			while ($reg = $respuesta->fetch_object()) {
				$data[] = array(
					            "0"=>$reg->nombre,
				               );
			}
			$results = array(
				"sEcho"=>1, // informacion para el detalle
				"iTotalRecords"=>count($data),//enviamos el totat de registros al detalle
				"iTotalDisplayRecords"=>count($data),//enviar el total de registros a visualizar
				"aaData"=>$data);
			    echo json_encode($results);
		break;

	}

?>