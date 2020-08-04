<?php
	 ob_start();
	 if (strlen(session_id()) < 1) { // iniciamos la session pero verificaos si no existe ninguna
	 	session_start();
	 }
	if (isset($_SESSION['compras']) && $_SESSION['compras'] ==1) {
	 require_once '../modelos/Ingreso.php';
	$ingreso = new Ingreso();

	$idingreso=isset($_POST["idingreso"])? limpiarCadena($_POST["idingreso"]):"";
	$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
	$idusuario=$_SESSION["idusuario"];
	$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
	$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
	$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
	$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
	$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
	$total_compra=isset($_POST["total_compra"])? limpiarCadena($_POST["total_compra"]):"";

	switch ($_GET["op"]) {
		case 'guardaryeditar':
			if (empty($idingreso)) {
				$respuesta = $ingreso->insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_compra"],$_POST["precio_venta"]);
				echo $respuesta ? "Ingreso registrado" : "No se pudieron registrar todos los datos del ingreso";
			}else{

				//dejamos bacio para que lo usen si lo decean mejorar al sistema
			}
		break;
		case 'anular':
			$respuesta =$ingreso->anular($idingreso);
			echo $respuesta ? "Ingreso anulado" : "No se pudo anular el ingreso";
		break;
		case 'mostrar':
			$respuesta = $ingreso->mostrar($idingreso);
			//codificar el resultado utilizando json
			echo json_encode($respuesta);
		break;
		//listar el detalle de un ingreso en
		case 'listarDetalle':
			//recibir el idingreso
			$id = $_GET['id'];

			$respuesta = $ingreso->listarDetalle($id);
			$total = 0;
			//recorer cada fila del detalle de los productos ingresados
			echo '<thead style="background-color:#A9D0F5">
                    <th>Opciones</th>
                    <th>Artículo</th>
                    <th>Cantidad</th>
                    <th>Precio Compra</th>
                    <th>Precio Venta</th>
                    <th>Subtotal</th>
                 </thead>';
					while ($reg = $respuesta->fetch_object()) {
						echo '<tr class="filas">
								   <td></td>
						           <td>'.$reg->nombre.'</td>
						           <td>'.$reg->cantidad.'</td>
						           <td>'.$reg->precio_compra.'</td>
						           <td>'.$reg->precio_venta.'</td>
						           <td>'.$reg->precio_compra * $reg->cantidad.'</td>
						      </tr>';
						      $total +=($reg->precio_compra * $reg->cantidad);
					}
			echo '<tfoot>
                    <th>TOTAL</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="total_compra" id="total_compra"></th>
                </tfoot>';
		break;
		//listar todos los ingresos
		case 'listar':
			$respuesta = $ingreso->listar();
			//declaramos una rray para por ahi mostrar los datos
			$data = Array();
			//recorrer cada fila
			while ($reg = $respuesta->fetch_object()) {
				$data[] = array(
					           "0"=>(($reg->estado=='Aceptado')?'<button class="btn btn-warning" onclick="mostrar('.$reg->idingreso.')"><i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-danger" onclick="anular('.$reg->idingreso.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idingreso.')"><i class="fa fa-eye"></i></button>').
 					'<a target="_blank" href="../reportes/exportarFacIngreso.php?id='.$reg->idingreso.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
					            "1"=>$reg->fecha,
					            "2"=>$reg->proveedor,
					            "3"=>$reg->usuario,
					            "4"=>$reg->tipo_comprobante,
					            "5"=>$reg->serie_comprobante,
					            "6"=>$reg->num_comprobante,
					            "7"=>$reg->total_compra,
					            "8"=>($reg->estado=='Aceptado') ? '<span class="label bg-green">Aceptado</span>':'<span class="label bg-red">Anulado</span>'
				               );
			}
			$results = array(
				"sEcho"=>1, // informacion para el detalle
				"iTotalRecords"=>count($data),//enviamos el totat de registros al detalle
				"iTotalDisplayRecords"=>count($data),//enviar el total de registros a visualizar
				"aaData"=>$data);
			    echo json_encode($results);
		break;
		//listar para selecionatr un proveedor en el ingreso
		case 'selectProveedor':
			require_once '../modelos/Persona.php';
			$persona = new Persona();

			$respuesta = $persona->listarProveedor();
			//listar los proveedore
			while ($reg = $respuesta->fetch_object()) {
				echo'<option value='. $reg->idpersona .'>'.$reg->nombre.'</option>';
			}
		break;
		//listar articulos en  la pantalla modal
		case 'listarArticulos':

		require_once '../modelos/Articulo.php';
		$articulo = new Articulo();
		$respuesta = $articulo->listarActivos();
			//declaramos una rray para por ahi mostrar los datos
			$data = Array();
			//recorrer cada fila
			while ($reg = $respuesta->fetch_object()) {
				$data[] = array(
					            "0"=>'<button class="btn btn-warning btn-sm" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->nombre.'\')"><i class="fa fa-plus"></i></button>',
					            "1"=>$reg->nombre,
					            "2"=>$reg->categoria,
					            "3"=>$reg->codigo,
					            "4"=>$reg->stock,
					            "5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'></img>"
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
}else{
	echo "error";
}

?>