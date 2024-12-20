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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LISTA DE PARTICIPANTES</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
</head>
<style>
  /* Estilos para DataTable */
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
</style>

<body class="bg-white ">
  <?php include '../../partials/nav.php'; ?>

  <!-- Content -->
  <div class="pt-20 md:pl-80 m-8 md:pr-36">

    <div class="mb-8 flex justify-between items-center">
      <h1 class="text-3xl font-bold">Personas en la Base de Datos</h1>
      <div>
        <button id="print-pdf-button" class="md:text-sm text-xs bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow">
          Imprimir Personas en PDF
        </button>
        <button id="export-excel-button" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg shadow ml-2">
          Exportar a Excel
        </button>
      </div>
    </div>

    <div>
      <table id="myTable" class="min-w-full divide-y divide-gray-200 shadow overflow-hidden sm:rounded-lg">
        <thead>
          <tr>
            <th class="px-6 py-3 text-left">Nombre</th>
            <th class="px-6 py-3 text-left">Cedula</th>
            <th class="px-6 py-3 text-left  hidden md:table-cell">Telefono</th>
            <th class="px-6 py-3 text-left  hidden md:table-cell">Cargo</th>
            <th class="px-6 py-3 text-left">Acciones</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <!-- Data rows will be dynamically added here -->
        </tbody>
      </table>
    </div>

  </div>

  <!-- Modal -->
  <div id="exampleModal" class="fixed inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 transition-opacity" aria-hidden="true">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
      </div>

      <!-- This element is to trick the browser into centering the modal contents. -->
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div
        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div
              class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
              <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 6v6m0 2m-6 2h12a2 2 0 002-2V8a2 2 0 00-2-2H6a2 2 0 00-2 2v8a2 2 0 002 2" />
              </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                Información Detallada
              </h3>
              <div class="mt-2">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
                <input type="text" id="nombre" name="nombre"
                  class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 sm:text-sm" />
              </div>
              <div class="mt-2">
                <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono:</label>
                <input type="number" id="telefono" name="telefono"
                  class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 sm:text-sm" />
              </div>
              <div class="mt-2">
                <label for="cargo" class="block text-sm font-medium text-gray-700">Cargo:</label>
                <input type="text" id="cargo" name="cargo"
                  class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 sm:text-sm" />
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button id="guardarCambiosBtn" type="button"
            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
            Guardar Cambios
          </button>
          <button id="closeModalBtn" type="button"
            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            Cancelar
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS y Scripts Personalizados -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
  <!-- Custom JavaScript -->
  <script>
    $(document).ready(function () {
  obtenerDatosAsistencia();
  
  $("#print-pdf-button").click(function () {
    var element = document.getElementById("myTable");
    var opt = {
      margin: [0.5, 0.5],
      filename: "attendance.pdf",
      image: {
        type: "jpeg",
        quality: 1
      },
      html2canvas: {
        scale: 2,
        useCORS: true
      },
      jsPDF: {
        unit: "in",
        format: "a3",
        orientation: "landscape"
      },
      pagebreak: {
        mode: ["avoid-all", "css", "legacy"]
      },
    };
    html2pdf().from(element).set(opt).save();
  });

  $("#export-excel-button").click(function () {
    var wb = XLSX.utils.book_new();
    var ws = XLSX.utils.table_to_sheet(document.getElementById("myTable"));
    XLSX.utils.book_append_sheet(wb, ws, "Asistencia");
    XLSX.writeFile(wb, "attendance.xlsx");
  });

  $("#closeModalBtn").off("click").on("click", function () {
  $("#exampleModal").addClass("hidden");
});

  $("#menu-toggle").click(function () {
    $("#logo-sidebar").toggleClass("-translate-x-full");
  });
});

function obtenerDatosAsistencia() {
  fetch("https://asistenciasistraemsdes.zeabur.app/controllers/getpersonas.php")
    .then((response) => response.json())
    .then((data) => {
      console.log("Datos recibidos:", data);
      agregarDatosATabla(data);
      $("#myTable").DataTable({
        paging: true,
        info: true,
        searching: true,
        lengthMenu: [5, 10, 25, 50, 100],
        language: {
          search: "<span class='text-blue-500 font-bold'>Buscar:</span>",
          lengthMenu: "Mostrar _MENU_ registros por página",
          info: "Mostrando página _PAGE_ de _PAGES_",
          infoEmpty: "No hay registros disponibles",
          infoFiltered: "(filtrado de _MAX_ registros en total)",
          paginate: {
            first: "Primero",
            last: "Último",
            next: "Siguiente",
            previous: "Anterior",
          },
        },
      });
    })
    .catch((error) => {
      console.error("Error al obtener datos de asistencia:", error);
    });
}

function agregarDatosATabla(data) {
  const tbody = $("#myTable tbody");
  tbody.empty();

  data.forEach((item) => {
    const row = $("<tr>").appendTo(tbody);
    $("<td>").text(item.Nombre).appendTo(row);
    $("<td>").text(item.cedula).appendTo(row);
    // Columna para Teléfono visible en pantallas grandes, oculta en pequeñas
    $("<td>").addClass("hidden md:table-cell").text(item.Telefono).appendTo(row);

    // Columna para Cargo visible en pantallas grandes, oculta en pequeñas
    $("<td>").addClass("hidden md:table-cell").text(item.Cargo).appendTo(row);



    const acciones = $("<td>").appendTo(row);
    const btnEliminar = $("<button>")
      .text("Eliminar")
      .addClass("bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded-lg shadow mx-1")
      .appendTo(acciones);

    const btnActualizar = $("<button>")
      .text("Actualizar")
      .addClass("bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded-lg shadow mx-1")
      .appendTo(acciones);

    btnEliminar.click(function () {
      Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo'
      }).then((result) => {
        if (result.isConfirmed) {
          eliminarPersona(item.cedula);
        }
      });
    });

    btnActualizar.off("click").on("click", function () {

      $("#exampleModal").removeClass("hidden");
      $("#modal-title").text("Actualizar datos de " + item.Nombre);

      $("#nombre").val(item.Nombre);
      $("#telefono").val(item.Telefono);
      $("#cargo").val(item.Cargo);

      $("#guardarCambiosBtn")
        .off("click")
        .on("click", function () {
          item.Nombre = $("#nombre").val();
          item.Telefono = $("#telefono").val();
          item.Cargo = $("#cargo").val();

          $.ajax({
            url: "https://asistenciasistraemsdes.zeabur.app/controllers/update_person.php",
            type: "POST",
            dataType: "json",
            data: {
              cedula: item.cedula,
              nombre: item.Nombre,
              telefono: item.Telefono,
              cargo: item.Cargo,
            },
            success: function (response) {
              console.log("Respuesta del servidor:", response);
              Swal.fire({
                icon: "success",
                title: "Se actualizó la persona.",
                confirmButtonText: "OK",
              });
              location.reload();
            },
            error: function (error) {
              Swal.fire({
                icon: "error",
                title: "Error al actualizar persona.",
                confirmButtonText: "OK",
              });
              location.reload();
            },
          });
          $("#exampleModal").addClass("hidden");
        });
    });
  });
}

function eliminarPersona(cedula) {
  $.ajax({
    url: "https://asistenciasistraemsdes.zeabur.app/controllers/delete_person.php",
    type: "POST",
    dataType: "json",
    data: {
      cedula: cedula
    },
    success: function (response) {
      console.log("Respuesta del servidor:", response);
      Swal.fire({
        icon: "success",
        title: "Se eliminó la persona.",
        confirmButtonText: "OK",
      }).then(() => {
        location.reload();
      });
    },
    error: function (error) {
      Swal.fire({
        icon: "error",
        title: "Error al eliminar persona.",
        confirmButtonText: "OK",
      });
    },
  });
}


  </script>
</body>

</html>