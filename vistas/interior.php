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
                          <h2 style="font-family:bold; text-align: center;">Gestión de Iluminaria interior</h2></br>
                          <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>
                          <div class="box-tools pull-right">
                          </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistadoedificio" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Edificio</th>
                            <th>Consumo Semanal</th>
                            <th>Consumo Mensual</th>
                            <th>Consumo Semestral</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Edificio</th>
                            <th>Consumo Semanal</th>
                            <th>Consumo Mensual</th>
                            <th>Consumo Semestral</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Edificio</label>
                            <input type="hidden" name="idedificio" id="idedificio">
                            <input type="text" class="form-control" readonly="" name="edificioname" id="edificioname" value="">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha</label>
                            <input type="text" class="form-control" name="fecha_hora" id="fecha_hora" readonly="" required="">
                          </div>
                          
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <br>
                            <a data-toggle="modal" href="#myModal">           
                              <button id="btnAgregarDep" type="button" class="btn btn-primary form-control"> <span class="fa fa-plus"></span> Agregar Departamentos</button>
                            </a>
                          </div>
                          
                           <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detallesdep" class="table table-striped table-bordered table-condensed table-hover" style="position: relative;">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Departamento</th>
                                    <th>Tiempo de Operacion Total</th>
                                    <th>Consumo total Por Departamento</th>
                                    <th>Total de consumo</th>
                                </thead>
                                <tfoot style="background-color:#EEEEEE;">
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">0.00 kWh</h4><input type="hidden" name="total_compra" id="total_compra"></th> 
                                </tfoot>
                                <tbody>
                                  
                                </tbody>
                            </table>
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
  <!-- Modal para Detalles de Departamento-->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 80% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Diagnosticar Elemento</h4>
        </div>
        <div class="modal-body" style="width: 800px;">
          <table id="tbldepartamentos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <th>Elemento</th>
                <th>Cantidad</th>
                <th>Potencia</th>
                <th>P. Total</th>
                <th>T. Operacion</th>
                <th>Capacida KW</th>
                <th>Consumo Semanal</th>
                <th>Capacidad</th>
                <th>Funcionando</th>
                <th>Fundidos</th>
                <th>Actualizar</th>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
              
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Modal para agregar Departamento-->
  <div class="modal fade" id="myDep" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 80% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Diagnosticar Elemento</h4>
        </div>
        <div class="modal-body" style="width: 800px;">
          <table id="tbldepartamentos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <th>Elemento</th>
                <th>Cantidad</th>
                <th>Potencia</th>
                <th>P. Total</th>
                <th>T. Operacion</th>
                <th>Capacida KW</th>
                <th>Consumo Semanal</th>
                <th>Capacidad</th>
                <th>Funcionando</th>
                <th>Fundidos</th>
                <th>Actualizar</th>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
              
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/interior.js"></script>
<?php
}
ob_end_flush();
?>
