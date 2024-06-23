<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Mi Aplicación</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <div class="flex flex-col items-center mb-6">
      <h2 class="text-2xl text-center mb-2 font-bold">Iniciar Sesión</h2>
    </div>
    <form>
      <div class="mb-4">
        <label for="cedula">
          <span class="block text-sm font-medium text-gray-700 italic">Cedula</span>
          <input type="text" id="username" name="username" class="mt-1 block w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Ingresa tu cedula" required>
        </label>
      </div>
      <div class="mb-6">
        <label for="password">
          <span class="block text-sm font-medium text-gray-700 italic">Contraseña</span>
          <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Ingresa tu contraseña" required>
        </label>
      </div>
      <button type="submit" class="font-bold w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200">Iniciar Sesión</button>
      <div class="text-right mt-4">
        <a class="italic" href="#">¿Olvidaste tu contraseña?</a>
      </div>
      </form>
  </div>
</body>
</html>
