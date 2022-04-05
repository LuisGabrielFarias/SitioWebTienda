<?php

include 'administrador/config/bd.php';
include 'administrador/config/config.php';
include 'carrito.php';

?>

<?php



if($_POST){
    $IDVENTA= openssl_decrypt($_POST['IDVENTA'],COD,KEY);
    $IDPRODUCTO=openssl_decrypt($_POST['IDPRODUCTO'],COD,KEY);

    //print_r(" IDVENTA:".$IDVENTA);
   //print_r($IDPRODUCTO);

        $sentencia=$conexion->prepare("SELECT * FROM `tbldetalleventa`
                                    WHERE IDVENTA=:IDVENTA
                                    AND IDPRODUCTO=:IDPRODUCTO
                                    AND descargado<".DESCARGASPERMITIDAS);


$sentencia->bindParam(":IDVENTA", $IDVENTA);
$sentencia->bindParam(":IDPRODUCTO", $IDPRODUCTO);
$sentencia->execute();

$listaProductos=$sentencia->fetchAll(PDO::FETCH_ASSOC);

//print_r($listaProductos);
// RowCount devuelve el número de filas afectadas por la última sentencia DELETE, INSERT, o UPDATE ejecutada por el correspondiente objeto PDOStatement.

if($sentencia->rowCount()>0){



    echo "Producto En Proceso...";

    $nombreArchivo="archivos/".$listaProductos[0]['IDPRODUCTO'].".pdf";

    $nuevoNombreArchivo=$_POST['IDVENTA'].$_POST['IDPRODUCTO'].".pdf";

    echo  $nuevoNombreArchivo;


    header("Content-Transfer-Encoding: binary");
    header("Content-type: application/force-download");
    header("Content-Disposition: attachment; filename=$nuevoNombreArchivo");
    readfile("$nombreArchivo");



        
        $sentencia= $conexion->prepare("UPDATE `tbldetalleventa` set descargado=descargado+1
                                WHERE IDVENTA=:IDVENTA AND IDPRODUCTO=:IDPRODUCTO");

                                $sentencia->bindParam(":IDVENTA",$IDVENTA);
                                $sentencia->bindParam(":IDPRODUCTO",$IDPRODUCTO);

        $sentencia->execute();
        



        }else{

            include 'template/cabecera.php';
            echo "<br><br><br><br><h2>Ya Descargaste El Comprobante De Pago</h2>";
            include 'template/pie.php';


    }



    }
        

?>
