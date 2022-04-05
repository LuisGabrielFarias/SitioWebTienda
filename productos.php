<?php
include ("administrador/config/bd.php");
$sentenciaSQL= $conexion->prepare("SELECT * FROM productos");
$sentenciaSQL->execute();
$listaProductos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


include ("carrito.php");
?>

<?php include("template/cabecera.php"); ?>

        

<?php foreach($listaProductos as $productos ) { ?>

<div class="col-md-3">
<div class="card">
<img class="card-img-top" src="./img/<?php echo $productos['imagen']; ?>" alt="">
<div class="card-body">
    <h4 class="card-title"><?php echo $productos['nombre']; ?></h4>
    <h4 class="card-title">ARS $<?php echo $productos['Precio']; ?></h4>
    

    <form action="" method="post">

<input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($productos['id'],COD,KEY);?>">
<input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($productos['nombre'],COD,KEY);?>">
<input type="hidden" name="Precio" id="Precio" value="<?php echo openssl_encrypt($productos['Precio'],COD,KEY);?>">
<input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1,COD,KEY);?>">

<button class="btn btn-primary"
 name="btnAccion"
  value="Agregar"
   type="submit"
   
   >

AGREGAR AL CARRITO

</button>
</form>
 

</div>
</div>
</div>

<?php } ?>








<?php include("template/pie.php"); ?>

