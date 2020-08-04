<?php
//activabos almacenaciemto en el buffer
ob_start();
session_start();?>

<?php if(!isset($_SESSION['nombre'])) : //iniciar la session de logeados?>
  <?php header("location:login.html") ?>
<?php else:?>
<?php require_once 'layout/header.php';//requerimos el header?>

<?php if(isset($_SESSION['almacen'])&& $_SESSION['almacen']==1)://iniciamos la concidion para limitar el acceso?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Ariculo
                            <button class="btn btn-success" id="btnAgregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar
                            </button>
                            <a target="_blank" href="../reportes/reporteArticulos.php"><button class="btn btn-info"><i class="fa fa-file-pdf-o"></i>Reporte</button></a>
                          </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                      <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                              <th>Opcione</th>
                              <th>nombre</th>
                              <th>Categoria</th>
                              <th>Codigo</th>
                              <th>Stock</th>
                              <th>Imagen</th>
                              <th>Estado</th>
                          </thead>
                          <tbody>

                          </tbody>
                            <th>Opcione</th>
                              <th>nombre</th>
                              <th>Categoria</th>
                              <th>Codigo</th>
                              <th>Stock</th>
                              <th>Imagen</th>
                              <th>Estado</th>
                      </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">

                      <form name="fromulario" id="formulario" method="POST">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="nombre">Nombre:</label>
                          <input type="hidden" name="idarticulo" id="idarticulo">
                          <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="nombre" required/>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="categoria">Categoria:</label>
                          <select id="idcategoria" name="idcategoria" class="form-control selectpicker" data-live-search="true" required/>
                          </select>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="stock">Stock:</label>
                          <input type="number" class="form-control" name="stock" id="stock" required/>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="nombre">Descripcion:</label>
                          <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="256" placeholder="descripcion">
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="imagen">Imagen:</label>
                          <input type="file" class="form-control" name="imagen" id="imagen" />
                          <input type="hidden" name="imagenactual" id="imagenactual">
                          <img src="" width="150px" height="120px" id="imagenmuestra">
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="codigo">Codigo:</label>
                          <input type="text" class="form-control" name="codigo" id="codigo" placeholder="codigo" />
                          <button class="btn btn-success" type="button" onclick="generarbarcode()">Generar</button>
                          <button class="btn btn-warning" type="button" onclick="imprimir()">Imprmir</button>
                          <div id="print">
                            <svg id="barcode"></svg>
                          </div>
                        </div>

                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>Guardar</button>

                          <button class="btn btn-danger" onclick="canselarform()" type="button" ><i class="fa fa-arrow-circle-left"></i>Canselar</button>

                        </div>

                      </form>

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

<script type="text/javascript" src="../public/js/JsBarcode.all.min.js" ></script>
<script type="text/javascript" src="../public/js/jquery.PrintArea.js" ></script>
<script type="text/javascript" src="scripts/articulo.js" ></script>
<?php endif; //serramos la session de login?>
<?php ob_end_flush(); ?>

