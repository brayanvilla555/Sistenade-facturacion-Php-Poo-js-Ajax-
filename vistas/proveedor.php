<?php
//activabos almacenaciemto en el buffer
ob_start();
session_start();?>

<?php if(!isset($_SESSION['nombre'])) ://iniciar session de logeado?>
  <?php header("location:login.html") ?>
<?php else:?>

<?php require_once 'layout/header.php';//requerimos el header?>
<?php if(isset($_SESSION['compras'])&& $_SESSION['compras']==1)://iniciamos la concidion para limitar el acceso?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Proveedor
                            <button class="btn btn-success" id="btnAgregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>
                            <a target="_blanck" href="../reportes/reporteProveedor.php"><button class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Reporte</button></a>
                          </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                      <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                              <th>Opciones</th>
                              <th>nombre</th>
                              <th>Documento</th>
                              <th>N° documeto</th>
                              <th>Teléfono</th>
                              <th>Email</th>
                          </thead>
                          <tbody>

                          </tbody>
                              <th>Opciones</th>
                              <th>nombre</th>
                              <th>Documento</th>
                              <th>N° documeto</th>
                              <th>Teléfono</th>
                              <th>Email</th>
                      </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">

                      <form name="fromulario" id="formulario" method="POST">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="nombre">Nombre:</label>
                          <input type="hidden" name="idpersona" id="idpersona">
                          <input type="hidden" name="tipo_persona" id="tipo_persona" value="Proveedor">
                          <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required/>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="tipo_documento">Tipo de documento:</label>
                          <select class="form-control select-picker" name="tipo_documento" id="tipo_documento" requered/>
                            <option value="DNI">DNI</option>
                            <option value="RUC">RUC</option>
                            <option value="CEDULA">CEDULA</option>
                          </select>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="num_documento">Numero de documento:</label>
                          <input class="form-control" type="number" name="num_documento" id="num_documento" maxlength="20" placeholder="N° Documento" requered/>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="telefono">Telefono:</label>
                          <input class="form-control" type="text" name="telefono" id="telefono" maxlength="20"placeholder="Telefono" />
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label for="email">Email:</label>
                          <input class="form-control" type="email" name="email" id="email" maxlength="20"placeholder="Email" />
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

<script type="text/javascript" src="scripts/proveedor.js" ></script>
<?php endif;//serramos la session de login?>
<?php ob_end_flush(); ?>



