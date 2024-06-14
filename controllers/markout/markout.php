<?php
include '../cors.php';
$servername = 'localhost';
$username = 'root';
$password = '';   
$dbname = 'lectorqr';

try {
    // Crear conexión PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Leer los datos JSON recibidos
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar si los datos JSON son válidos
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('JSON inválido recibido');
    }

    // Verificar que se han recibido los campos obligatorios

    // Asignar los datos recibidos a variables
    $cedula = $data['cedula'];
    $nombre = $data['Nombre'];
    $telefono = $data['telefono'];
    $cargo = $data['cargo'];
    $fecha = $data['fecha'];
    $hora_entrada = $data['hora_entrada'];
    $hora_salida = $data['hora_salida'];

    // Preparar la declaración SQL para actualizar la asistencia
    $stmt = $conn->prepare("UPDATE asistencia SET nombre = :nombre, telefono = :telefono, cargo = :cargo, fecha = :fecha, hora_entrada = :hora_entrada, hora_salida = :hora_salida WHERE cedula = :cedula");
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':cargo', $cargo);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':hora_entrada', $hora_entrada);
    $stmt->bindParam(':hora_salida', $hora_salida);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->execute();

    // Verificar si la actualización fue exitosa
    $affected_rows = $stmt->rowCount();
    if ($affected_rows > 0) {
        echo json_encode(array('message' => 'Asistencia registrada correctamente.'));
    } else {
        echo json_encode(array('error' => 'No se pudo actualizar la asistencia o no se encontró el participante.'));
    }

} catch(PDOException $e) {
    // Enviar código de respuesta 500 y mensaje de error en caso de excepción de PDO
    http_response_code(500);
    echo json_encode(array('error' => 'Error al conectar a la base de datos: ' . $e->getMessage()));
} catch(Exception $e) {
    // Enviar código de respuesta 400 y mensaje de error en caso de cualquier otra excepción
    http_response_code(400);
    echo json_encode(array('error' => $e->getMessage()));
}
?>
