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
                        <h2 style="font-family:bold; text-align: center;">Gestión de Iluminaria exterior</h2></br>
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
                            <th>Edificio</th>
                            <th>Consumo Semanal</th>
                            <th>Consumo Mensual</th>
                            <th>Consumo semestral</th>
                            <th>Total</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                           <th>Opciones</th>
                            <th>Edificio</th>
                            <th>Consumo Semanal</th>
                            <th>Consumo Mensual</th>
                            <th>Consumo semestral</th>
                            <th>Total</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Nombre(*):</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" required="">
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Cantidad:</label>
                              <input type="number" class="form-control" name="cantidad" id="cantidad" maxlength="7" >
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Potencia:</label>
                            <input type="number" class="form-control" name="potencia" id="potencia" maxlength="7" >
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Potencia total:</label>
                            <input type="number" class="form-control" name="potencia_total" id="potencia_total" maxlength="7" >
                          </div>
                            <!--Inicio de otra nueva fila-->
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Capacidad:</label>
                            <input type="number" class="form-control" name="capacidad" id="capacidad" maxlength="10"  required="">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Tiempo de Operación:</label>
                            <input type="number" class="form-control" name="tiempo_operacion" id="tiempo_operacion" required="">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Consumo:</label>
                            <input type="number" class="form-control" name="consumo" id="consumo" required="">
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
                            <input type="date" class="form-control" name="fecha" id="fecha" required="">
                          </div>
                          <!--Inicio de otra nueva fila-->
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Descripción:</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" required=""></textarea>
                          </div>
                          <!--Inicio de otra nueva fila-->
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <button id="btnGuarda" class="btn btn-primary" type="submit" ><i class="fa fa-save"></i> Guardar</button>
                          </div>
                          <!--Inicio de otra nueva fila-->
                          <div class="form-group col-lg-1 col-md-1 col-sm-6 col-xs-12">
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

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un Artículo</h4>
        </div>
        <div class="modal-body">
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Código</th>
                <th>Stock</th>
                <th>Imagen</th>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
              <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Código</th>
                <th>Stock</th>
                <th>Imagen</th>
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Fin modal -->
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/ingreso.js"></script>
<?php
}
ob_end_flush();
?>
