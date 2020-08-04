<?php
require_once '../modelos/Articulo.php';

	$articulo = new Articulo();

	$idarticulo = isset($_POST['idarticulo'])? limpiarCadena($_POST['idarticulo']) : "";
	$codigo = isset($_POST['codigo'])? limpiarCadena($_POST['codigo']) : "";
	$idcategoria = isset($_POST['idcategoria'])? limpiarCadena($_POST['idcategoria']) : "";
	$nombre = isset($_POST['nombre'])? limpiarCadena($_POST['nombre']) : "";
	$stock = isset($_POST['stock'])? limpiarCadena($_POST['stock']) : "";
	$descripcion = isset($_POST['descripcion'])? limpiarCadena($_POST['descripcion']) : "";
	$imagen = isset($_POST['imagen'])? limpiarCadena($_POST['imagen']) : "";

	switch ($_GET["op"]) {
		case 'guardaryeditar':
		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
			$imagen = $_POST['imagenactual'];
		}else{
			$extension = explode(".", $_FILES['imagen']['tmp_name']);
			$type_img = $_FILES['imagen']['type'];
			if ($type_img == "image/jpg" || $type_img == "image/jpeg" || $type_img == "image/png" || $type_img == "image/gif") {

				/*if(!is_dir('files/articulos')){
					mkdir('files/articulos', 0777, true);
				}*/
				$imagen = round(microtime(true)) . '.' . end($extension);
				move_uploaded_file($_FILES['imagen']['tmp_name'], "../files/articulos/". $imagen);
			}
		}
		if (empty($idarticulo)) {
			$respuesta = $articulo->insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);
			echo $respuesta ? "Articulo registrada" : "Articulo no se pudo registrar";
		}else{
			$respuesta = $articulo->editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);
			echo $respuesta ? "Articulo actualizada" : "Articulo no se pudo actualizar";
		}
		break;
		case 'desactivar':
			$respuesta =$articulo->desactivar($idarticulo);
			echo $respuesta ? "Articulo desactivada" : "Articulo no se pudo desactivar";
		break;
		case 'activar':
			$respuesta =$articulo->activar($idarticulo);
			echo $respuesta ? "Articulo activada" : "Articulo no se pudo activar";
		break;
		case 'mostrar':
			$respuesta = $articulo->mostrar($idarticulo);
			//codificar el resultado utilizando json
			echo json_encode($respuesta);
		break;
		case 'listar':
			$respuesta = $articulo->listar();
			//declaramos una rray para por ahi mostrar los datos
			$data = Array();
			//recorrer cada fila
			while ($reg = $respuesta->fetch_object()) {
				$data[] = array(
					            "0"=>($reg->condicion) ? '<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.
					            ' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idarticulo.')"><i class="fa fa-close"></i></button>' :
					            '<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.
					            ' <button class="btn btn-primary btn-sm" onclick="activar('.$reg->idarticulo.')"><i class="fa fa-check"></i></button>',
					            "1"=>$reg->nombre,
					            "2"=>$reg->categoria,
					            "3"=>$reg->codigo,
					            "4"=>$reg->stock,
					            "5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'></img>",
					            "6"=>($reg->condicion) ? '<span class="label bg-green">activado</span>' :'<span class="label bg-red">Desactivado</span>'
				               );
			}
			$results = array(
				"sEcho"=>1, // informacion para el detalle
				"iTotalRecords"=>count($data),//enviamos el totat de registros al detalle
				"iTotalDisplayRecords"=>count($data),//enviar el total de registros a visualizar
				"aaData"=>$data);
			    echo json_encode($results);
		break;

		case 'selectCategoria':
			require_once '../modelos/Categoria.php';
			$categoria = new Categoria();

			$respuesta = $categoria->select();
			while ($reg = $respuesta->fetch_object()) {
				echo '<option value='.$reg->idcategoria.'>'.$reg->nombre.'</option>';
			}
		break;

	}

?>