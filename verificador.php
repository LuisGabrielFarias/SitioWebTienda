<?php

include 'administrador/config/bd.php';
include 'administrador/config/config.php';
include 'carrito.php';
include 'template/cabecera.php';


?>  
<?php


$Login= curl_init(LINKAPI."/v1/oauth2/token");

curl_setopt($Login,CURLOPT_RETURNTRANSFER,TRUE);
curl_setopt($Login,CURLOPT_USERPWD,CLIENTID.":".SECRET);
curl_setopt($Login,CURLOPT_POSTFIELDS,"grant_type=client_credentials");

$Respuesta=curl_exec($Login);



$objRespuesta=json_decode($Respuesta);

$AccessToken=$objRespuesta->access_token;


$venta= curl_init(LINKAPI."/v1/payments/payment/".$_GET['paymentID']);

curl_setopt($venta,CURLOPT_HTTPHEADER,array("Content-Type: application/json","Authorization: Bearer ".$AccessToken));

curl_setopt($venta,CURLOPT_RETURNTRANSFER,TRUE);

$RespuestaVenta=curl_exec($venta);




$objDatosTransaccion=json_decode($RespuestaVenta);



$state=$objDatosTransaccion->state;
$email=$objDatosTransaccion->payer->payer_info->email;  

$total = $objDatosTransaccion->transactions[0]->amount->total;
$currency = $objDatosTransaccion->transactions[0]->amount->currency;
$custom = $objDatosTransaccion->transactions[0]->custom;



$clave=explode("#",$custom);

$SID=$clave[0];
$claveVenta=openssl_decrypt($clave[1],COD,KEY);

curl_close($venta);
curl_close($Login);



if($state=="approved"){

    $mensajePaypal="<h3>¡PAGO APROBADO CON EXITO!</h3>";

    $sentencia=$conexion->prepare("UPDATE `tblventas`
     SET `PaypalDatos` =:PaypalDatos,
      `status` = 'Aprobado' 
      WHERE `tblventas`.`ID` =:ID;");

      $sentencia->bindParam(":ID",$claveVenta);
      $sentencia->bindParam(":PaypalDatos",$RespuestaVenta);
      $sentencia->execute();


      $sentencia=$conexion->prepare("UPDATE tblventas SET status='completo'
                                        WHERE ClaveTransaccion=:ClaveTransaccion
                                        AND Total=:TOTAL
                                        AND ID=:ID");


                            $sentencia->bindParam(':ClaveTransaccion',$SID);
                            $sentencia->bindParam(':TOTAL',$total);
                            $sentencia->bindParam(':ID',$claveVenta);
                            $sentencia->execute();


                            $completado=$sentencia->rowCount();
                    session_destroy();


}else{

    $mensajePaypal="<h3>Hay Un Problema Con El Pago De Paypal</h3>";


}






?>

<div class="jumbotron">
    <h1 class="display-4">¡ LISTO !</h1>

    <hr class="my-4">

    <p class="lead"><?php echo $mensajePaypal; ?></p>

  
    <p>
    <?php 
    if($completado>=1){

          

$sentencia=$conexion->prepare("SELECT * FROM tbldetalleventa,productos 
WHERE tbldetalleventa.IDPRODUCTO=productos.ID 
AND tbldetalleventa.IDVENTA=:ID"
);

$sentencia->bindParam(':ID',$claveVenta);
$sentencia->execute();


$listaProductos=$sentencia->fetchAll(PDO::FETCH_ASSOC);

//print_r($listaProductos);



    }
    
    
    ?>

    <div class="row">

    <?php foreach($listaProductos as $productos){ ?>
        <div class="col-2">

            <div class="card">
            <img class="card-img-top" src="./img/<?php echo $productos['imagen']; ?>">
                         <div class="card-body">

                         <p class="card-text"><?php echo $productos['nombre']; ?></p>
                         <p class="card-text"><?php echo $productos['Precio']; ?></p>

                         <?php if($productos['DESCARGADO']<DESCARGASPERMITIDAS){ ?>
                         <form action="descargas.php" method="post">

                             <input type="hidden" name="IDVENTA" id="" value="<?php echo openssl_encrypt($claveVenta,COD,KEY);?>">
                             <input type="hidden" name="IDPRODUCTO" id="" value="<?php echo openssl_encrypt($productos['IDPRODUCTO'],COD,KEY);?>">

                         
                                <button class="btn btn-success" type="submit"> ¡Producto Comprado Con Exito! <br/>
                                        Haz Click Aqui Para Descargar El Comprobante De Pago.
                                </button>


                         </form>

                         <?php } else{ ?>

                            <button class="btn btn-success" type="button" disabled >¡Producto Comprado Con Exito! <br/>
                                        Haz Click Aqui Para Descargar El Comprobante De Pago.
                                </button>


                            <?php } ?>




                        
                    
                </div>

            </div>
             </div>

            <?php } ?>
    </div>

    </p>


</div>

<?php 
include 'template/pie.php';
?>