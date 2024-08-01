<?php

session_start();

if (isset($_SESSION['CARGOUSUARIO']) && $_SESSION['CARGOUSUARIO'] === 'BLTRCPLS') {
    $idCliente = $_SESSION['IDCLIENTE'];
} else {

    header("Location: https://dapcomputer.com/");
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Equipo por Serie</title>
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
    <style>
        /* Estilos CSS para diseño responsivo */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        #container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
            text-align: center;
        }

        label {
            font-size: 16px;
            color: #333333;
            margin-bottom: 10px;
            display: block;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            margin: 0 auto;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Modal */
        #modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        #modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }

        #modal-content p {
            color: #333333;
            margin-bottom: 20px;
        }

        #modal-content button {
            margin: 0 10px;
        }

        #modal-content button:nth-child(1) {
            background-color: #28a745;
        }

        #modal-content button:nth-child(1):hover {
            background-color: #218838;
        }

        #modal-content button:nth-child(2) {
            background-color: #dc3545;
        }

        #modal-content button:nth-child(2):hover {
            background-color: #c82333;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <a href="../dashboard/index" class="btn btn-primary" >Volver</a>
    <div id="container">
        <h1>Buscar Equipo por Serie</h1>
        <form method="post">
            <label for="serie">Serie del Equipo:</label><br>
            <input type="text" id="serie" name="serie" required oninput="this.value = this.value.toUpperCase()"><br>
            <button type="button" id="buscarButton">Buscar</button>
        </form>
    </div>

    <!-- Modal -->
    <div id="modal">
        <div id="modal-content">
            <p id="modal-message"></p>
            <button id="confirmButton" onclick="redireccionar()">Sí</button>
            <button id="cancelButton" onclick="cerrarModal()">Cancelar</button>
        </div>
    </div>

    <script>
        // Función para mostrar el modal
        function mostrarModal() {
            const serieEquipo = document.getElementById('serie').value;

            // Realizar una petición AJAX para obtener la marca del equipo desde la base de datos
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        const marcaEquipo = xhr.responseText;
                        const modalMessage = document.getElementById('modal-message');
                        const confirmButton = document.getElementById('confirmButton');

                        if (marcaEquipo.trim() === 'No se encontró la marca del equipo.') {
                            modalMessage.textContent = 'Equipo no encontrado.';
                            confirmButton.style.display = 'none';
                        } else {
                            modalMessage.textContent = `¿Seguro quieres acceder al equipo con serie ${serieEquipo} y marca ${marcaEquipo}?`;
                            confirmButton.style.display = 'inline-block';
                        }
                        document.getElementById('modal').style.display = 'block';
                    } else {
                        console.error('Hubo un error al realizar la solicitud.');
                    }
                }
            };
            xhr.open("GET", "obtener_marca_equipo?serie=" + serieEquipo, true);
            xhr.send();
        }

        // Función para redireccionar
        function redireccionar() {
            const serieEquipo = document.getElementById('serie').value;
            window.location.href = '../equipos/read/otro?code=' + serieEquipo;
        }

        // Función para cerrar el modal
        function cerrarModal() {
            document.getElementById('modal').style.display = 'none';
        }

        // Agregar evento click al botón "Buscar"
        document.getElementById('buscarButton').addEventListener('click', mostrarModal);
    </script>
    
</body>

</html>