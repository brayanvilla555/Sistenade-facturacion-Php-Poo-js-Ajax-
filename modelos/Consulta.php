<?php
//incluimos la conecion a la base de datos
require_once "../config/Conexion.php";

class Consulta{
	//indicamos nuectro constructor
	public function __construct(){

	}

	//metodo para listrar algunas compras filtrando a traves de la fecha ... entre dos fechas
	public function comprasfecha($fecha_inicio, $fecha_fin){
		$sql="SELECT DATE(i.fecha_hora) as fecha,
		                 u.nombre as usuario,
		                 p.nombre as proveedor,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM ingreso i
		                 INNER JOIN persona p ON i.idproveedor=p.idpersona
		                 INNER JOIN usuario u ON i.idusuario=u.idusuario
		                 WHERE DATE(i.fecha_hora)>='$fecha_inicio' AND DATE(i.fecha_hora)<='$fecha_fin'";
		return ejecutarConsulta($sql);
	}

	//metodo para listrar algunas ventas filtrando a traves de la fecha ... entre dos fechas
	public function ventasfechacliente($fecha_inicio, $fecha_fin,$idcliente){
		$sql="SELECT DATE(v.fecha_hora) as fecha,
		                  u.nombre as usuario,
		                  p.nombre as cliente,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v
		                  INNER JOIN persona p ON v.idcliente=p.idpersona
		                  INNER JOIN usuario u ON v.idusuario=u.idusuario
		                  WHERE DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.idcliente='$idcliente'";
		return ejecutarConsulta($sql);
	}
	//metodo para hacer una consulta del total de COMPRAS del dia de hoy
	public function totalcomprahoy(){
		$sql = "SELECT IFNULL(SUM(total_compra),0)AS total_compra FROM ingreso WHERE DATE(fecha_hora) = CURDATE()";
		return ejecutarConsulta($sql);
	}

	//metodo para hacer una consulta del total de VENTAS del dia de hoy
	public function totalventahoy(){
		$sql = "SELECT IFNULL(SUM(total_venta),0)AS total_venta FROM venta WHERE DATE(fecha_hora) = CURDATE()";
		return ejecutarConsulta($sql);
	}

	//metodo para hacer una consulta del total de las COMPSAS DE LOS ULTIMOS 10 DIAS
	public function comprasultimos_10dias(){
		$sql="SELECT CONCAT(DAY(fecha_hora),'-',MONTH(fecha_hora)) AS fecha,
		SUM(total_compra) AS total
		FROM ingreso GROUP by fecha_hora ORDER BY fecha_hora DESC LIMIT 0,10";
		return ejecutarConsulta($sql);
	}

	//metodo para hacer una consulta del total de las COMPSAS DE LOS ULTIMOS 12 Meses
	public function ventasultimos_12meses(){
		$sql="SELECT DATE_FORMAT(fecha_hora,'%M')AS fecha,
		SUM(total_venta) AS total
		FROM venta GROUP BY MONTH(fecha_hora) ORDER BY fecha_hora DESC LIMIT 0,12";
		return ejecutarConsulta($sql);
	}
}

 ?>