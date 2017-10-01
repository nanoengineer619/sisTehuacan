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
                        <table id="tbledificioD" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Edificio</th>
                            <th>Consumo Semanal</th>
                            <th>Consumo Mensual</th>
                            <th>Consumo Semestral</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Edificio</th>
                            <th>Consumo Semanal</th>
                            <th>Consumo Mensual</th>
                            <th>Consumo Semestral</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Edificio</label>
                            <input type="hidden" name="idedificio" id="idedificio">
                            <input type="hidden" name="idinterior" id="idinterior">
                            <input type="hidden" name="estado" id="estado">
                            <input type="text" class="form-control" readonly="" name="name" id="nombre" value="">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha</label>
                            <input type="hidden" class="form-control" name="total_consumo" id="total_consumo">
                            <input type="hidden" class="form-control" name="total_con" id="total_con">
                            <input type="text" class="form-control" name="fecha_hora" id="fecha_hora" readonly="">
                          </div>                          
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <br>
                            <a data-toggle="modal" href="#myModal">           
                              <button id="btnAgregarDep" type="button" class="btn btn-primary form-control"> <span class="fa fa-plus"></span> Agregar Departamentos</button>
                            </a>
                          </div>
                          
                           <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detallesdep" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#507384; color:#fff;">
                                    <th>Opciones</th>
                                    <th>Departamento</th>
                                    <th>Consumo Semanal</th>
                                    <th>Consumo Mensual</th>
                                    <th>Consumo Semestral</th>
                                    <th style="display: none;"></th>
                                </thead>
                                <tfoot style="background-color:#A9D0F5;">
                                    <th>Totales</th>
                                    <th></th>
                                    <th><h4 id="totals">0.00 kW</h4></th>
                                    <th><h4 id="totalmes">0.00 kW</h4></th>
                                    <th><h4 id="totalsem">0.00 kW</h4></th>
                                    <th style="display: none;"></th> 
                                </tfoot>
                                <tbody>
                                  
                                </tbody>
                            </table>
                          </div>
                          <!--Inicio de otra nueva fila-->
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <button id="btnGuardar" class="btn btn-primary" type="submit" ><i class="fa fa-save"></i> Guardar</button>
                          </div>
                          <!--Inicio de otra nueva fila-->
                          <div class="form-group col-lg-1 col-md-1 col-sm-6 col-xs-12">
                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                        <div class="col-lg-1 col-md-1 col-sm-6 col-xs-12" style="left: 20px;">
                          <button id="btnActualizar" onclick="actualizaredificio();" class="btn btn-info"><i class="fa fa-refresh"></i> Actualizar</button>
                          </div>
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
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Departamentos</h4>
        </div>
        <div class="modal-body">
          <table id="tbldepartamentos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <th>Acción</th>
                <th>Departamento</th>
                <th>Fecha</th>
                <th>Consumo</th>
                <th>Estado</th>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
              
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Modal para agregar Departamento-->
  <div class="modal fade" id="myDep" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 85% !important;">
      <div class="modal-content">
        <form name="form-elements" id="form-elements" method="POST">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Diagnosticar Elemento</h4>
        </div>
        <div class="modal-body">
          <table id="tblelementos" class="table table-striped table-bordered table-condensed table-hover table-responsive">
            <thead>
                <th>Elemento</th>
                <th>Cantidad</th>
                <th>Funcionando</th>
                <th>Fundidos</th>
                <th>Potencia/U</th>
                <th>P. Total</th>
                <th>Capacida KW</th>
                <th>T. Operacion</th>
                <th>Consumo Semanal</th>
                <th>Opción</th>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
              
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
           <button id="btnGuardarElem" class="btn btn-primary" type="submit" ><i class="fa fa-save"></i>&nbsp; Guardar</button>
          <button type="button" class="btn btn-default" onclick="btnGuardarhide(false);" data-dismiss="modal">Cerrar</button>
        </div> 
        </form>       
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
