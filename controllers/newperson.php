<?php

include "cors.php";
$servername= 'localhost';
$username = 'root';
$password = '';   
$dbname = 'lectorqr';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get form data
  $nombre = $_POST['nombre'];
  $cedula = $_POST['cedula'];
  $telefono = $_POST['telefono'];
  $cargo = $_POST['cargo'];

  // Establish database connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Prepare SQL statement
  $sql = "INSERT INTO personas (nombre, cedula, telefono, cargo) VALUES (?, ?, ?, ?)";

  // Prepare and bind parameters
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssss", $nombre, $cedula, $telefono, $cargo);

  // Execute query
  if ($stmt->execute()) {
    $response = [
      'message' => 'Datos guardados exitosamente!',
      'data' => [
        'nombre' => $nombre,
        'cedula' => $cedula,
        'telefono' => $telefono,
        'cargo' => $cargo,
      ],
    ];
  } else {
    $response = [
      'message' => 'Error al guardar los datos en la base de datos'
    ];
  }

  // Close statement and connection
  $stmt->close();
  $conn->close();

  // Set response content type as JSON
  header('Content-Type: application/json');

  // Encode data to JSON and echo response
  echo json_encode($response);

} else {
  // Method is not POST, send error message
  http_response_code(405);
  echo json_encode(['message' => 'Método no permitido']);
}
