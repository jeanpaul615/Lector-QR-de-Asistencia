<?php
include 'cors.php';
include 'config.php';
//Esta api se encarga de traer los datos de la persona en base a la cedula 
try {
    // Obtener la cédula desde los parámetros de la URL
    $cedula = $_GET['cedula'];

    // Realizar la consulta a la base de datos
    $consulta = $base_de_datos->prepare("DELETE * FROM persona WHERE cedula = :cedula");
    $consulta->bindParam(':cedula', $cedula, PDO::PARAM_STR);
    $consulta->execute();
    
    // Obtener los resultados como un array asociativo
    $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
    // Enviar los datos como respuesta JSON
    header('Content-Type: application/json');
    echo json_encode($datos);
} catch(PDOException $e) {
    // Manejo de errores PDO
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Error en la consulta: " . $e->getMessage()));
}
?>
    