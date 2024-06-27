<!DOCTYPE html>
<html lang="es">
    <!--Vista encargada de crear qr para marcar la asistencia, basada en libreria qecode.min.js, 
    permite digitar la cedula para obtener qr y registrar asistencias. -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Generar Código QR Dinámicamente</title>
    <!-- Incluye la librería qrcode.js desde un CDN -->
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
</head>
<?php include '../partials/nav.php'; ?>
<body>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 py-12 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white p-8 shadow-md rounded-lg">
            <h1 class="text-2xl font-bold text-center mb-6">Generar Código QR</h1>
            <input type="w-full text" id="text" placeholder="Ingresa la Cedula para generar QR" class="w-full p-3 border border-gray-300 rounded-lg mb-4 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent">
            <button onclick="generateQRCode()" class="w-full p-3 bg-blue-500 text-white font-bold rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50">Generar Código QR</button>
            <div id="qrcode" class="mt-6 flex justify-center"></div>
        </div>
    </div>
    <!-- Script para generar el código QR -->
    <script>
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            width: 200,
            height: 200,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });

        function generateQRCode() {
            var text = document.getElementById("text").value;
            qrcode.clear(); // Limpiar el código QR anterior
            qrcode.makeCode(text); // Generar un nuevo código QR con el texto ingresado
        }
    </script>
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            var sidebar = document.getElementById('logo-sidebar');
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>       
</body>
</html>
