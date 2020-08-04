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
    $pdf->Cell(100, 6, 'Reporte de ventas',1,0,'C');
    $pdf->Ln(10);

    //cramos las celdas para los titulos de cada columna y le asignamos un fondo de color gris y el tipo de letra
    $pdf->SetFillColor(232,232,232);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(21,6,'Fecha',1,0,'C',1);
    $pdf->Cell(48,6,'Usuario',1,0,'C',1);
    $pdf->Cell(51,6,'Cliente',1,0,'C',1);
    $pdf->Cell(25,6,'Documento',1,0,'C',1);
    $pdf->Cell(20,6,utf8_decode('Número'),1,0,'C',1);
    $pdf->Cell(20,6,'Total',1,0,'C',1);

    $pdf->Ln(10);
    //comensamos a crear las filas de los registros segun la consulta MYSQL
    require_once '../modelos/Venta.php';

    //creamos nuestrom objeto
    $venta = new Venta();

    $respuesta = $venta->listar();
    //anbcho de la tabla y columnas /impleentando los registros a mostrar
    $pdf->SetWidths(array(21,48,51,25,20,20));

    //recorremos las filas con el bucle while
    while($reg= $respuesta->fetch_object()){
      $fecha = $reg->fecha;
      $usuario = $reg->usuario;
      $cliente = $reg->cliente;
      $tipo_comprobante = $reg->tipo_comprobante;
      $num_comprobante = $reg->num_comprobante;
      $total_venta = $reg->total_venta;

      $pdf->SetFont('Arial','',10);
      $pdf->Row(array($fecha,utf8_decode($usuario),utf8_decode($cliente),$tipo_comprobante,$num_comprobante,$total_venta));
    }
    //ostraos el documento pdf
    $pdf->Output();

  }else{
    echo'No tiene permiso para visualizar el reporte';
  }//fin del if de la session $_SESSION['almacen']
}//serramos la session de login

ob_end_flush();
?>
