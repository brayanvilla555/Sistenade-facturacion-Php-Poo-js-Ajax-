<?php
//incluimos la conecion a la base de datos
require_once "../config/Conexion.php";

class Tienda{
  //indicamos nuectro constructor
  public function __construct(){

  }

  //metodo para insertar registro
  public function insertar($nombre,$ruc,$direccion,$telefono,$email,$imagen,$rol){
    $sql = "INSERT INTO tienda(nombre,ruc,direccion,telefono,email,imagen,rol)
    VALUES ('$nombre','$ruc','$direccion','$telefono','$email', '$imagen','$rol')";
    return ejecutarConsulta($sql);
  }
  //metodo para editar los registros
  public function editar($idtienda,$nombre,$ruc,$direccion,$telefono,$email,$imagen,$rol){
    $sql = "UPDATE tienda SET nombre='$nombre'
                               ,ruc='$ruc'
                               ,direccion='$direccion'
                               ,telefono='$telefono'
                               ,email='$email'
                               ,imagen='$imagen'
                               ,rol='$rol'
    WHERE idtienda='$idtienda'";
    return ejecutarConsulta($sql);
  }
  //metodo para mostrar datos del registro de forma personalizada
  public function datosTienda(){
    $sql = "SELECT * FROM tienda";
    return ejecutarConsulta($sql);
  }
  //metodo para mostrar datos del registro de forma personalizada
  public function mostrar($idtienda){
    $sql = "SELECT * FROM tienda WHERE idtienda='$idtienda'";
    return ejecutarConsultaSimpleFila($sql);
  }
  //metodo para listar cliente
  public function listarTienda(){
    $sql = "SELECT * FROM tienda";
    return ejecutarConsulta($sql);
  }

  //metodo para desactivar tienda
  public function desactivar($idtienda){
    $sql = "UPDATE tienda SET condicion='0'
    WHERE idtienda='$idtienda'";
    return ejecutarConsulta($sql);

  }

  //metodo para activar tienda
  public function activar($idtienda){
    $sql = "UPDATE tienda SET condicion='1'
    WHERE idtienda='$idtienda'";
    return ejecutarConsulta($sql);
  }

}

 ?>