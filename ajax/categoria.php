<?php
require_once '../modelos/Categoria.php';

	$categoria = new Categoria();

	$idcategoria = isset($_POST['idcategoria'])? limpiarCadena($_POST['idcategoria']) : "";
	$nombre = isset($_POST['nombre'])? limpiarCadena($_POST['nombre']) : "";
	$descripcion = isset($_POST['descripcion'])? limpiarCadena($_POST['descripcion']) : "";

	switch ($_GET["op"]) {
		case 'guardaryeditar':
			if (empty($idcategoria)) {
				$respuesta = $categoria->insertar($nombre,$descripcion);
				echo $respuesta ? "Categoria registrada" : "Categoria no se pudo registrar";
			}else{
				$respuesta = $categoria->editar($idcategoria,$nombre,$descripcion);
				echo $respuesta ? "Categoria actualizada" : "Categoria no se pudo actualizar";
			}
		break;
		case 'desactivar':
			$respuesta =$categoria->desactivar	($idcategoria);
			echo $respuesta ? "Categoria desactivada" : "Categoria no se pudo desactivar";
		break;
		case 'activar':
			$respuesta =$categoria->activar	($idcategoria);
			echo $respuesta ? "Categoria activada" : "Categoria no se pudo activar";
		break;
		case 'mostrar':
			$respuesta = $categoria->mostrar($idcategoria);
			//codificar el resultado utilizando json
			echo json_encode($respuesta);
		break;
		case 'listar':
			$respuesta = $categoria->listar();
			//declaramos una rray para por ahi mostrar los datos
			$data = Array();
			//recorrer cada fila
			while ($reg = $respuesta->fetch_object()) {
				$data[] = array(
					            "0"=>($reg->condicion) ? '<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idcategoria.')"><i class="fa fa-pencil"></i></button>'.
					            ' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idcategoria.')"><i class="fa fa-close"></i></button>' :
					            '<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idcategoria.')"><i class="fa fa-pencil"></i></button>'.
					            ' <button class="btn btn-primary btn-sm" onclick="activar('.$reg->idcategoria.')"><i class="fa fa-check"></i></button>',
					            "1"=>$reg->nombre,
					            "2"=>$reg->descripcion,
					            "3"=>($reg->condicion) ? '<span class="label bg-green">activado</span>' :'<span class="label bg-red">Desactivado</span>'
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