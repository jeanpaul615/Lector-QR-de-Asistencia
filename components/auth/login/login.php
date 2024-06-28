<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Simtraemsdes</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body class="bg-white flex items-center justify-center h-screen">
<nav class="fixed pl-5 top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3 flex items-center justify-between">
        <a href="https://sintraemsdes.org/" class="text-2xl md:flex items-center text-black font-semibold pt-1 flex">
            <img class="w-14 h-14 mr-3" src="simtraemdes.jpeg" alt="Sintraemsdes Logo">
            ASISTENCIA SINTRAEMSDES
        </a>
    </div>
</nav>
<div class="flex flex-col lg:flex-row items-center justify-center w-auto bg-gray-300 p-8 rounded-lg shadow-lg border-black hover:shadow-2xl hover:shadow-black">
  <!-- Formulario de inicio de sesión -->
  <div class="lg:mr-4 w-72">
    <div class="flex flex-col items-center mb-6">
      <h2 class="text-3xl text-center mb-2 font-bold">INICIAR SESIÓN</h2>
      <?php if (isset($error)): ?>
        <p class="text-red-500 mb-2"><?php echo $error; ?></p>
      <?php endif; ?>
    </div>
    <form id="loginForm" action="../../../controllers/auth.php" method="POST">
      <div class="mb-4">
        <label for="cedula">
          <span class="block text-sm font-medium text-gray-700 italic">Cedula</span>
          <input type="number" id="cedula" name="cedula" class="mt-1 block w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Ingresa tu cédula" required>
        </label>
      </div>
      <div class="mb-6">
        <label for="password">
          <span class="block text-sm font-medium text-gray-700 italic">Contraseña</span>
          <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Ingresa tu contraseña" required>
        </label>
      </div>
      <button id="login" type="submit" class="font-bold w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200">Iniciar Sesión</button>
      <div class="text-right mt-4">
        <a href="#" class="italic">¿Olvidaste tu contraseña?</a>
      </div>
    </form>
  </div>

  <!-- Imagen -->
  <div class="md:flex justify-center items-center mt-4 lg:mt-0 xs:hidden hidden">
    <a href="#" class="md:flex items-center font-bold pt-1">
      <img class="md:h-96 md:w-96" src="login-attendance.png" alt="Img login">
    </a>
  </div>
</div>
</body>
</html>
