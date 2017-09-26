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
                          <h2 style="font-family:bold; text-align: center;">Gestión de Detalles de Departamentos</h2></br>
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
                            <th>Fecha</th>
                            <th>Consumo</th>
                            <th>Estadp</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Edificio(*):</label>
                            <select id="idedificio" name="idedificio" class="form-control selectpicker" data-live-search="true" required="">

                            </select>
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Departamento(*):</label>
                            <input type="hidden" name="iddepartamento" id="iddepartamento">
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el Departamento" required="">
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Fecha</label>
                            <input type="text" class="form-control" id="fecha" name="fecha" readonly="">
                          </div>
                           <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-6">
                            <a data-toggle="modal" href="#myModal"> 
                              <label style="color: #fff;">.</label>         
                              <button id="btnAgregarArt" type="button" class="btn btn-primary form-control"> <span class="fa fa-plus"></span> Agregar Elemento</button>
                            </a>
                          </div>
                           <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style="position: relative;">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Elemento</th>
                                    <th>Cantidad</th>
                                    <th>Funcionando</th>
                                    <th>Fallando</th>
                                    <th>Potencia Watts</th>
                                    <th>P. Total</th>
                                    <th>KW</th>
                                    <th>T. Operacion</th>
                                    <th>Consumo</th>
                                </thead>
                                
                                <tbody>
                                  
                                </tbody>
                                <tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">KW 0.00</h4><input type="hidden" name="total_consumo" id="total_consumo"></th> 
                                </tfoot>
                            </table>
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
  <!-- Modal para agregar Departamento-->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Diagnosticar Elemento</h4>
        </div>
        <div class="modal-body" style="width: 100% !important;">
          <table id="tblelementos" class="table table-striped table-bordered table-condensed table-hover" style="width: 100% !important;">
            <thead>
                <th>Opción</th>
                <th>Elementos</th>
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