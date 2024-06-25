<?php
include 'cors.php';
include 'config.php';

// Esta API se encarga de eliminar los datos de una persona en base a la cédula 
try {
    // Obtener la cédula desde los parámetros de la URL
    $cedula = $_POST['cedula']; // Cambiado a POST para recibir datos desde Ajax

    // Realizar la consulta a la base de datos
    $consulta = $base_de_datos->prepare("DELETE FROM persona WHERE cedula = :cedula");
    $consulta->bindParam(':cedula', $cedula, PDO::PARAM_STR);
    $consulta->execute();
    
    // Verificar si se eliminó correctamente
    $filas_afectadas = $consulta->rowCount();
    
    if ($filas_afectadas > 0) {
        // Si se eliminó al menos una fila
        echo json_encode(array("message" => "Se eliminó correctamente la persona."));
    } else {
        // Si no se eliminó ninguna fila (posiblemente porque no existe la persona)
        echo json_encode(array("message" => "No se encontró ninguna persona con esa cédula."));
    }
} catch(PDOException $e) {
    // Manejo de errores PDO
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Error en la consulta: " . $e->getMessage()));
}
?>
