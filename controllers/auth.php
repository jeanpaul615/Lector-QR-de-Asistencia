<?php
session_start();
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["cedula"]) && isset($_POST["password"])) {
        $cedula = $_POST["cedula"];
        $password = $_POST["password"];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Validación básica (deberías implementar una validación más robusta y segura)
        $sql = "SELECT * FROM usuario WHERE cedula=:cedula AND password=:password";
        $stmt = $base_de_datos->prepare($sql);
        $stmt->bindValue(':cedula', $cedula);
        $stmt->bindValue(':password', $password);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $_SESSION['authenticated'] = true;
            header("Location: ../components/attendance/main/main.php");
            exit();
        } else {
            // Mensaje de error
            $error = "Credenciales incorrectas. Por favor, intenta nuevamente.";
            echo "ERROR CREDENCIALES INCORRECTAS";
        }
    } else {
        $error = "Los campos están vacíos.";
        header("Location: ../components/auth/login/login.php");
        echo "CAMPOS VACIOS";
    }
}
?>
