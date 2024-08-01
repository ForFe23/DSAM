<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escáner de Código QR</title>
    <style type="text/css">
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            overflow: hidden;
        }

        #container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        #videoWrapper {
            width: 80%;
            height: 50vh;
            overflow: hidden;
            position: relative;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            margin-bottom: 20px;
        }

        #videoElement,
        #canvas {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #buttonsWrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 80%;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        form>input {
            margin: 5px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form>input:hover {
            background-color: #007bff;
            color: #ffffff;
        }

        #results {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid;
            background: #ccc;
        }
    </style>
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
<a href="../dashboard/index" class="btn btn-primary">Volver</a>
    <div id="container">
        
        <div id="videoWrapper">
            <video id="videoElement" autoplay></video>
            <canvas id="canvas" style="display: none;"></canvas>
        </div>

        <!-- Botones para cambiar de cámara y activar/desactivar el flash -->
        <div id="buttonsWrapper">

            <form>

                <input type="button" style="display: none;" value="Cambiar Cámara" onClick="switchCamera()">
                <input type="button" id="flashOnButton" value="Encender Flash" onClick="turnOnFlash()">
                <input type="button" id="flashOffButton" value="Apagar Flash" onClick="turnOffFlash()" style="display: none;">
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.3.1/dist/jsQR.min.js"></script>

    <script language="JavaScript">
        let video = document.getElementById('videoElement');
        let canvas = document.getElementById('canvas');
        let ctx = canvas.getContext('2d');
        let currentCamera = 'environment'; // cámara predeterminada (trasera)
        let scanningInterval;
        let isFlashOn = false;

        function scanQRCode() {
            try {
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                let code = jsQR(imageData.data, imageData.width, imageData.height, {
                    inversionAttempts: 'dontInvert',
                });

                if (code) {
                    clearInterval(scanningInterval); // Detener el escaneo una vez que se encuentra un código válido
                    // Redirigir a Scanner.php con el código QR como parámetro
                    window.location.href = '../equipos/read/otro?code=' + encodeURIComponent(code.data);
                }
            } catch (error) {
                console.error('Error al escanear el código QR: ' + error.message);
            }
        }

        function switchCamera() {
            currentCamera = currentCamera === 'environment' ? 'user' : 'environment';
            navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: currentCamera
                    }
                })
                .then(function(stream) {
                    video.srcObject = stream;
                    video.onloadedmetadata = function() {
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        scanningInterval = setInterval(scanQRCode, 100); // Llamar a scanQRCode cada 100ms
                    };
                })
                .catch(function(err) {
                    console.error("Error al cambiar de cámara: ", err);
                });
        }

        function turnOnFlash() {
            let track = video.srcObject.getVideoTracks()[0];
            let capabilities = track.getCapabilities();
            if (capabilities.torch) {
                track.applyConstraints({
                    advanced: [{
                        torch: true
                    }]
                });
                document.getElementById('flashOnButton').style.display = 'none';
                document.getElementById('flashOffButton').style.display = 'inline-block';
                isFlashOn = true;
            } else {
                console.error("El flash no está disponible en este dispositivo.");
            }
        }

        function turnOffFlash() {
            window.location.reload(); // Recarga la página para apagar el flash
        }

        // Obtener el stream de la cámara trasera por defecto
        navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'environment'
                }
            })
            .then(function(stream) {
                video.srcObject = stream;
                video.onloadedmetadata = function() {
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    scanningInterval = setInterval(scanQRCode, 100); // Llamar a scanQRCode cada 100ms
                };
            })
            .catch(function(err) {
                console.error("Error al acceder a la cámara: ", err);
            });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>