<?php
include 'cors.php';
include 'config.php'; 

try {
    // Realizamos la consulta para eliminar todos los registros de la tabla asistencias
    $consulta = $base_de_datos->exec("DELETE FROM asistencias");
    
    // Verificamos si se eliminaron registros
    if ($consulta === false) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "Error al intentar eliminar registros de asistencias."));
    } else {
        http_response_code(200); // OK
        echo json_encode(array("message" => "Se eliminaron todos los registros de asistencias correctamente."));
    }
} catch(PDOException $e) {
    // Manejo de errores PDO
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Error en la consulta: " . $e->getMessage()));
}
?>
 