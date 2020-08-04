<?php
//activabos almacenaciemto en el buffer
ob_start();
session_start();?>

<?php if(!isset($_SESSION['nombre'])) :?>
  <?php header("location:login.html") ?>
<?php else:?>
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
                          <h1 class="box-title">Usuarios<button class="btn btn-success" id="btnAgregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                      <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                              <th>Opciones</th>
                              <th>Nombre</th>
                              <th>RUC</th>
                              <th>Dirección</th>
                              <th>Telefono</th>
                              <th>Email</th>
                              <th>Imagen</th>
                              <th>Rol</th>
                              <th>Estado</th>
                          </thead>
                          <tbody>

                          </tbody>
                          <th>Nombre</th>
                              <th>Opciones</th>
                              <th>RUC</th>
                              <th>Dirección</th>
                              <th>Telefono</th>
                              <th>Email</th>
                              <th>Imagen</th>
                              <th>Rol</th>
                              <th>Estado</th>
                      </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                      <form name="fromulario" id="formulario" method="POST">

                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <label for="nombre">Nombre:</label>
                          <input type="hidden" name="idtienda" id="idtienda">
                          <input type="text" class="form-control" name="nombre" id="nombre" maxlength="256" placeholder="Nombre" required/>
                        </div>

                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                          <label for="Ruc">Ruc:</label>
                          <input type="number" class="form-control" name="ruc" id="ruc" maxlength="11" placeholder="Ruc" required/>
                        </div>

                        <div class="form-group col-lg-8 col-md-8 col-sm-6 col-xs-12">
                          <label for="Direccion">Direccion:</label>
                          <input type="text" class="form-control" name="direccion" id="direccion" maxlength="11" placeholder="Direccion" required/>
                        </div>

                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                          <label for="Telefono">Telefono:</label>
                          <input type="number" class="form-control" name="telefono" id="telefono" maxlength="11" placeholder="Telefono" required/>
                        </div>

                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                          <label for="Email">Email:</label>
                          <input type="emaail" class="form-control" name="email" id="email" maxlength="70" placeholder="Email" required/>
                        </div>

                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                          <label for="rol">Rol:</label>
                          <select class="form-control selectpicker" name="rol" id="rol" required>
                            <option value="1">Tienda</option>
                            <option value="2">Sucursal</option>
                          </select>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="imagen">Imagen:</label>
                          <input type="file" class="form-control" name="imagen" id="imagen" />
                          <input type="hidden" name="imagenactual" id="imagenactual">
                          <img src="" width="150px" height="120px" id="imagenmuestra">
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

<script type="text/javascript" src="scripts/tienda.js" ></script>
<?php endif; //fin del if del inicio de session?>
<?php ob_end_flush(); ?>



