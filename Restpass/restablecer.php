<?php 
require('../config/class.php');
  $token = $_GET['token'];
  $idusuario = $_GET['id'];

  $conn=new Herramientas();
  $conexion = $conn -> get_conexion();
  $sql = ('SELECT * FROM restablecer WHERE token =:token');
  $statement = $conexion->prepare($sql);
  $statement->bindParam(':token',$token);
  $statement ->execute();
  $resultado=$statement ->rowCount();
  $usuario = $statement->fetch();
  $rows[]=$usuario;
   
   if (($resultado)>0) {
     
    foreach ($rows as $rows) {
    }

    if(sha1($rows['idusuario']) == $idusuario)
    {
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title> Restablecer contraseña </title>
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/font-awesome.css">
  </head>
  <body>
        
    <div class="container" role="main">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <form action="cambiarpassword.php" method="post">
          <div class="panel panel-default">
            <div class="panel-heading"> Restaurar contraseña </div>
            <div class="panel-body">
              <p></p>
              <div class="form-group">
                <label for="password"> Nueva contraseña </label>
                <input type="password" class="form-control" name="password1" required>
              </div>
              <div class="form-group">
                <label for="password2"> Confirmar contraseña </label>
                <input type="password" class="form-control" name="password2" required>
              </div>
              <input type="hidden" name="token" value="<?php echo $token ?>">
              <input type="hidden" name="idusuario" value="<?php echo $idusuario ?>">
              <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Recuperar contraseña" >
              </div>
            </div>
          </div>
        </form>  
      </div>
      <div class="col-md-4"></div>

    </div> <!-- /container -->

    <script src="../bootstrap/js/jquery-1.8.3min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
<?php
  }
    else{
      echo "El usuario no Coincide";
    }
  }
  else{
    echo "usuario incorrecto o link Caducado";
  }
?>