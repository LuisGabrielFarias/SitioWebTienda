<?php

include 'administrador/config/bd.php';
include 'administrador/config/config.php';
include 'carrito.php';
include 'template/cabecera.php';

?>

<?php 

if($_POST){

    $total=0;
    $SID=session_id();
    $Correo=$_POST['email'];

    foreach($_SESSION['CARRITO'] as $indice=>$producto){


        $total=$total+($producto['PRECIO']*$producto['CANTIDAD']);


    }
        $sentencia=$conexion->prepare("INSERT INTO `tblventas`
                        (`ID`, `ClaveTransaccion`, `PaypalDatos`, `Fecha`, `Correo`, `Total`, `status`) 
                        VALUES (NULL,:ClaveTransaccion, '', NOW(), :Correo, :Total, 'pendiente');");
                        
                        $sentencia->bindParam(":ClaveTransaccion",$SID);
                        $sentencia->bindParam(":Correo",$Correo);
                        $sentencia->bindParam(":Total",$total);
                        $sentencia->execute();
                        $idVenta=$conexion->lastInsertId();


                        foreach($_SESSION['CARRITO'] as $indice=>$producto){

                            $sentencia=$conexion->prepare("INSERT INTO 
                            `tbldetalleventa` (`ID`, `IDVENTA`, `IDPRODUCTO`, `PRECIOUNITARIO`, `CANTIDAD`, `DESCARGADO`) 
                            VALUES (NULL,:IDVENTA,:IDPRODUCTO ,:PRECIOUNITARIO,:CANTIDAD, '0');");

                            $sentencia->bindParam(":IDVENTA",$idVenta);
                            $sentencia->bindParam(":IDPRODUCTO",$producto['ID']);
                            $sentencia->bindParam(":PRECIOUNITARIO",$producto['PRECIO']);
                            $sentencia->bindParam(":CANTIDAD",$producto['CANTIDAD']);
                            $sentencia->execute();


                        }

    // echo "<h3>".$total."</h3>";


}

?>


<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<style>
    
    /* Media query for mobile viewport */
    @media screen and (max-width: 400px) {
        #paypal-button-container {
            width: 100%;
        }
    }
    
    /* Media query for desktop viewport */
    @media screen and (min-width: 400px) {
        #paypal-button-container {
            width: 250px;
            display: inline-block;
        }
    }
    
</style>


 <div class="jumbotron text-center">
     <h1 class="display-4">¡Paso Final!</h1>
     <hr class="my-4">
     <p class="lead">Estas a Punto de Pagar con Paypal la Cantidad de:
         <h4>$<?php echo number_format($total,2);?></h4>
         <div id="paypal-button-container"></div>


     </p>
     <p>Los Productos Podrán ser Enviados una vez que se Procese el Pago.</p>
     <strong>(Para Aclaraciones Personales Enviar un Mensaje al Correo Electrónico de: compragamercoronda@gmail.com)</strong>

     
 </div>
 

 

 <script>
    paypal.Button.render({
        env: 'sandbox', // sandbox | production
        style: {
            label: 'checkout',  // checkout | credit | pay | buynow | generic
            size:  'responsive', // small | medium | large | responsive
            shape: 'pill',   // pill | rect
            color: 'gold'   // gold | blue | silver | black
        },

        // PayPal Client IDs - replace with your own
        // Create a PayPal app: https://developer.paypal.com/developer/applications/create

        client: {
            sandbox:   'AcMM_Ud_2UkumHPX8_h43UHnR0uKWler3okufeKa4-JxTEJNvF2dnf5Y5wCXqwff57VXvT7bI8MBsF8w',
            production: 'AULFe9f18c-HWrTly2N_aiec-2PG4wEmZVEq7lSEX-RGUt_dwVWSmAq81Y2_FJTbagxu3hAUQHHZcmCs'
        },

        // Wait for the PayPal button to be clicked

        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: '<?php echo $total;?>', currency: 'USD' }, 
                            description:"Compra De Productos A Compra Gamer Coronda:$<?php echo number_format($total,2);?>",
                            custom:"<?php echo $SID;?>#<?php echo openssl_encrypt($idVenta,COD,KEY); ?>"
                        }
                    ]
                }
            });
        },

        // Wait for the payment to be authorized by the customer

        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {
                console.log(data);
                window.location="verificador.php?paymentToken="+data.paymentToken+"&paymentID="+data.paymentID;
            });
        }
    
    }, '#paypal-button-container');

</script>
  

<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>


<?php include 'template/pie.php'; ?>
