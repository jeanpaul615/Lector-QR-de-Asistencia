<?php
session_start();

if (!isset($_SESSION['authenticated'])) {
    header('Location: ../login/login.php');
    exit();
}

// Aquí va el contenido de main.php
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LISTA DE PARTICIPANTES</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css" rel="stylesheet">
  <style>
    /* Basic styles for DataTable */
    table.dataTable {
      border-collapse: collapse;
      width: 100%;
      margin-top: 1rem;
      /* Ajuste de margen para mejor espaciado */
    }

    table.dataTable thead {
      background-color: #000000;
      color: #fff;
    }

    table.dataTable tbody tr {
      background-color: #d1d1d1;
      border-bottom: 1px solid #494949;
    }

    table.dataTable tbody tr:hover {
      background-color: #8f8d8d;
    }

    table.dataTable td,
    table.dataTable th {
      border: 1px solid #494949;
      padding: 8px;
    }

    .dataTables_wrapper .dataTables_filter input {
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 6px 12px;
      margin-left: 0.5em;
    }

    .dataTables_wrapper .dataTables_length select {
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 6px 12px;
      margin-right: 0.5em;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 6px 12px;
      margin: 2px;
      cursor: pointer;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
      background-color: #e2e2e2;
    }

    .dataTables_wrapper .dataTables_info {
      margin-top: 10px;
    }

    /* Estilos adicionales para la impresión */
    @media print {
      table.dataTable {
        width: 100% !important;
        margin: 0 !important;
      }

      .dataTables_wrapper .dataTables_filter,
      .dataTables_wrapper .dataTables_length,
      .dataTables_wrapper .dataTables_info,
      .dataTables_wrapper .dataTables_paginate {
        display: none !important;
      }
    }

    /* Estilos para la barra de navegación */
    .nav-container {
      background-color: #f8f9fa;
      border-bottom: 1px solid #e3e4e6;
      padding: 10px 20px;
    }
  </style>
</head>

<body class="bg-white">
  <?php include '../../partials/nav.php'; ?>
  <!-- Navigation -->
  <nav class="nav-container fixed w-full top-0 left-0 z-50">
    <!-- Replace with your navigation content -->
    <div class="flex justify-between items-center ml-5">
      <img class="w-14 h-14" src="simtraemdes.jpeg" alt="logo" />
      <div class="flex items-center space-x-4">
        <!-- Add your navigation links or components -->
        <a href="../../attendance/main/main.php" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200 hover:text-gray-900">Inicio</a>
        <button id="delete-attendance" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200 hover:text-gray-900">Eliminar asistencia</button>
      </div>
    </div>
  </nav>

  <!-- Content -->
  <div class="container mx-auto w-auto pl-20 pr-20 pt-24 md:ml-64">
    <div class="mb-4 flex justify-between items-center">
      <h1 class="text-3xl font-bold ">Lista de Participantes</h1>
      <div>
        <button id="print-pdf-button" class="md:text-sm text-xs mb-3 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow">
          Imprimir Asistencia en PDF
        </button>
        <button id="export-excel-button" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg shadow ml-2">
          Exportar a Excel
        </button>
      </div>
    </div>
    <div>
      <table id="myTable" class="divide-y divide-gray-200 shadow overflow-hidden sm:rounded-lg">
        <thead>
          <tr>
            <th class="px-2 md:px-6 py-3 text-left">Fecha</th>
            <th class="px-2 md:px-6 py-3 text-left">Nombre</th>
            <th class="px-2 md:px-6 py-3 text-left">Cedula</th>
            <th class="px-2 md:px-6 py-3 text-left">Telefono</th>
            <th class="px-2 md:px-6 py-3 text-left">Cargo</th>
            <th class="px-2 md:px-6 py-3 text-left">Hora Entrada</th>
            <th class="px-2 md:px-6 py-3 text-left">Hora Salida</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <!-- Data rows will be dynamically added here -->
        </tbody>
      </table>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
  <script>
    $(document).ready(function() {
      obtenerDatosAsistencia(); // Llamar a la función para obtener y agregar datos a la tabla
    });
    //Fetch a la api que trae los datos para alimentar la datatable con los datos de las personas
    function obtenerDatosAsistencia() {
      fetch('https://asistenciasistraemsdes.zeabur.app/controllers/get.php')
        .then(response => response.json())
        .then(data => {
          console.log("Datos recibidos:", data);
          agregarDatosATabla(data); // Llamar a la función para agregar datos a la tabla
          // Inicializar DataTables después de agregar los datos
          $('#myTable').DataTable({
            "paging": true,
            "info": true,
            "searching": true,
            "lengthMenu": [5, 10, 25, 50, 100],
            "responsive": true,
            "language": {
              "search": "Buscar:",
              "lengthMenu": "Mostrar _MENU_ registros por página",
              "info": "Mostrando página _PAGE_ de _PAGES_",
              "infoEmpty": "No hay registros disponibles",
              "infoFiltered": "(filtrado de _MAX_ registros en total)",
              "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
              }
            }
          });
        })
        .catch(error => {
          console.error('Error al obtener datos de asistencia:', error);
          // Manejar el error según sea necesario
        });
    }
    /*Función que permite agregar los datos a la tabla,
     recibe los parametros de la api y los implementa como <td>*/
    function agregarDatosATabla(data) {
      const tbody = $('#myTable tbody');
      tbody.empty();
      //itera en cada items para implementar todas las personas
      data.forEach(item => {
        const row = $('<tr>').appendTo(tbody);
        $('<td>').text(item.Fecha).appendTo(row);
        $('<td>').text(item.Nombre).appendTo(row);
        $('<td>').text(item.cedula).appendTo(row);
        $('<td>').text(item.Telefono).appendTo(row);
        $('<td>').text(item.Cargo).appendTo(row);
        $('<td>').text(item.Hora_entrada).appendTo(row);
        $('<td>').text(item.Hora_salida).appendTo(row);
      });
    }
    //script para imprimir en pdf
    document.getElementById('print-pdf-button').addEventListener('click', function() {
      var element = document.getElementById('myTable');
      var opt = {
        margin: 0.5,
        filename: 'asistencia.pdf',
        image: {
          type: 'jpeg',
          quality: 1
        },
        html2canvas: {
          scale: 2,
          useCORS: true
        },
        jsPDF: {
          unit: 'in',
          format: 'a3',
          orientation: 'landscape'
        },
        pagebreak: {
          mode: ['avoid-all', 'css', 'legacy']
        }
      };
      html2pdf().from(element).set(opt).save();
    });
    //script encargado de exportar todos los datos de la tabla a un excel
    document.getElementById('export-excel-button').addEventListener('click', function() {
      var wb = XLSX.utils.book_new();
      var ws = XLSX.utils.table_to_sheet(document.getElementById('myTable'));
      XLSX.utils.book_append_sheet(wb, ws, 'Asistencia');
      XLSX.writeFile(wb, 'attendance.xlsx');
    });

    /*Este fecth permite eliminar todos los datos de la tabla asistencias,
    para poder realizar una nueva asistencia*/
    document.getElementById('delete-attendance').addEventListener('click', function() {
      fetch('https://asistenciasistraemsdes.zeabur.app/controllers/delete_attendance.php')
        .then(response => response.json())
        .then(data => {
          console.log("Asistencia Nueva");
          location.reload();
        })
    });

  </script>
</body>

</html>
