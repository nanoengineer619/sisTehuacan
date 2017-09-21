<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';

if ($_SESSION['compras']==1)
{
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
                          <h2 style="font-family:bold; text-align: center;">Gestión de departamentos</h2></br>
                          <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>
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
                            <th>Elemento</th>
                            <th>Cantidad</th>
                            <th>Potencia</th>
                            <th>P. Total</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Elemento</th>
                            <th>Cantidad</th>
                            <th>Potencia</th>
                            <th>P. Total</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Edificio(*):</label>
                            <input type="hidden" name="iddepartamento" id="iddepartamento">
                            <select id="idedificio" name="idedificio" class="form-control selectpicker" data-live-search="true" required>

                            </select>
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Nombre(*):</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" required="">
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Elemento(*):</label>
                              <input type="number" class="form-control" name="elemento" id="elemento" maxlength="7" placeholder="Serie">
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Cantidad:</label>
                            <input type="number" class="form-control" name="cantidad" id="cantidad" maxlength="7" placeholder="Serie">
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Potencia:</label>
                            <input type="number" class="form-control" name="potencia" id="potencia" maxlength="10" placeholder="Número" required="">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Pot.Total:</label>
                            <input type="number" class="form-control" name="potencia_total" id="potencia_total" required="">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Capacidad:</label>
                            <input type="number" class="form-control" name="capacidad" id="capacidad" required="">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Funcionando:</label>
                            <input type="number" class="form-control" name="funcionando" id="funcionando" required="">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Fundidas:</label>
                            <input type="number" class="form-control" name="fundidas" id="fundidas" required="">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Fecha:</label>
                            <input type="date" class="form-control" name="fecha_hora" id="fecha_hora" required="">
                          </div>
                          <div class="form-group col-lg-8 col-md-8 col-sm-6 col-xs-12">
                            <label>Descripción:</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" required=""></textarea>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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

<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/departamento.js"></script>
<?php
}
ob_end_flush();
?>
