<?php
include 'cors.php';

// Obtener el contenido JSON enviado en la solicitud POST
$inputJSON = file_get_contents('php://input');

// Decodificar el JSON a un array asociativo
$data = json_decode($inputJSON, true);

// Verificar si hubo un error al decodificar el JSON
if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "Datos JSON no válidos."]);
    exit; // Terminar la ejecución del script si hay un error en el JSON
}

// Verificar que los campos requeridos estén presentes en el array $data
$requiredFields = ['fecha', 'Nombre', 'cedula', 'telefono', 'cargo', 'hora_entrada'];

foreach ($requiredFields as $field) {
    if (!isset($data[$field])) {
        echo json_encode(["error" => "Falta el campo obligatorio: $field"]);
        exit; // Terminar la ejecución del script si falta algún campo requerido
    }
}

// Extraer datos del array $data
$fecha = $data['fecha'];
$Nombre = $data['Nombre'];
$cedula = $data['cedula'];
$telefono = $data['telefono'];
$cargo = $data['cargo'];
$hora_entrada = $data['hora_entrada'];
$hora_salida = isset($data['hora_salida']) ? $data['hora_salida'] : null; // Asignar hora_salida si está presente, de lo contrario, nulo

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lectorqr";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    echo json_encode(["error" => "Conexión fallida: " . $conn->connect_error]);
    exit; // Terminar la ejecución del script si hay un error de conexión
}

// Preparar consulta SQL para insertar asistencia (usando sentencias preparadas)
$sql = "INSERT INTO asistencia (Nombre, cedula, telefono, cargo, fecha, hora_entrada, hora_salida)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

// Preparar la declaración
$stmt = $conn->prepare($sql);

// Verificar que la preparación fue exitosa
if ($stmt === false) {
    echo json_encode(["error" => "Error al preparar la consulta: " . $conn->error]);
    exit; // Terminar la ejecución del script si hay un error al preparar la consulta
}

// Asignar parámetros y ejecutar la consulta
$stmt->bind_param("sssssss", $Nombre, $cedula, $telefono, $cargo, $fecha, $hora_entrada, $hora_salida);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo json_encode(["success" => "Asistencia registrada exitosamente."]);
} else {
    echo json_encode(["error" => "Error al registrar la asistencia: " . $stmt->error]);
}

// Cerrar declaración y conexión
$stmt->close();
$conn->close();
?>
