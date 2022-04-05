

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Gamer Coronda </title>

    <link rel="stylesheet" href="./css/bootstrap.min.css" />

</head>
<body>
          
          <nav class="navbar navbar-expand-lg navbar-light bg-light">
              <ul class="nav navbar-nav">


                  <li class="nav-item">
                      <a class="nav-link" href="#">Compra Gamer Coronda</a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link" href="index.php">INICIO</a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link" href="productos.php">PRODUCTOS</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="nosotros.php">NOSOTROS</a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link" href="https://compragamer.com/hyperx/">MARCAS-SPONSOR</a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link" href="ayuda.php">AYUDA</a>
                  </li>


                  <li class="nav-item active">
                    <a class="nav-link" href="mostrarCarrito.php">CARRITO DE COMPRA(<?php 
                        echo (empty($_SESSION['CARRITO']))?0:count($_SESSION['CARRITO']);
                    
                    ?>)
                    

                    </a>
                </li>

                <li class="nav-item">
                      <a class="nav-link" href="http://localhost/sitioweb/administrador/">LOGIN</a>
                  </li>

                  
                  
              </ul>
          </nav>


          <div class="container">

          <br/>
              <div class="row">