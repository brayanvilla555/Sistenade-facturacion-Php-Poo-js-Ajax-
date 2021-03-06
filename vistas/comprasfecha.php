<?php
//activabos almacenaciemto en el buffer
ob_start();
session_start();?>

<?php if(!isset($_SESSION['nombre'])) ://iniciar la session de logeados?>
  <?php header("location:login.html");//requerimis el li¿ogin ?>
<?php else:?>
<?php require_once 'layout/header.php';//requerimos el header?>
<?php if(isset($_SESSION['consultaComp'])&& $_SESSION['consultaComp']==1)://iniciamos la concidion para limitar el acceso?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Consulta de compras por fecha</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                      <!--fecha de inicio--->
                      <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="fecha_inicio">Fecha inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?= date("Y-m-d")?>" required/>
                      </div>
                      <!--fecha de fin--->
                      <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="fecha_fin">Fecha fin</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?= date("Y-m-d")?>" required/>
                      </div>
                      <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                              <th>Fecha</th>
                              <th>Usuario</th>
                              <th>Proveedor</th>
                              <th>Coprobante</th>
                              <th>Número</th>
                              <th>TotalCompra</th>
                              <th>Impuesto</th>
                              <th>Estado</th>
                          </thead>
                          <tbody>

                          </tbody>
                            <tfoot>
                              <th>Fecha</th>
                              <th>Usuario</th>
                              <th>Proveedor</th>
                              <th>Coprobante</th>
                              <th>Número</th>
                              <th>TotalCompra</th>
                              <th>Impuesto</th>
                              <th>Estado</th>
                            </tfoot>
                      </table>
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
<script type="text/javascript" src="scripts/comprasfecha.js" ></script>
<?php endif;?>
<?php ob_end_flush(); ?>