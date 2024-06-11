<?php 
include 'cors.php';
include 'config.php';

    $consulta = $base_de_datos->query("SELECT * FROM articulos");
    $datos = $consulta->fetchAll();

    $respuesta['registros'] = $datos;
    echo json_encode($respuesta);
?>