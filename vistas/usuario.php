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
                              <th>Opcione</th>
                              <th>nombre</th>
                              <th>Documento</th>
                              <th>N° Documento</th>
                              <th>Telefono</th>
                              <th>Email</th>
                              <th>login</th>
                              <th>Foto</th>
                              <th>Condicion</th>
                          </thead>
                          <tbody>

                          </tbody>
                              <th>Opcione</th>
                              <th>nombre</th>
                              <th>Documento</th>
                              <th>N° Documento</th>
                              <th>Telefono</th>
                              <th>Email</th>
                              <th>login</th>
                              <th>Foto</th>
                              <th>Condicion</th>
                      </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">

                      <form name="fromulario" id="formulario" method="POST">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <label for="nombre">Nombre:</label>
                          <input type="hidden" name="idusuario" id="idusuario">
                          <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required/>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="tipo_documento">Tipo documento:</label>
                          <select class="form-control selectpicker" name="tipo_documento" id="tipo_documento" required>
                            <option value="DNI">DNI</option>
                            <option value="RUC">RUC</option>
                            <option value="CEDULA">CEDULA</option>
                          </select>
                        </div>


                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="num_documento">N° de documento:</label>
                          <input type="number" class="form-control" name="num_documento" id="num_documento" maxlength="20" placeholder="Numero de documento" required/>
                          </select>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="direccion">Direccion:</label>
                          <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Direccion" maxlength="70" />
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="telefono">Telefono:</label>
                          <input type="number" class="form-control" name="telefono" id="telefono" maxlength="20" placeholder="telefono">
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="email">Email:</label>
                          <input type="email" class="form-control" name="email" id="email" maxlength="70" placeholder="Email">
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="cargo">Cargo:</label>
                          <input type="text" class="form-control" name="cargo" id="cargo" maxlength="20" placeholder="Cargo">
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="login">Login:</label>
                          <input type="text" class="form-control" name="login" id="login" maxlength="20" placeholder="Login" required/>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="clave">Clave:</label>
                          <input type="pasword" class="form-control" name="clave" id="clave" maxlength="20" placeholder="Clave" required/>
                        </div>
                        <!--LISTADO DE TODOS LOS PERMISOS---->
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="imagen">Permisos:</label>
                          <ul style="list-style: none" id="permisos" name="permisos" >

                          </ul>
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

<script type="text/javascript" src="scripts/usuario.js" ></script>
<?php endif; //fin del if del inicio de session?>
<?php ob_end_flush(); ?>



