<?php
//activabos almacenaciemto en el buffer
ob_start();
if (strlen(session_id()) < 1) {
	session_start();
}
 if (!isset($_SESSION['nombre']))//iniciar la session de logeados
 {
 	echo " Debe ingresar al sistema correctamente para visualizar el reporte";
 }else{
 	if (isset($_SESSION['ventas'])&& $_SESSION['ventas']==1) //iniciamos la concidion para limitar el acceso
 	{
 		//incluimos  a la clase PDF_MC_table
 		require_once 'PDF_MC_Table.php';

 		//instanciamos la clase para general el documentopdf
 		$pdf = new PDF_MC_Table();

 		//agregaos la primera pagina al documento
 		$pdf->AddPage();
 		//Seteamos el inicio del margen superio 25px;
 		$y_axis_initial = 25;

 		//seteamos el tipo de letra y creamos el titulo de la pagina /No es un encabesado no se repetira
 		$pdf->SetFont('Arial', 'B',12);

 		$pdf->Cell(40, 6, '', 0, 0, 'C');
 		$pdf->Cell(100, 6, 'LISTA DE CLIENTES',1,0,'C');
 		$pdf->Ln(10);

 		//cramos las celdas para los titulos de cada columna y le asignamos un fondo de color gris y el tipo de letra
 		$pdf->SetFillColor(232,232,232);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(60,6,utf8_decode('Nombre'),1,0,'C',1);
		$pdf->Cell(20,6,'Docuento',1,0,'C',1);
		$pdf->Cell(30,6,utf8_decode('N° Docuento'),1,0,'C',1);
		$pdf->Cell(30,6,'Telefono',1,0,'C',1);
		$pdf->Cell(50,6,utf8_decode('email'),1,0,'C',1);

		$pdf->Ln(10);
		//comensamos a crear las filas de los registros segun la consulta MYSQL
		require_once '../modelos/Persona.php';

		//creamos nuestrom objeto
		$cliente = new Persona();

		$respuesta = $cliente->listarCliente();
		//anbcho de la tabla y columnas /impleentando los registros a mostrar
		$pdf->SetWidths(array(60,20,30,30,50));

		//recorremos las filas con el bucle while
		while ($reg = $respuesta->fetch_object()) {
			$nombre = $reg->nombre;
			$documento = $reg->tipo_documento;
			$n_documento = $reg->num_documento;
			$telefono = $reg->telefono;
			$email = $reg->email;

			//declaramos el tipo de letra
			$pdf->SetFont('Arial','',10);
			$pdf->Row(array(utf8_decode($nombre),utf8_decode($documento),$n_documento,$telefono,utf8_decode($email)));
		}
		//ostraos el documento pdf
		$pdf->Output();

 	}else{
 		echo'No tiene permiso para visualizar el reporte';
 	}//fin del if de la session $_SESSION['almacen']
}//serramos la session de login

ob_end_flush();
?>
