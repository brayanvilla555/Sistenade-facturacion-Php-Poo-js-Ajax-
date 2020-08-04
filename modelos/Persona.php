<?php
//incluimos la conecion a la base de datos
require_once "../config/Conexion.php";

class Persona{
	//indicamos nuectro constructor
	public function __construct(){

	}

	//metodo para insertar registro
	public function insertar($tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email){
		$sql = "INSERT INTO persona(tipo_persona,nombre,tipo_documento,num_documento,direccion,telefono,email)
		VALUES ('$tipo_persona','$nombre', '$tipo_documento', '$num_documento','$direccion','$telefono','$email')";
		return ejecutarConsulta($sql);
	}

	//metodo para editar los registros
	public function editar($idpersona,$tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email){
		$sql = "UPDATE persona SET tipo_persona='$tipo_persona'
		                           ,nombre='$nombre'
		                           ,tipo_documento='$tipo_documento'
		                           ,num_documento='$num_documento'
		                           ,direccion='$direccion'
		                           ,telefono='$telefono'
		                           ,email='$email'
		WHERE idpersona='$idpersona'";
		return ejecutarConsulta($sql);
	}
	//metodo para eleminar regisros
	public function eleminar($idpersona){
		$sql = "DELETE FROM persona WHERE idpersona='$idpersona'";
		return ejecutarConsulta($sql);

	}
	//metodo para mostrar datos del registro de forma personalizada
	public function mostrar($idpersona){
		$sql = "SELECT * FROM persona WHERE idpersona='$idpersona'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//metodo para listar proveedor
	public function listarProveedor(){
		$sql = "SELECT * FROM persona WHERE tipo_persona='Proveedor'";
		return ejecutarConsulta($sql);
	}

	//metodo para listar cliente
	public function listarCliente(){
		$sql = "SELECT * FROM persona WHERE tipo_persona='Cliente'";
		return ejecutarConsulta($sql);
	}


}

 ?>