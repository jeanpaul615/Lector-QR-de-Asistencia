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
    <!-- nav.php -->
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3 flex items-center justify-between">
        <a href="https://sintraemsdes.org/" class="flex items-center font-bold">
            <img class="w-14 h-14 mr-3" src="simtraemdes.jpeg" alt="Sintraemsdes Logo">
            Simtraemdes
        </a>
        <button id="menu-toggle" class="lg:hidden flex items-center text-gray-600 dark:text-gray-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>
</nav>
<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700 transform -translate-x-full lg:translate-x-0 transition-transform duration-200">
        <div class="h-full px-3 pb-4 overflow-y-auto mt-5">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="../main/main.php" class="flex items-center p-2 text-black rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M0 80C0 53.5 21.5 32 48 32h96c26.5 0 48 21.5 48 48v96c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80zM64 96v64h64V96H64zM0 336c0-26.5 21.5-48 48-48h96c26.5 0 48 21.5 48 48v96c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V336zm64 16v64h64V352H64zM304 32h96c26.5 0 48 21.5 48 48v96c0 26.5-21.5 48-48 48H304c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48zm80 64H320v64h64V96zM256 304c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s7.2 16 16 16h32c8.8 0 16-7.2 16-16s7.2-16 16-16s16 7.2 16 16v96c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16s-7.2-16-16-16s-16 7.2-16 16v64c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V304zM368 480a16 16 0 1 1 0-32 16 16 0 1 1 0 32zm64 0a16 16 0 1 1 0-32 16 16 0 1 1 0 32z"/></svg>
                        <span class="ml-3 text-black font-bold">Asistencia</span>
                    </a>
                </li>
                <li>
                    <a href="../markout/markout.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg>
                        <span class="ml-3 flex-1 whitespace-nowrap text-black font-bold">Marcar Salida</span>
                    </a>
                </li>
                <li>
                    <a href="../datatable/datatable.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                            <path d="M192 0c-41.8 0-77.4 26.7-90.5 64H64C28.7 64 0 92.7 0 128V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H282.5C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM128 256a64 64 0 1 1 128 0 64 64 0 1 1 -128 0zM80 432c0-44.2 35.8-80 80-80h64c44.2 0 80 35.8 80 80c0 8.8-7.2 16-16 16H96c-8.8 0-16-7.2-16-16z"/></svg>
                        <span class="ml-3 flex-1 whitespace-nowrap text-black font-bold">Lista de Asistentes</span>
                    </a>
                </li>
                <li>
                    <a href="../createqr/createqr.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                        <span class="ml-3 flex-1 whitespace-nowrap text-black font-bold">Crear nuevo Qr</span>
                    </a>
                </li>
                <li>
                    <a href="../newperson/newperson.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-6 h-6 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <path d="M112 48a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm40 304V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V256.9L59.4 304.5c-9.1 15.1-28.8 20-43.9 10.9s-20-28.8-10.9-43.9l58.3-97c17.4-28.9 48.6-46.6 82.3-46.6h29.7c33.7 0 64.9 17.7 82.3 46.6l58.3 97c9.1 15.1 4.2 34.8-10.9 43.9s-34.8 4.2-43.9-10.9L232 256.9V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V352H152z"/>
                        </svg>
                        <span class="ml-3 flex-1 whitespace-nowrap text-black font-bold">Nueva Persona</span>
                    </a>
                </li>
                <li>
                    <a href="../personas/personas.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M448 80v48c0 44.2-100.3 80-224 80S0 172.2 0 128V80C0 35.8 100.3 0 224 0S448 35.8 448 80zM393.2 214.7c20.8-7.4 39.9-16.9 54.8-28.6V288c0 44.2-100.3 80-224 80S0 332.2 0 288V186.1c14.9 11.8 34 21.2 54.8 28.6C99.7 230.7 159.5 240 224 240s124.3-9.3 169.2-25.3zM0 346.1c14.9 11.8 34 21.2 54.8 28.6C99.7 390.7 159.5 400 224 400s124.3-9.3 169.2-25.3c20.8-7.4 39.9-16.9 54.8-28.6V432c0 44.2-100.3 80-224 80S0 476.2 0 432V346.1z"/></svg>
                        <span class="ml-3 flex-1 whitespace-nowrap text-black font-bold">Personas en BD</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
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
                    Marcar Salida
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
