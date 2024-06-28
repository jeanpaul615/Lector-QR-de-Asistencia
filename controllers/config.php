<?php
include "cors.php";
$servidor = 'ewr1.clusters.zeabur.com';
$usuario = 'root';
$contrasena = 'dvtOH2N6Y0pLjqyW1E9k73A8T45hCJzx';   
$nombre_de_base = 'zeabur';

try{
   $base_de_datos = new PDO("mysql:host=$servidor;dbname=$nombre_de_base", $usuario, $contrasena);
}catch(Exception $e){
   echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
   exit;
}
?>
