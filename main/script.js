document.addEventListener("DOMContentLoaded", function() {
    const video = document.getElementById('video');
    const canvasElement = document.getElementById('canvas');
    const canvas = canvasElement.getContext('2d', { willReadFrequently: true }); // Añadir el atributo willReadFrequently
    const barcodeReaderResults = document.getElementById('barcode-reader-results');
    const stopButton = document.getElementById('stop-button');
    const restartButton = document.getElementById('restart-button');
    let videoStream = null;
    let scanning = true;


    function restartScanning(){
        startVideoStream();
    }

    function startVideoStream() {
        navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } }).then(function(stream) {
            video.srcObject = stream;
            videoStream = stream;
            video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
            video.play();
            requestAnimationFrame(tick);
        });
    }

    function tick() {
        if (!scanning) {
            return;
        }
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            canvasElement.height = video.videoHeight;
            canvasElement.width = video.videoWidth;
            canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
            const imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: "dontInvert",
            });

            if (code) {
                barcodeReaderResults.innerText = `Resultado: ${code.data}`;
                drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58");
                drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58");
                drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58");
                drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58");

                return; // Detener después de encontrar el código
            } else {
                barcodeReaderResults.innerText = "No se detectó ningún código QR.";
            }
        }
        requestAnimationFrame(tick);
    }

    function drawLine(begin, end, color) {
        canvas.beginPath();
        canvas.moveTo(begin.x, begin.y);
        canvas.lineTo(end.x, end.y);
        canvas.lineWidth = 4;
        canvas.strokeStyle = color;
        canvas.stroke();
    }

    function stopScanning() {
        scanning = false;
        if (videoStream) {
            videoStream.getTracks().forEach(track => track.stop());
        }
        video.srcObject = null;
    }



    stopButton.addEventListener('click', stopScanning);
    restartButton.addEventListener('click', restartScanning);
});
