<?php
//incluimos la conecion a la base de datos
require_once "../config/Conexion.php";

class Ingreso{
	//indicamos nuectro constructor
	public function __construct(){

	}

	//metodo para insertar registro
	public function insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$idarticulo,$cantidad,$precio_compra,$precio_venta){
		$sql = "INSERT INTO ingreso (idproveedor,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_compra,estado)
		VALUES ('$idproveedor','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_compra','Aceptado')";
		//return ejecutarConsulta($sql);
		$idingresonew = ejecutarConsulta_retornarID($sql);

		$num_elementos = 0;
		$sw = true;

		while ($num_elementos < count($idarticulo)) {
			$sql_detalle = "INSERT INTO detalle_ingreso(idingreso, idarticulo, cantidad, precio_compra,precio_venta) VALUES('$idingresonew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]', $precio_venta[$num_elementos])";
			ejecutarConsulta($sql_detalle) or $sw = false;

			$num_elementos += 1;
		}
		return $sw;
	}

	//metodo para desactivar categorias
	public function anular($idingreso){
		$sql = "UPDATE ingreso SET Estado='Anulado'
		WHERE idingreso='$idingreso'";
		return ejecutarConsulta($sql);

	}

	//metodo para mostrar datos del registro de forma personalizada
	public function mostrar($idingreso){
		$sql = "SELECT i.idingreso, DATE(i.fecha_hora) AS fecha,
		               i.idproveedor, p.nombre AS proveedor,
		               u.idusuario, u.nombre AS usuario,
		               i.tipo_comprobante,i.serie_comprobante, i.num_comprobante,i.total_compra,i.impuesto,i.estado
		                FROM ingreso i
		         INNER JOIN persona p ON i.idproveedor = p.idpersona
		         INNER JOIN  usuario u ON i.idusuario = u.idusuario
		         WHERE i.idingreso='$idingreso'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//mostrar los detalles del ingreso
	public function listarDetalle($idingreso){
		$sql = "SELECT di.idingreso,di.idarticulo,ar.nombre,di.cantidad,di.precio_compra,di.precio_venta
		               FROM detalle_ingreso di
		               INNER JOIN articulo ar
		               ON di.idarticulo = ar.idarticulo
		               WHERE di.idingreso = '$idingreso'
		               ";
		return ejecutarConsulta($sql);
	}

	//metodo para listar los regitros
	public function listar(){
		$sql = "SELECT i.idingreso, DATE(i.fecha_hora) AS fecha,
		               i.idproveedor, p.nombre AS proveedor,
		               u.idusuario, u.nombre AS usuario,
		               i.tipo_comprobante,i.serie_comprobante, i.num_comprobante,i.total_compra,i.impuesto,i.estado
		                FROM ingreso i
		         INNER JOIN persona p ON i.idproveedor = p.idpersona
		         INNER JOIN  usuario u ON i.idusuario = u.idusuario ORDER BY i.idingreso DESC";
		return ejecutarConsulta($sql);
	}

	//cavesera d la factura de ingresos
	public function ingresocabecera($idingreso){
		$sql="SELECT i.idingreso,i.idproveedor,p.nombre AS proveedor,
		p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,i.idusuario,u.nombre AS usuario,
		i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,date(i.fecha_hora) AS fecha,
		i.impuesto,i.total_compra FROM ingreso i
		INNER JOIN persona p ON i.idproveedor=p.idpersona
		INNER JOIN usuario u ON i.idusuario=u.idusuario
		WHERE i.idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}
	//detalle del ingreso
	public function ingresodetalle($idingreso){
		$sql="SELECT a.nombre AS articulo,
		a.codigo,d.cantidad,d.precio_compra,d.precio_venta,(d.cantidad*d.precio_compra) AS subtotal
		FROM detalle_ingreso d
		INNER JOIN articulo a ON d.idarticulo=a.idarticulo
		WHERE d.idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}

}

 ?>