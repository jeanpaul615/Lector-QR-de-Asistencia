<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcar Salida Sintraemsdes</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>

</head>
<body class="bg-gray-200 flex">
    <?php include '../partials/nav.php'; ?>
    <!-- Contenido principal -->
    <main class="md:ml-64 flex-1 flex flex-col items-center justify-center min-h-screen bg-white mb-20 md:mt-4">
        <header class="w-full py-4 text-black text-center">
            <h1 class="text-4xl font-extrabold mt-14">Marcar Salida Simtraemdes</h1>
        </header>
        <section id="barcode-reader-container" class="container mx-auto p-8 bg-white">
            <div class="flex justify-center mb-6">
                <video id="video" width="50%" height="auto" class="border-4 border-gray-300 rounded-lg"></video>
                <canvas id="canvas" width="600" height="200" class="hidden"></canvas>
            </div>
            <div id="barcode-reader-results" class="mt-4 text-center text-lg text-gray-700"></div>
            <div class="flex justify-center mt-6 space-x-4">
                <button id="stop-button" class="bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-lg shadow">
                    Detener Escaneo
                </button>
                <button id="restart-button-markout" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-lg shadow">
                    Reanudar Escaneo
                </button>
            </div>
        </section>
    </main>
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            var sidebar = document.getElementById('logo-sidebar');
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>  
    <script src="markout.js"></script>
</body>
</html>
