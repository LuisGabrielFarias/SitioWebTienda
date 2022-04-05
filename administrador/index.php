<?php

// if sirve para la ejecucion de codigo.
// Button es para crear un boton.
// El elemento ul define una lista desordenada.
// El elemento contiene uno o más elementos li que especifican los ítems de la lista.
// La sentencia include incluye y evalúa el archivo especificado
session_start();
if($_POST){
    if(($_POST['usuario']=="Compra Gamer Coronda")&&($_POST['contrasenia']=="sistema")){
      $_SESSION['usuario']="ok";
      $_SESSION['nombreUsuario']="Compra Gamer Coronda";
      header('Location:inicio.php');

    }else{

      $mensaje="Error: El Usuario o Contraseña Son Incorrectos";



    }


}
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Administrador</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      
      <div class="container">
          <div class="row">

          <div class="col-md-4">
              
          </div>

              <div class="col-md-4">
             <br/><br/><br/>

              <div class="card">
                  <div class="card-header">
                      Login
                  </div>
                  <div class="card-body">


                  <?php if(isset($mensaje)) {?>

                  <div class="alert alert-danger" role="alert">
                   <?php echo $mensaje; ?>
                  </div>
                  <?php } ?>

                    <form method="POST">

                    <div class = "form-group">
                    <label >Usuario:</label>
                    <input type="text" class="form-control" name="usuario" placeholder="Escribe Tu Usuario">
                    </div>

                    <div class="form-group">
                    <label >Contraseña:</label>
                    <input type="password" class="form-control" name="contrasenia" placeholder="Escribe Tu Contraseña">
                    </div>
                    <button type="submit" class="btn btn-primary">Entrar al Administrador del Sitio Web</button>
                    </form>
                    
                    

                  </div>
                  
              </div>
                  
              </div>
              
          </div>
      </div>

  </body>
</html>