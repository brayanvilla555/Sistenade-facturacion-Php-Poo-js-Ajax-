<?php
//activabos almacenaciemto en el buffer
ob_start();
session_start();?>

<?php if(!isset($_SESSION['nombre'])) :?>
  <?php header("location:login.html") ?>
<?php else:?>
<?php require_once 'layout/header.php';?>

<?php require_once 'layout/header.php';//requerimos el header?>
<?php if(isset($_SESSION['acceso'])&& $_SESSION['acceso']==1)://iniciamos la concidion para limitar el acceso?>

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Permiso<button class="btn btn-success" id="btnAgregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                      <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                              <th>nombre</th>
                          </thead>
                          <tbody>

                          </tbody>
                            <th>Nombre</th>
                      </table>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php require_once 'layout/footer.php';?>

<?php else: //else  if de la session $_SESSION['almacen']?>
  <?php require_once 'noacceso.php';?>
<?php endif;//fin del if de la session $_SESSION['almacen']?>

<script type="text/javascript" src="scripts/permiso.js" ></script>
<?php endif;?>
<?php ob_end_flush(); ?>


