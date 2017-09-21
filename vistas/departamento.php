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
                        <table id="tbldepartamento" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Edificio</th>
                            <th>Departamento</th>
                            <th>Elemento</th>
                            <th>Cantidad</th>
                            <th>Potencia</th>
                            <th>P. Total</th>
                            <th>Capacidad</th>
                            <th>Funcionando</th>
                            <th>Fundidos</th>
                            <th>Descripcion</th>
                            <th>Fecha</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Edificio</th>
                            <th>Departamento</th>
                            <th>Elemento</th>
                            <th>Cantidad</th>
                            <th>Potencia</th>
                            <th>P. Total</th>
                            <th>Capacidad</th>
                            <th>Funcionando</th>
                            <th>Fundidos</th>
                            <th>Descripcion</th>
                            <th>Fecha</th>
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
                            <label>Departamento(*)</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" required="" placeholder="Departamento">
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Elemento del Departamento(*)</label>
                              <input type="text" class="form-control"  name="elemento" id="elemento" maxlength="7" placeholder="Elemento">
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Numero de Elementos</label>
                            <input type="text" class="form-control" name="cantidad" onkeyup="calcular();" id="cantidad" maxlength="7" placeholder="Cantidad" value="">
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Potencia</label>
                            <input type="text" class="form-control" name="potencia" onkeyup="calcular();" id="potencia" maxlength="10" placeholder="Número" value="" required="">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Potencia Total</label>
                            <input type="text" class="form-control" name="potencia_total" id="potencia_total" value="" placeholder="Total">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Capacidad</label>
                            <input type="text" class="form-control" name="capacidad" maxlength="7" id="capacidad" required="">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Funcionando</label>
                            <input type="number" class="form-control" name="funcionando" id="funcionando" required="">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Fundidas</label>
                            <input type="number" class="form-control" name="fundidas" id="fundidas" required="">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Fecha</label>
                            <input type="text" class="form-control" name="fecha_hora" id="fecha_hora" required="" readonly="">
                          </div>
                          <div class="form-group col-lg-8 col-md-8 col-sm-6 col-xs-12">
                            <label>Descripción</label>
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