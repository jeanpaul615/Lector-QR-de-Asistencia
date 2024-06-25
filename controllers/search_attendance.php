<?php
include 'cors.php';
include 'config.php';

try {
    // Validar la entrada
    if (!isset($_GET['cedula']) || empty($_GET['cedula'])) {
        throw new Exception("Cédula no proporcionada o vacía");
    }
    
    $cedula = $_GET['cedula'];

    // Preparar la consulta SQL
    $consulta = $base_de_datos->prepare("SELECT * FROM asistencias WHERE cedula = :cedula");
    $consulta->bindParam(':cedula', $cedula, PDO::PARAM_STR);
    $consulta->execute();
    
    // Obtener los resultados
    $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
    // Establecer el tipo de contenido de la respuesta
    header('Content-Type: application/json');
    
    // Devolver los datos en formato JSON
    echo json_encode($datos);
} catch(PDOException $e) {
    // Enviar el código de respuesta HTTP 500 en caso de error de la base de datos
    http_response_code(500);
    echo json_encode(array("message" => "Error en la consulta: " . $e->getMessage()));
} catch(Exception $e) {
    // Enviar el código de respuesta HTTP 400 en caso de otros errores
    http_response_code(400);
    echo json_encode(array("message" => $e->getMessage()));
}
?>
