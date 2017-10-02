<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Resetear contraseña </title>
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/font-awesome.css">
  </head>
  <body style="background: #4B8A72;">
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
    <div class="container" role="main">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <form id="frmRestablecer" method="post">
          <div class="panel panel-default">
            <div class="panel-heading"> Restaurar contraseña </div>
            <div class="panel-body">
              <div class="form-group">
                <label for="email"> <span>Escribe el email asociado a tu cuenta para recuperar tu contraseña </span></label>
                <input type="email" id="email" class="form-control" name="email" placeholder="Email">
              </div>
              <div class="form-group col-xs-6">
                <button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-envelope-o"></i>&nbsp; Enviar  </button>
              </div>
            </div>
          </div>
        </form>
        <div id="mensaje">
          
        </div>
      </div>
      <div class="col-md-5"></div>

    </div> <!-- /container -->
    <br>
    <br>
    <script src="../public/js/jquery-3.1.1.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../public/js/bootstrap.min.js"></script>
    <script>
    $("#frmRestablecer" ).submit(function( event ) {
              var parametros = $(this).serialize();                 
                           $.ajax({
                              type: "POST",
                              url: "validaremail.php",
                              data: parametros,
                               beforeSend: function(objeto){
                                $("#mensaje").html("Alerta: Cargando...").show(300).delay(7000).fadeOut(6500);
                                },
                              success: function(datos){
                              $("#mensaje").html(datos);
                              $("#email").val('');
                              }
                          });
           event.preventDefault();
    });
    </script>
  </body>
</html>