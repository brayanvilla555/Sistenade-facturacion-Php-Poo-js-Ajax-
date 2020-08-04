<?php
//incluimos la conecion a la base de datos
require_once "../config/Conexion.php";

class Usuario{
	//indicamos nuectro constructor
	public function __construct(){

	}

	//metodo para insertar registro
	public function insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$permisos){
		$sql = "INSERT INTO usuario( nombre,tipo_documento,num_documento,direccion,telefono,email,cargo,login,clave,imagen,condicion)
		VALUES ('$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email','$cargo','$login','$clave','$imagen','1')";
		//return ejecutarConsulta($sql);
		$idusuarionew = ejecutarConsulta_retornarID($sql);

		$num_elementos = 0;
		$sw = true;

		while ($num_elementos < count($permisos)) {
			$sql_detalle = "INSERT INTO usuario_permiso(idusuario,idpermiso) VALUES('$idusuarionew','$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;

			$num_elementos += 1;
		}
		return $sw;
	}

	//metodo para editar los registros
	public function editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$permisos){
		$sql = "UPDATE usuario SET nombre='$nombre',tipo_documento='$tipo_documento',num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email',cargo='$cargo',login='$login',clave='$clave',imagen='$imagen'WHERE idusuario='$idusuario'";
		ejecutarConsulta($sql);

		//eliminar ermisos asignados para volverlos a guaradars
		$sqldel = "DELETE FROM usuario_permiso WHERE idusuario = $idusuario";
		ejecutarConsulta($sqldel);
		//guardar los nuevos registros
		$num_elementos = 0;
		$sw = true;

		while ($num_elementos < count($permisos)) {
			$sql_detalle = "INSERT INTO usuario_permiso(idusuario,idpermiso) VALUES('$idusuario','$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos += 1;
		}
		return $sw;
	}
	//metodo para desactivar categorias
	public function desactivar($idusuario){
		$sql = "UPDATE usuario SET condicion='0'
		WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);

	}

	//metodo para activar categorias
	public function activar($idusuario){
		$sql = "UPDATE usuario SET condicion='1'
		WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//metodo para mostrar datos del registro de forma personalizada
	public function mostrar($idusuario){
		$sql = "SELECT * FROM usuario WHERE idusuario='$idusuario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//metodo para listar los regitros
	public function listar(){
		$sql = "SELECT * FROM usuario ORDER BY idusuario DESC";
		return ejecutarConsulta($sql);
	}

	//listra permisos marcados
	public function listarMarcados($idusuario){
		$sql = "SELECT * FROM usuario_permiso WHERE idusuario = $idusuario";
		return ejecutarConsulta($sql);
	}

	//funcion verificar el acceso al sistema
	public function verificar($login,$clave)
    {
    	$sql="SELECT idusuario,nombre,tipo_documento,num_documento,telefono,email,cargo,imagen,login FROM usuario WHERE login='$login' AND clave='$clave' AND condicion='1'";
    	return ejecutarConsulta($sql);
    }

}

 ?>