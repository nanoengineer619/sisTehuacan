<?php
require('../config/class.php');
  function generarLinkTemporal($iduser, $user){

    $cadena = $iduser.$user.rand(1,9999999).date('Y-m-d');
    $fec=date('Y-m-d');
    $token = sha1($cadena);
        
        $modelo = new Herramientas();
        $conexion= $modelo -> get_conexion();
        $sql = ("INSERT INTO restablecer(idusuario,username,token,creado) VALUES(:iduser,:user,:token,:creado)");
        $statement = $conexion ->prepare($sql);
        $statement ->bindParam(':iduser',$iduser);
        $statement ->bindParam(':user',$user);
        $statement ->bindParam(':token',$token);
        $statement ->bindParam(':creado',$fec);
        $statement ->execute(); 

    if($statement==true){
      $enlace = 'http://'.$_SERVER["SERVER_NAME"].'/Restpass/restablecer.php?id='.sha1($iduser).'&token='.$token;
      return $enlace;
    }
    else
      return FALSE;
  }

  function enviarEmail( $email, $link){

    $titulo = 'Recuperar contraseña';
    $mensaje = '<html>'.
    '<head>'.
      '<title>Restablece tu contraseña</title>'.
    '</head>'.
    '<body>'.
      '<p>Hemos recibido una petición para restablecer la contraseña de tu cuenta.</p>'.
      '<p>Si hiciste esta petición, haz clic en el siguiente enlace, de lo contrario puedes ignorar este mensaje.</p>'.
      '<p>'.
        '<strong>Enlace para restablecer tu contraseña</strong><br>'.
        '<a href="'.$link.'">restablecer contraseña</a>'.
      '</p>'.
    '</body>'.
    '</html>';

    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $cabeceras .= 'From: ITTSGEN <ittsgen.com>' . "\r\n";
    
    mail($email,$titulo,$mensaje,$cabeceras);
  }
  
  $email = $_POST['email'];

  $respuesta = new stdClass();

  if( $email != ""){   

        $conn= new Herramientas();
        $conexion = $conn -> get_conexion();
        $sql =("SELECT * FROM restablecer WHERE email =:email");
        $statement = $conexion ->prepare($sql);
        $statement ->bindParam(':email',$email);
        $statement ->execute();
        $resultado = $statement->rowCount();
        $numres = $statement ->fetch();
        if(($numres)>0)
        {
            $errors[] = "Ya se ha enviado un correo a esta cuenta, si no le aparece en bandeja de entrada, busque en correo no deseado"; 
        }
        else
        {
            $modelo = new Herramientas();
            $conexion= $modelo -> get_conexion();
            $sql =("SELECT * FROM usuario WHERE email = :email");
            $statement = $conexion ->prepare($sql);
            $statement ->bindParam(':email',$email);
            $statement ->execute();
            $resultado = $statement ->rowCount();

            if(($resultado)>0)
            {
                $result = $statement->fetch();
                $rows[]=$result;
                foreach ($rows as $rows) 
                {
                  $linkTemporal = generarLinkTemporal( $rows['idusuario'], $rows['nombre']);
                }
                if($linkTemporal)
                {
                  @enviarEmail( $email, $linkTemporal);
                  $messages[] = "Se ha enviado un correo en su email con las instrucciones para restablecer la contraseña";
                }
            }
            else
            {
              $errors[] = "No existe una cuenta asociada a ese correo";
            }
        }
  }
  else
  {
    $errors[] = "Completa Todos los Campos";
  }
   if (isset($errors)){
      
      ?>
      <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>¡Error!</strong> 
          <?php
            foreach ($errors as $error) {
                echo $error;
              }
            ?>
      </div>
      <?php
      }
      if (isset($messages)){
        
        ?>
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Bien hecho!</strong>
            <?php
              foreach ($messages as $message) {
                  echo $message;                  
                }
              ?>
        </div>
        <?php
      }

  ?>
