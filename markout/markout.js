document.addEventListener("DOMContentLoaded", () => {
    const video = document.getElementById("video");
    const canvas = document.getElementById("canvas");
    const canvasContext = canvas.getContext("2d");
    const barcodeReaderResults = document.getElementById("barcode-reader-results");
    let scanning = false;

    function startVideoMarkout() {
        navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
            .then((stream) => {
                video.srcObject = stream;
                video.setAttribute("playsinline", true);
                video.play();
                scanning = true;
                requestAnimationFrame(tick);
            })
            .catch((error) => {
                console.error("Error al iniciar la cámara:", error);
            });
    }

    function stopVideoMarkout() {
        const stream = video.srcObject;
        if (stream) {
            const tracks = stream.getTracks();
            tracks.forEach((track) => track.stop());
            video.srcObject = null;
        }
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
                barcodeReaderResults.innerText = `Código QR Detectado: ${code.data}`;
                scanning = false;
                fetchParticipantDataMarkout(code.data);
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

    function fetchParticipantDataMarkout(cedula) {
        fetch(`http://localhost/lector-qr/controllers/search_attendance.php?cedula=${encodeURIComponent(cedula)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log("Datos recibidos:", data);
                if (data.length > 0) {
                    const asistencia = data[0];
                    registrarAsistenciaMarkout(asistencia);
                } else {
                    console.error('No se encontró la asistencia con la cédula proporcionada.');
                }
            })
            .catch(error => {
                console.error('Error al obtener datos:', error);
                barcodeReaderResults.innerText = "Error al procesar la respuesta del servidor.";
            });
    }

    function registrarAsistenciaMarkout(asistencia) {
        const horaSalida = new Date().toLocaleTimeString('es-CO', { hour12: false });

        if (asistencia.Hora_salida) {
            barcodeReaderResults.innerText = "Ya has marcado la salida anteriormente.";
            return;
        }

        const asistenciaData = {
            Fecha: asistencia.Fecha,
            Nombre: asistencia.Nombre,
            cedula: asistencia.cedula,
            Telefono: asistencia.Telefono,
            Cargo: asistencia.Cargo,
            Hora_entrada: asistencia.Hora_entrada,
            Hora_salida: horaSalida
        };

        console.log('Datos de asistencia antes de enviar:', asistenciaData);

        fetch('http://localhost/lector-qr/controllers/markout.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(asistenciaData)
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text); });
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            console.log('Salida registrada:', data);
            barcodeReaderResults.innerText += "\nSalida registrada exitosamente.";
        })
        .catch(error => {
            console.error('Error al registrar asistencia:', error);
            barcodeReaderResults.innerText += `\n ${error.message}`;
        });
    }

    document.getElementById("stop-button").addEventListener("click", stopVideoMarkout);
    document.getElementById("restart-button-markout").addEventListener("click", () => {
        if (!scanning) {
            barcodeReaderResults.innerText = "";
            startVideoMarkout();
        }
    });
});
