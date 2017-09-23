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
                    <div class="row">
     <div class="col-lg-3 col-xs-6">
       <!-- small box -->
       <div class="small-box bg-aqua">
         <div class="inner">
           <h3>150</h3>

           <p>New Orders</p>
         </div>
         <div class="icon">
           <i class="ion ion-bag"></i>
         </div>
         <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
       </div>
     </div>
     <!-- ./col -->
     <div class="col-lg-3 col-xs-6">
       <!-- small box -->
       <div class="small-box bg-green">
         <div class="inner">
           <h3>53<sup style="font-size: 20px">%</sup></h3>

           <p>Bounce Rate</p>
         </div>
         <div class="icon">
           <i class="ion ion-stats-bars"></i>
         </div>
         <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
       </div>
     </div>
     <!-- ./col -->
     <div class="col-lg-3 col-xs-6">
       <!-- small box -->
       <div class="small-box bg-yellow">
         <div class="inner">
           <h3>44</h3>

           <p>User Registrations</p>
         </div>
         <div class="icon">
           <i class="ion ion-person-add"></i>
         </div>
         <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
       </div>
     </div>
     <!-- ./col -->
     <div class="col-lg-3 col-xs-6">
       <!-- small box -->
       <div class="small-box bg-red">
         <div class="inner">
           <h3>65</h3>

           <p>Unique Visitors</p>
         </div>
         <div class="icon">
           <i class="ion ion-pie-graph"></i>
         </div>
         <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
       </div>
     </div>
     <!-- ./col -->
   </div>
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
