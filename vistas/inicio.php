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

if ($_SESSION['almacen']==1)
{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box" style="height: 500px;">
                    <center><h1>Bienvenido al</h1></center>
                    <center><h1>Sistema de Gestión Energética</h1></center>
                    </br>
                    <center><img style="text-align: center;" src="../public/img/energia.png" alt="Energia"></center>
                  </div>
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
<script type="text/javascript" src="scripts/categoria.js"></script>
<?php
}
ob_end_flush();
?>
