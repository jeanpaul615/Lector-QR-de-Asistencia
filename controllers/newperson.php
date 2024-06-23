<?php

include "cors.php";
$servername= 'localhost';
$username = 'root';
$password = '';   
$dbname = 'lectorqr';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get form data
  $Nombre = $_POST['Nombre'];
  $Cedula = $_POST['Cedula'];
  $Telefono = $_POST['Telefono'];
  $Cargo = $_POST['Cargo'];

  // Establish database connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Prepare SQL statement
  $sql = "INSERT INTO persona (Nombre, Cedula, Telefono, Cargo) VALUES (?, ?, ?, ?)";

  // Prepare and bind parameters
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssss", $Nombre, $Cedula, $Telefono, $Cargo);

  // Execute query
  if ($stmt->execute()) {
    $response = [
      'message' => 'Datos guardados exitosamente!',
      'data' => [
        'Nombre' => $Nombre,
        'Cedula' => $Cedula,
        'Telefono' => $Telefono,
        'Cargo' => $Cargo,
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
