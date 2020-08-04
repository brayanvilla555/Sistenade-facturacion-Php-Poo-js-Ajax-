<?php
//incluimos la conecion a la base de datos
require_once "../config/Conexion.php";

class Permiso{
	//indicamos nuectro constructor
	public function __construct(){

	}

	//metodo para listar los regitros
	public function listar(){
		$sql = "SELECT * FROM permiso";
		return ejecutarConsulta($sql);
	}



}

 ?>