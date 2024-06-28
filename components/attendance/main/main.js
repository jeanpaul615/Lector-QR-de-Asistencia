document.addEventListener("DOMContentLoaded", () => {
  const video = document.getElementById("video");
  const canvas = document.getElementById("canvas");
  const canvasContext = canvas.getContext("2d");
  const barcodeReaderResults = document.getElementById("barcode-reader-results");
  const fileInput = document.getElementById("file-input");
  let scanning = false;

  function startVideo() {
    navigator.mediaDevices
      .getUserMedia({ video: { facingMode: "environment" } })
      .then((stream) => {
        video.srcObject = stream;
        video.setAttribute("playsinline", true); // necesario para que funcione en iOS
        video.play();
        scanning = true;
        requestAnimationFrame(tick);
      })
      .catch((error) => {
        console.error("Error al acceder a la cámara:", error);
        Swal.fire({
          icon: "error",
          title: "No se puede acceder a la cámara.",
          text: error.message,
          confirmButtonText: "OK",
        });
      });
  }

  function stopVideo() {
    const stream = video.srcObject;
    const tracks = stream ? stream.getTracks() : [];

    tracks.forEach((track) => {
      track.stop();
    });

    video.srcObject = null;
    scanning = false;
  }

  function tick() {
    if (!scanning) return;
    if (video.readyState === video.HAVE_ENOUGH_DATA) {
      canvasContext.drawImage(video, 0, 0, canvas.width, canvas.height);
      const imageData = canvasContext.getImageData(0, 0, canvas.width, canvas.height);
      const code = jsQR(imageData.data, imageData.width, imageData.height);

      if (code) {
        drawLine(code.location.topLeftCorner, code.location.topRightCorner, "red");
        drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "red");
        drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "red");
        drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "red");
        scanning = false; // Detener el escaneo después de detectar el QR
        fetchParticipantData(code.data);
      }
    }
    requestAnimationFrame(tick);
  }

  function drawLine(begin, end, color) {
    canvasContext.beginPath();
    canvasContext.moveTo(begin.x, begin.y);
    canvasContext.lineTo(end.x, end.y);
    canvasContext.lineWidth = 4;
    canvasContext.strokeStyle = color;
    canvasContext.stroke();
  }

  function fetchParticipantData(cedula) {
    search_attendance(cedula)
      .then((data) => {
        if (data.length > 0) {
          console.log("Asistencia ya registrada:", data[0]);
          Swal.fire({
            icon: "info",
            title: "Asistencia ya registrada.",
            confirmButtonText: "OK",
          });
          return;
        }
        fetch(`https://asistenciasistraemsdes.zeabur.app/controllers/search_by_cedula.php?cedula=${cedula}`)
          .then((response) => response.json())
          .then((data) => {
            console.log("Datos recibidos:", data);
            if (data.length > 0) {
              const persona = data[0];
              registrarAsistencia(persona);
            } else {
              console.error("No se encontró la persona con la cédula proporcionada.");
              Swal.fire({
                icon: "error",
                title: "No se encontró la persona con la cédula proporcionada.",
                confirmButtonText: "OK",
              });
            }
          })
          .catch((error) => {
            console.error("Error al obtener datos:", error);
            Swal.fire({
              icon: "error",
              title: "Error al procesar servidor.",
              confirmButtonText: "OK",
            });
          });
      })
      .catch((error) => {
        console.error("Error al verificar asistencia:", error);
        Swal.fire({
          icon: "error",
          title: "Error al registrar asistencia.",
          confirmButtonText: "OK",
        });
      });
  }

  function registrarAsistencia(persona) {
    const fecha = new Date().toISOString().split("T")[0]; // Obtener la fecha actual en formato YYYY-MM-DD
    const horaEntrada = new Date().toLocaleTimeString("es-CO", {
      hour12: false,
    }); // Obtener la hora actual en formato HH:mm:ss

    const asistenciaData = {
      Fecha: fecha,
      Nombre: persona.Nombre,
      cedula: persona.cedula,
      Telefono: persona.Telefono,
      Cargo: persona.Cargo,
      Hora_entrada: horaEntrada
    };

    fetch("https://asistenciasistraemsdes.zeabur.app/controllers/sendattendance.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(asistenciaData),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.json();
      })
      .then((data) => {
        if (data.error) {
          throw new Error(data.error);
        }
        console.log("Asistencia registrada:", data);
        Swal.fire({
          icon: "success",
          title: "Asistencia Registrada.",
          confirmButtonText: "OK",
        });
      })
      .catch((error) => {
        console.error("Error al registrar la asistencia:", error);
        Swal.fire({
          icon: "error",
          title: "Error al registrar asistencia.",
          confirmButtonText: "OK",
        });
      });
  }

  function search_attendance(cedula) {
    return fetch(`https://asistenciasistraemsdes.zeabur.app/controllers/search_attendance.php?cedula=${cedula}`)
      .then((response) => response.json())
      .catch((error) => {
        console.error("Error al obtener datos de asistencia:", error);
        Swal.fire({
          icon: "error",
          title: "Error al registrar asistencia.",
          confirmButtonText: "OK",
        });
        return [];
      });
  }

  document.getElementById("stop-button").addEventListener("click", () => {
    stopVideo();
    Swal.fire({
      icon: "info",
      title: "Camara Detenida.",
      confirmButtonText: "OK",
    });
  });

  document.getElementById("restart-button").addEventListener("click", () => {
    if (!scanning) {
      barcodeReaderResults.innerText = "";
      startVideo();
    }
  });

  fileInput.addEventListener("change", (event) => {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (e) => {
      const img = new Image();
      img.onload = () => {
        canvasContext.drawImage(img, 0, 0, canvas.width, canvas.height);
        const imageData = canvasContext.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(imageData.data, imageData.width, imageData.height);

        if (code) {
          barcodeReaderResults.innerText = `Código QR Detectado: ${code.data}`;
          fetchParticipantData(code.data);
        } else {
          barcodeReaderResults.innerText = "No se detectó ningún código QR.";
        }
      };
      img.src = e.target.result;
    };
    reader.readAsDataURL(file);
  });

  startVideo();
});
