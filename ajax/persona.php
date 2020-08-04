<?php
require_once '../modelos/Persona.php';

	$persona = new Persona();

	$idpersona = isset($_POST['idpersona'])? limpiarCadena($_POST['idpersona']) : "";
	$tipo_persona = isset($_POST['tipo_persona'])? limpiarCadena($_POST['tipo_persona']) : "";
	$nombre = isset($_POST['nombre'])? limpiarCadena($_POST['nombre']) : "";
	$tipo_documento = isset($_POST['tipo_documento'])? limpiarCadena($_POST['tipo_documento']) : "";
	$num_documento = isset($_POST['num_documento'])? limpiarCadena($_POST['num_documento']) : "";
	$direccion = isset($_POST['direccion'])? limpiarCadena($_POST['direccion']) : "";
	$telefono = isset($_POST['telefono'])? limpiarCadena($_POST['telefono']) : "";
	$email = isset($_POST['email'])? limpiarCadena($_POST['email']) : "";

	switch ($_GET["op"]) {
		case 'guardaryeditar':
			if (empty($idpersona)) {
				$respuesta = $persona->insertar($tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email);
				echo $respuesta ? "Persona registrada" : "Persona no se pudo registrar";
			}else{
				$respuesta = $persona->editar($idpersona,$tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email);
				echo $respuesta ? "Persona actualizada" : "Persona no se pudo actualizar";
			}
		break;
		case 'eleminar':
			$respuesta = $persona->eleminar($idpersona);
			echo $respuesta ? "Presona eliminada" : "Persona no se pudo eleminar";
		break;
		case 'mostrar':
			$respuesta = $persona->mostrar($idpersona);
			//codificar el resultado utilizando json
			echo json_encode($respuesta);
		break;
		case 'listarProveedor':
			$respuesta = $persona->listarProveedor();
			//declaramos una rray para por ahi mostrar los datos
			$data = Array();
			//recorrer cada fila
			while ($reg = $respuesta->fetch_object()) {
				$data[] = array(
					            "0"=>'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.
					            ' <button class="btn btn-danger btn-sm" onclick="eleminar('.$reg->idpersona.')"><i class="fa fa-trash"></i></button>',
					            "1"=>$reg->nombre,
					            "2"=>$reg->tipo_documento,
					            "3"=>$reg->num_documento,
					            "4"=>$reg->telefono,
					            "5"=>$reg->email
				               );
			}
			$results = array(
				"sEcho"=>1, // informacion para el detalle
				"iTotalRecords"=>count($data),//enviamos el totat de registros al detalle
				"iTotalDisplayRecords"=>count($data),//enviar el total de registros a visualizar
				"aaData"=>$data);
			    echo json_encode($results);
		break;
		case 'listarCliente':
			$respuesta = $persona->listarCliente();
			//declaramos una rray para por ahi mostrar los datos
			$data = Array();
			//recorrer cada fila
			while ($reg = $respuesta->fetch_object()) {
				$data[] = array(
					            "0"=>'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.
					            ' <button class="btn btn-danger btn-sm" onclick="eleminar('.$reg->idpersona.')"><i class="fa fa-trash"></i></button>',
					            "1"=>$reg->nombre,
					            "2"=>$reg->tipo_documento,
					            "3"=>$reg->num_documento,
					            "4"=>$reg->telefono,
					            "5"=>$reg->email
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