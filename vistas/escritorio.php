<?php
//activabos almacenaciemto en el buffer
ob_start();
session_start();?>

<?php if(!isset($_SESSION['nombre'])) ://iniciar la session de logeados?>
  <?php header("location:login.html");//requerimis el li¿ogin ?>
<?php else:?>
<?php require_once 'layout/header.php';//requerimos el header?>
<?php if(isset($_SESSION['escritorio'])&& $_SESSION['escritorio']==1)://iniciamos la concidion para limitar el acceso
//creo variables para sacar el monto de COMPRAS del dia de hoy
   require_once '../modelos/Consulta.php';
   $consulta = new Consulta();
   $respuestaCompras = $consulta->totalcomprahoy();
   $registroCompras = $respuestaCompras->fetch_object();
   $totalCompras = $registroCompras->total_compra;

//creo variables para sacar el monto de VENTAS del dia de hoy
   $respuestaVentas = $consulta->totalventahoy();
   $registroVentas = $respuestaVentas->fetch_object();
   $totalVentas = $registroVentas->total_venta;

//Datos para mostrar el grafico de barras
   $compras10 = $consulta->comprasultimos_10dias();
   $fechasCompras = '';
   $totalCompra = '';
//recorremos las fechas
   while ($regfechacompra = $compras10->fetch_object()) {
     $fechasCompras = $fechasCompras .'"'.$regfechacompra->fecha.'",';
     $totalCompra = $totalCompra  .$regfechacompra->total.',';
   }
//quitar la ultima como
  $fechasCompras = substr($fechasCompras, 0, -1);
  $totalCompra = substr($totalCompra, 0, -1);

   //Datos para mostrar el gráfico de barras de las ventas
  $ventas12 = $consulta->ventasultimos_12meses();
  $fechasv='';
  $totalesv='';
  while ($regfechav= $ventas12->fetch_object()) {
    $fechasv=$fechasv.'"'.$regfechav->fecha .'",';
    $totalesv=$totalesv.$regfechav->total .',';
  }

  //Quitamos la última coma
  $fechasv=substr($fechasv, 0, -1);
  $totalesv=substr($totalesv, 0, -1);
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Escritorio</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body" id="listadoregistros">
                      <!--Compas-->
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="small-box bg-aqua">
                          <div class="inner">
                            <h4 style="font-size:17px;">
                              <strong>S/.<?= $totalCompras?></strong>
                            </h4>
                            <p>Compras</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-bag"></i>
                          </div>
                          <a href="ingreso.php" class="small-box-footer">Compras<i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                      </div>
                      <!--Ventas-->
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="small-box bg-green">
                          <div class="inner">
                            <h4 style="font-size:17px;">
                              <strong>S/.<?= $totalVentas?></strong>
                            </h4>
                            <p>Ventas</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-bag"></i>
                          </div>
                          <a href="venta.php" class="small-box-footer">Compras<i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                      </div>
                    </div>
                    <!--panel 2-->
                    <div class="panel-body">
                      <!--grafico de las ultimos 10 dias de compras-->
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            COMPRAS DE LOS ULTIMOS 10 DIAS
                          </div>
                          <div class="box-body">
                            <canvas id="compras_diez_dias" style="width:400px;"></canvas>
                          </div>
                        </div>
                      </div>
                      <!--grafico de las ultimos 12 meses de ventas-->
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            Ventas de los ultimos 12 meses
                          </div>
                          <div class="box-body">
                            <canvas id="ventas_12meses" style="width:400px;"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php else: //else  if de la session $_SESSION['almacen']?>
  <?php require_once 'noacceso.php';?>
<?php endif;//fin del if de la session $_SESSION['almacen']?>
<?php require_once 'layout/footer.php';?>
<!--script type="text/javascript" src="scripts/graficos.js" ></script-->
<!--dependencias para los graficos-->
<script type="text/javascript" src="../public/js/Chart.min.js" ></script>
<script type="text/javascript" src="../public/js/Chart.bundle.min.js" ></script>
<script type="text/javascript">
var ctx = document.getElementById('compras_diez_dias').getContext('2d');
var compras = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?= $fechasCompras;?>],
        datasets: [{
            label: '# Compras en S/. de los ultimos 10 dias',
            data: [<?= $totalCompra;?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

var ctx = document.getElementById("ventas_12meses").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasv; ?>],
        datasets: [{
            label: 'Ventas en S/ de los últimos 12 Meses',
            data: [<?php echo $totalesv; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
</script>
<?php endif;?>
<?php ob_end_flush(); ?>


