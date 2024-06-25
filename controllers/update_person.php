<?php
include 'cors.php'; // Archivo para manejar CORS si es necesario
include 'config.php'; // Archivo de configuración de la base de datos

// Verificar que la petición sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del POST
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $cargo = $_POST['cargo'];

    try {
        // Realizar la consulta para actualizar los datos en la base de datos
        $consulta = $base_de_datos->prepare("UPDATE persona SET Nombre = :nombre, Telefono = :telefono, Cargo = :cargo WHERE cedula = :cedula");
        $consulta->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $consulta->bindParam(':cargo', $cargo, PDO::PARAM_STR);
        $consulta->bindParam(':cedula', $cedula, PDO::PARAM_STR);
        $consulta->execute();

        // Devolver respuesta de éxito
        echo json_encode(['status' => 'success', 'message' => 'Datos actualizados correctamente.']);
    } catch(PDOException $e) {
        // Manejo de errores PDO
        http_response_code(500); // Internal Server Error
        echo json_encode(['status' => 'error', 'message' => 'Error en la consulta: ' . $e->getMessage()]);
    }
} else {
    // Devolver respuesta de error si no es una petición POST
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
}
?>
