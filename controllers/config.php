<?php
include "cors.php";

$servidor = 'ewr1.clusters.zeabur.com';
$usuario = 'root';
$contrasena = 'dvtOH2N6Y0pLjqyW1E9k73A8T45hCJzx';   
$nombre_de_base = 'lectorqr';

try {
   $base_de_datos = new PDO("mysql:host=$servidor;dbname=$nombre_de_base", $usuario, $contrasena);

   // Configura el modo de errores de PDO para lanzar excepciones
   $base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   // Opcional: configurar el conjunto de caracteres
   $base_de_datos->exec("SET NAMES 'utf8'");

   // Ejemplo de consulta
   $query = "SELECT * FROM tu_tabla";
   $statement = $base_de_datos->query($query);
   $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
   
   // Puedes usar $resultado para manipular datos
   
} catch(Exception $e) {
   echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
   exit;
}
?>
