<?php
session_start();
require_once '../modelos/Usuario.php';

	$usuario = new Usuario();

	$idusuario = isset($_POST['idusuario'])? limpiarCadena($_POST['idusuario']) : "";
	$nombre = isset($_POST['nombre'])? limpiarCadena($_POST['nombre']) : "";
	$tipo_documento = isset($_POST['tipo_documento'])? limpiarCadena($_POST['tipo_documento']) : "";
	$num_documento = isset($_POST['num_documento'])? limpiarCadena($_POST['num_documento']) : "";
	$direccion = isset($_POST['direccion'])? limpiarCadena($_POST['direccion']) : "";
	$telefono = isset($_POST['telefono'])? limpiarCadena($_POST['telefono']) : "";
	$email = isset($_POST['email'])? limpiarCadena($_POST['email']) : "";
	$cargo = isset($_POST['cargo'])? limpiarCadena($_POST['cargo']) : "";
	$login = isset($_POST['login'])? limpiarCadena($_POST['login']) : "";
	$clave = isset($_POST['clave'])? limpiarCadena($_POST['clave']) : "";
	$imagen = isset($_POST['imagen'])? limpiarCadena($_POST['imagen']) : "";

	switch ($_GET["op"]) {
		case 'guardaryeditar':
		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
			$imagen = $_POST['imagenactual'];
		}else{
			$extension = explode(".", $_FILES['imagen']['tmp_name']);
			$type_img = $_FILES['imagen']['type'];
			if ($type_img == "image/jpg" || $type_img == "image/jpeg" || $type_img == "image/png" || $type_img == "image/gif") {
				$imagen = round(microtime(true)) . '.' . end($extension);
				move_uploaded_file($_FILES['imagen']['tmp_name'], "../files/usuarios/". $imagen);
			}
		}
		//encritar contraseña con  hash sha256
		$clavehash = hash("SHA256", $clave);

		if (empty($idusuario)) {
			$respuesta = $usuario->insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);
			echo $respuesta ? "Usuario registrada" : "No se pudieron registrar todos los datos del usuario";
		}else{
			$respuesta = $usuario->editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);
			echo $respuesta ? "Usuario actualizada" : "Usuario no se pudo actualizar";
		}
		break;
		case 'desactivar':
			$respuesta =$usuario->desactivar($idusuario);
			echo $respuesta ? "Usuario desactivado" : "Usuario no se pudo desactivar";
		break;
		case 'activar':
			$respuesta =$usuario->activar($idusuario);
			echo $respuesta ? "Usuario activado" : "Usuario no se pudo activar";
		break;
		case 'mostrar':
			$respuesta = $usuario->mostrar($idusuario);
			//codificar el resultado utilizando json
			echo json_encode($respuesta);
		break;
		case 'listar':
			$respuesta = $usuario->listar();
			//declaramos una rray para por ahi mostrar los datos
			$data = Array();
			//recorrer cada fila
			while ($reg = $respuesta->fetch_object()) {
				$data[] = array(
					            "0"=>($reg->condicion) ? '<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
					            ' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idusuario.')"><i class="fa fa-close"></i></button>' :
					            '<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
					            ' <button class="btn btn-primary btn-sm" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>',
					            "1"=>$reg->nombre,
					            "2"=>$reg->tipo_documento,
					            "3"=>$reg->num_documento,
					            "4"=>$reg->telefono,
					            "5"=>$reg->email,
					            "6"=>$reg->login,
					            "7"=>"<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px'></img>",
					            "8"=>($reg->condicion) ? '<span class="label bg-green">activado</span>' :'<span class="label bg-red">Desactivado</span>'
				               );
			}
			$results = array(
				"sEcho"=>1, // informacion para el detalle
				"iTotalRecords"=>count($data),//enviamos el totat de registros al detalle
				"iTotalDisplayRecords"=>count($data),//enviar el total de registros a visualizar
				"aaData"=>$data);
			    echo json_encode($results);
		break;
		case 'permisos':
			// obtener todos los permisos de ta tabla permisos
		require_once '../modelos/Permiso.php';
		$permiso = new Permiso();
		$respuesta = $permiso->listar();

		//optener los permisos marcados
		$id = $_GET['id'];
		$marcados = $usuario->listarMarcados($id);
		//arary para almacenar todos los permisos marcados
		$valores = array();
		if (!empty($id)) {
			//almacenar permisos signados en el array
			while ($per = $marcados->fetch_object()) {
				array_push($valores, $per->idpermiso);
			}
		}


		//mostramos todos los permisos
		while ($reg = $respuesta->fetch_object()) {
			$sw = in_array($reg->idpermiso, $valores) ? 'checked' : '';
			echo '<li> <input type="checkbox" '.$sw.' name="permiso[]" value="'.$reg->idpermiso.'"/>'.$reg->nombre.'</li>';
		}
		break;
		case 'verificar':
			$logina=$_POST['logina'];
		    $clavea=$_POST['clavea'];

		    //Hash SHA256 en la contraseña
			$clavehash=hash("SHA256",$clavea);

			$rspta=$usuario->verificar($logina, $clavehash);

			$fetch=$rspta->fetch_object();

			if (isset($fetch))
		    {
		        //Declaramos las variables de sesión
		        $_SESSION['idusuario']=$fetch->idusuario;
		        $_SESSION['nombre']=$fetch->nombre;
		        $_SESSION['imagen']=$fetch->imagen;
		        $_SESSION['login']=$fetch->login;

		        //Obtenemos los permisos del usuario
		    	$marcados = $usuario->listarmarcados($fetch->idusuario);

		    	//declaramos un array para almacenar todos los permisos
		    	$valores = array();

		    	//almacenamos los permisos marcados en el array
		    	while ($per = $marcados->fetch_object()) {
		    		array_push($valores, $per->idpermiso);
		    	}

		    	//definimos los accesos del usuario
		    	in_array(1, $valores)? $_SESSION['escritorio']=1 : $_SESSION['escritorio']=0;
		    	in_array(2, $valores)?$_SESSION['almacen']=1 : $_SESSION['almacen'] =0;
		    	in_array(3, $valores)?$_SESSION['compras']=1 : $_SESSION['compras'] =0;
		    	in_array(4, $valores)?$_SESSION['ventas']=1 : $_SESSION['ventas'] =0;
		    	in_array(5, $valores)?$_SESSION['acceso']=1 : $_SESSION['acceso'] =0;
		    	in_array(6, $valores)?$_SESSION['consultaComp']=1 : $_SESSION['consultaComp'] =0;
		    	in_array(7, $valores)?$_SESSION['consultaVent']=1 : $_SESSION['consultaVent'] =0;

		    }
		    echo json_encode($fetch);
		break;
		case 'salir':
			//limpiamos las sessiones
			session_unset();
			//destruimos la sesiom
			session_destroy();
			//redireccionamos
			header("location: ../index.php");
		break;

	}

?>