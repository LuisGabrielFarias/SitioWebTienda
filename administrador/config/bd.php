<?php

// conexion de la base de datos

define("KEY","sistema");
define("COD","AES-128-ECB");

$host="sql204.epizy.com";
$bd="epiz_31101127_sitio";
$usuario="epiz_31101127";
$contrasenia="rCsWAXuGXFFJ6";


//$host="localhost";
//$bd="sitio";
//$usuario="root";
//$contrasenia="";



try {
     $conexion= new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasenia);
     
} catch ( Exception $ex) {

    echo $ex->getMessage();
}
?>