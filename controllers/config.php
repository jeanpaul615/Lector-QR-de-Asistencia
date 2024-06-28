<?php
include "cors.php";

$servidor = 'bwkztu6eqkuvlfujvsbt-mysql.services.clever-cloud.com';
$usuario = 'uyyyxnxopbfcth39';
$contrasena = 'Ndxw83fXg74yd0fayBrB';   
$nombre_de_base = 'bwkztu6eqkuvlfujvsbt';

try {
   $base_de_datos = new PDO("mysql:host=$servidor;dbname=$nombre_de_base", $usuario, $contrasena);

   // Configura el modo de errores de PDO para lanzar excepciones
   $base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $e) {
   echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
   exit;
}
?>
