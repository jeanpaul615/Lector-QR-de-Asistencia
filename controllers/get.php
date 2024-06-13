<?php
include 'cors.php';
include 'config.php';
//Esta api es la encargada de traer los datos de la asistencia para imprimir en la datatable
try {
    // Realizamos la consulta a la base de datos
    $consulta = $base_de_datos->query("SELECT * FROM asistencia");
    
    // Obtenemos los resultados como un array asociativo
    $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
    // Enviamos los datos como respuesta JSON
    header('Content-Type: application/json');
    echo json_encode($datos);
} catch(PDOException $e) {
    // Manejo de errores PDO
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Error en la consulta: " . $e->getMessage()));
}
?>