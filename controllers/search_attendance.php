<?php
include 'cors.php';
include 'config.php';

try {
    $cedula = $_GET['cedula'];
    $consulta = $base_de_datos->prepare("SELECT * FROM asistencias WHERE cedula = :cedula");
    $consulta->bindParam(':cedula', $cedula, PDO::PARAM_STR);
    $consulta->execute();
    
    $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($datos);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(array("message" => "Error en la consulta: " . $e->getMessage()));
}
?>