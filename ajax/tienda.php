<?php
require_once '../modelos/tienda.php';

  $tienda = new Tienda();

  $idtienda = isset($_POST['idtienda'])? limpiarCadena($_POST['idtienda']) : "";
  $nombre = isset($_POST['nombre'])? limpiarCadena($_POST['nombre']) : "";
  $ruc = isset($_POST['ruc'])? limpiarCadena($_POST['ruc']) : "";
  $direccion = isset($_POST['direccion'])? limpiarCadena($_POST['direccion']) : "";
  $telefono = isset($_POST['telefono'])? limpiarCadena($_POST['telefono']) : "";
  $email = isset($_POST['email'])? limpiarCadena($_POST['email']) : "";
  $imagen = isset($_POST['imagen'])? limpiarCadena($_POST['imagen']) : "";
  $rol = isset($_POST['rol'])? limpiarCadena($_POST['rol']) : "";

  switch ($_GET["op"]) {
    case 'guardaryeditar':
    if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
      $imagen = $_POST['imagenactual'];
    }else{
      $extension = explode(".", $_FILES['imagen']['name']);
      $type_img = $_FILES['imagen']['type'];
      if ($type_img == "image/jpg" || $type_img == "image/jpeg" || $type_img == "image/png" || $type_img == "image/gif") {

        /*if(!is_dir('files/articulos')){
          mkdir('files/articulos', 0777, true);
        }*/
        $imagen = round(microtime(true)) . '.' . end($extension);
        move_uploaded_file($_FILES['imagen']['tmp_name'], "../files/tienda/". $imagen);
      }
    }
    if (empty($idtienda)) {
      $respuesta = $tienda->insertar($nombre,$ruc,$direccion,$telefono,$email,$imagen,$rol);
      echo $respuesta ? "Tienda registrada" : "No se pudo registrar la tienda";
    }else{
      $respuesta = $tienda->editar($idtienda,$nombre,$ruc,$direccion,$telefono,$email,$imagen,$rol);
      echo $respuesta ? "Tienda actualizada" : "No se pudo actualizar la tienda";
    }
    break;
    case 'desactivar':
      $respuesta =$tienda->desactivar($idtienda);
      echo $respuesta ? "Tienda o sucursal desactivada" : "Tienda o sucursal no se pudo desactivar";
    break;
    case 'activar':
      $respuesta =$tienda->activar($idtienda);
      echo $respuesta ? "Tienda o sucursal activada" : "Tienda o sucursal no se pudo activar";
    break;
    case 'mostrar':
      $respuesta = $tienda->mostrar($idtienda);
      //codificar el resultado utilizando json
      echo json_encode($respuesta);
    break;
    case 'listar':
      $respuesta = $tienda->listarTienda();
      //declaramos una rray para por ahi mostrar los datos
      $data = Array();
      //recorrer cada fila
      while ($reg = $respuesta->fetch_object()) {
        $data[] = array(
                      "0"=>($reg->condicion) ? '<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idtienda.')"><i class="fa fa-pencil"></i></button>'.
                      ' <button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->idtienda.')"><i class="fa fa-close"></i></button>' :
                      '<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idtienda.')"><i class="fa fa-pencil"></i></button>'.
                      ' <button class="btn btn-primary btn-sm" onclick="activar('.$reg->idtienda.')"><i class="fa fa-check"></i></button>',
                      "1"=>$reg->nombre,
                      "2"=>$reg->ruc,
                      "3"=>$reg->direccion,
                      "4"=>$reg->telefono,
                      "5"=>$reg->email,
                      "6"=>"<img src='../files/tienda/".$reg->imagen."' height='50px' width='50px'></img>",
                      "7"=>($reg->rol == 1) ? '<span class="label bg-orange">Tienda</span>' :'<span class="label bg-black">Sucursal</span>',
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

  }

?>