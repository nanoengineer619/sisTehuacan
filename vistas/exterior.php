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

if ($_SESSION['exterior']==1)
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
                        <table id="exterior" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Funcionando</th>
                            <th>P.Instalada(Watts)</th>
                            <th>Con.Semanal(KWh)</th>
                            <th>C.Mensual(Kwh)</th>
                            <th>C.Semestral(kwh)</th>
                            <th>Fecha</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Funcionando</th>
                            <th>P.Instalada(Watts)</th>
                            <th>Con.Semanal(KWh)</th>
                            <th>C.Mensual(Kwh)</th>
                            <th>C.Semestral(kwh)</th>
                            <th>Fecha</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Elemento(*):</label>
                            <select id="idelemento" name="idelemento" class="form-control selectpicker" data-live-search="true" required="">

                            </select>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Cantidad:</label>
                              <input type="text" class="form-control" name="cantidad" id="cantidad" maxlength="7" >
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                              <label>En Funcionamiento:</label>
                              <input type="text" class="form-control" name="funcionando" onchange="calcular();" on id="funcionando" >
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Potencia U/(Watts):</label>
                            <input type="text" class="form-control" name="potencia_unidad" onchange="calcular();" on id="potencia_unidad" maxlength="7" >
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>P.Instalada(Watts):</label>
                            <input type="text" class="form-control" name="instalada_watts"  id="instalada_watts" maxlength="10"  >
                          </div>
                          <!--Inicio de otra nueva fila-->
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Potencia instalada(Kw):</label>
                            <input type="text" class="form-control" name="instalada_kw" onchange="calcular();" id="instalada_kw" maxlength="7" >
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>T/Operación Semanal(Hrs):</label>
                            <input type="text" class="form-control" name="t_operacion_sem" onchange="calcular();" on id="t_operacion_sem" >
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Consumo Semana(Kwh):</label>
                            <input type="text" class="form-control" name="cons_semana" id="cons_semana" >
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>T/Operación Mensual(Hrs):</label>
                            <input type="text" class="form-control" name="t_op_mensual" id="t_op_mensual" >
                          </div>
                          <!--Inicio de otra nueva fila-->
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Consumo Mensual(Kwh):</label>
                            <input type="text" class="form-control" name="cons_mes" id="cons_mes" >
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Consumo Semestral(Kwh):</label>
                            <input type="text" class="form-control" name="cons_semestre" id="cons_semestre" maxlength="5" >
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Fundidas:</label>
                            <input type="text" class="form-control" name="fundidas" id="fundidas" >
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Fecha:</label>
                            <input type="date" class="form-control" name="fecha" id="fecha" >
                          </div>
                          <!--Inicio de otra nueva fila
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Descripción:</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" required=""></textarea>
                          </div> -->
                          <!--Inicio de otra nueva fila-->
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <button id="btnGuardar" class="btn btn-primary" type="submit" ><i class="fa fa-save"></i> Guardar</button>
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
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/exterior.js"></script>
<?php
}
ob_end_flush();
?>
