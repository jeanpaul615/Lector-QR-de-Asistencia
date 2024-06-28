<?php
include "config.php";
include "cors.php";
session_start();
header('Content-Type: application/json'); // Asegúrate de que la respuesta sea JSON

if (!isset($_SESSION['authenticated'])) {
    echo json_encode(['message' => 'No autenticado']);
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'usuario', 'contraseña', 'base_de_datos');

if ($conexion->connect_error) {
    echo json_encode(['message' => 'Error de conexión a la base de datos: ' . $conexion->connect_error]);
    exit();
}

$nombre = $_POST['Nombre'];
$cedula = $_POST['Cedula'];
$telefono = $_POST['Telefono'];
$cargo = $_POST['Cargo'];

// Aquí validas y guardas los datos
$sql = "INSERT INTO personas (nombre, cedula, telefono, cargo) VALUES ('$nombre', '$cedula', '$telefono', '$cargo')";

if ($conexion->query($sql) === TRUE) {
    echo json_encode(['message' => 'Datos guardados exitosamente!']);
} else {
    echo json_encode(['message' => 'Error al guardar los datos: ' . $conexion->error]);
}

$conexion->close();
?>

