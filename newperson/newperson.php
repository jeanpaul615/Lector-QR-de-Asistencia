<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Nueva Persona</title>
    <!-- Incluir Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</head>
<!-- Sidebar -->
<?php include '../partials/nav.php'; ?>

<body class="bg-gray-100 py-6 justify-center pt-24">
    <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden shadow-md">
        <h2 class="text-center text-2xl font-bold py-4 bg-gray-200">Nueva Persona</h2>
        <form id="new-person-form" action="../controllers/newperson.php" method="POST" class="px-6 py-4">

            <!-- Nombre -->
            <div class="mb-4">
                <label for="Nombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
                <input type="text" id="Nombre" name="Nombre"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <!-- Cédula -->
            <div class="mb-4">
                <label for="Cedula" class="block text-sm font-medium text-gray-700">Cédula:</label>
                <input type="number" id="Cedula" name="Cedula" 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <!-- Teléfono -->
            <div class="mb-4">
                <label for="Telefono" class="block text-sm font-medium text-gray-700">Teléfono:</label>
                <input type="number" id="Telefono" name="Telefono"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <!-- Cargo -->
            <div class="mb-4">
                <label for="Cargo" class="block text-sm font-medium text-gray-700">Cargo:</label>
                <input type="text" id="Cargo" name="Cargo"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <!-- Botón de guardar -->
            <div class="flex justify-center">
                <button id="guardar-persona" type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                    Guardar
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            var sidebar = document.getElementById('logo-sidebar');
            sidebar.classList.toggle('-translate-x-full');
        });

        document.getElementById('new-person-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevenir el envío del formulario por defecto

    // Obtener los valores de los campos
    var nombre = document.getElementById('Nombre').value;
    var cedula = document.getElementById('Cedula').value;
    var telefono = document.getElementById('Telefono').value;
    var cargo = document.getElementById('Cargo').value;

    // Validar que los campos no estén vacíos
    if (nombre === '' || cedula === '' || telefono === '' || cargo === '') {
        Swal.fire('Por favor, llene todos los campos obligatorios.');
        return;
    }

    // Realizar la consulta AJAX para verificar si la persona ya existe
    fetch(`http://localhost/lector-qr/controllers/search_by_cedula.php?cedula=${cedula}`)
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                Swal.fire('La persona con la cédula proporcionada ya está registrada.');
            } else {
                // Si la persona no existe, enviar el formulario para su guardado
                fetch('../controllers/newperson.php', {
                    method: 'POST',
                    body: new FormData(document.getElementById('new-person-form'))
                })
                .then(response => response.json())
                .then(response => {
                    // Mostrar mensaje de éxito o error según la respuesta de la API
                    if (response.message === 'Datos guardados exitosamente!') {
                        Swal.fire('Éxito', response.message, 'success');
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error al guardar persona:', error);
                    Swal.fire('Error al intentar guardar la persona.');
                });
            }
        })
        .catch(error => {
            console.error('Error al verificar persona:', error);
            Swal.fire('Error al verificar la existencia de la persona.');
        });
});

    </script>
</body>
</html>
