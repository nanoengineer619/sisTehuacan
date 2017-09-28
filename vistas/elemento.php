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

if ($_SESSION['edificios']==1)
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
                          <h2 style="font-family:bold; text-align: center;">Gestión de Elementos</h2></br>
                          <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Nombre</label>
                            <input type="hidden" id="idelemento" name="idelemento" value="">
                              <input type="text" class="form-control"  name="nombre" id="nombre" placeholder="Elemento">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <label style="color: #fff;">Guardar</label>
                              <button class="btn btn-primary form-control" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                          </div>
                          <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-1">
                            <label style="color: #fff;">Cancelar</label>
                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbldepartamento" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>

                        </table>
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
<script type="text/javascript" src="scripts/elemento.js"></script>
<?php
}
ob_end_flush();
?>
