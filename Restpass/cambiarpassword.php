<?php 
require('../config/class.php');

$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$idusuario = $_POST['idusuario'];
$token = $_POST['token'];

if( $password1 != "" && $password2 != "" && $idusuario != "" && $token != "" ){
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title> Restablecer contraseña </title>
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
  </head>

  <body>
    <div class="container" role="main">
      <div class="col-md-2"></div>
      <div class="col-md-8">
<?php

	$conn= new Herramientas();
	$conexion = $conn -> get_conexion();
	$sql =('SELECT * FROM restablecer WHERE token =:token');
	$statement = $conexion ->prepare($sql);
	$statement ->bindParam('token',$token);
	$statement ->execute();
	$resultado = $statement->rowCount();
	$result = $statement ->fetch();
	    $rows[]=$result;

	if(($resultado)>0){
		foreach ($rows as $rows) {
		}
		if( sha1($rows['idusuario'] === $idusuario ) ){
			if( $password1 === $password2 ){
				$pass=hash("SHA256",$password1);
				$consult = ("UPDATE usuario SET clave=:pass WHERE idusuario = :id");
				$statement = $conexion ->prepare($consult);	
				$statement ->bindParam(':pass',$pass);
				$statement ->bindParam(':id',$rows['idusuario']);
	            $statement ->execute();
				if($statement=true){

					$conn= new Herramientas();
	                $conexion = $conn -> get_conexion();
					$sql = ("DELETE FROM restablecer WHERE token = :token");
					$statement = $conexion ->prepare($sql);
					$statement -> bindParam(':token',$token);
	                $statement ->execute();
				?>
					<div class="alert alert-success" role="alert" style="position: relative; width: 50%; left: 50%;"><p> La contraseña se actualizó con exito. </p></div>
					<?php
                          header("Location: ../vistas/login.html.php");
					?>
					<a href="../vistas/login.html"><button type="button" class="btn btn-info">Login</button></a>
				<?php
				}
				else{
				?>
					<p> Ocurrió un error al actualizar la contraseña, intentalo más tarde </p>
				<?php
				}
			}
			else{
			?>
			<p> Las contraseñas no coinciden </p>
			<?php
			}

		}
		else{
?>
<p> El token no es válido </p>
<?php
		}	
	}
	else{
?>
<p> El token no es válido </p>
<?php
	}
	?>
	</div>
<div class="col-md-2"></div>
	</div> <!-- /container -->
  </body>
</html>
<?php
}
else{
	echo "incorrecto";
}
?>