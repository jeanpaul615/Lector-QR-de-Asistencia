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
    $Fecha = $data['Fecha'];
    $Nombre = $data['Nombre'];
    $cedula = $data['cedula'];
    $Telefono = $data['Telefono'];
    $Cargo = $data['Cargo'];
    $Hora_entrada = $data['Hora_entrada'];
    $Hora_salida = $data['Hora_salida'];

    // Preparar la declaración SQL para actualizar la asistencia
    $stmt = $conn->prepare("UPDATE asistencias SET Fecha = :Fecha, Nombre = :Nombre, Telefono = :Telefono, Cargo = :Cargo,  Hora_entrada = :Hora_entrada, Hora_salida = :Hora_salida WHERE cedula = :cedula");
    $stmt->bindParam(':Fecha', $Fecha);
    $stmt->bindParam(':Nombre', $Nombre);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->bindParam(':Telefono', $Telefono);
    $stmt->bindParam(':Cargo', $Cargo);
    $stmt->bindParam(':Hora_entrada', $Hora_entrada);
    $stmt->bindParam(':Hora_salida', $Hora_salida);

    $stmt->execute();

    // Verificar si la actualización fue exitosa
    $affected_rows = $stmt->rowCount();
    if ($affected_rows > 0) {
        echo json_encode(array('message' => 'Salida registrada correctamente.'));
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