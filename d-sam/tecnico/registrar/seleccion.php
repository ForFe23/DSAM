<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecciona un Cliente</title>
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

        select {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
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
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
</head>

<body>
    <a href="../dashboard/index" class="btn btn-primary" type="button">Volver</a>
    
    <div id="container">
        <h1>Selecciona un Cliente</h1>
        <form method="post">
            <select name="cliente" id="clientesDropdown">
                <option value="error">Selecciona un cliente</option>
                <?php
                // Incluir archivo de conexión
                require_once '../../../php/connection.php';
                // Consulta para obtener clientes
                $sql = "SELECT * FROM cliente";
                $result = $conn->query($sql);

                // Imprimir opciones del dropdown
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["IDCLIENTE"] . "'>" . $row["NOMBRECLIENTE"] . "</option>";
                    }
                }

                // Cerrar la conexión
                $conn->close();
                ?>
            </select>
            <button type="button" onclick="mostrarModal()">Aceptar</button>
        </form>
    </div>

    <!-- Modal -->
    <div id="modal">
        <div id="modal-content">
            <p>¿Estás seguro de que quieres registrar un equipo para <span id="clienteSeleccionado"></span>?</p>
            <button onclick="redireccionar()">Sí</button>
            <button onclick="cerrarModal()">Cancelar</button>
        </div>
    </div>

    <script>
        // JavaScript para manejar la confirmación
        function mostrarModal() {
            const clienteSeleccionado = document.getElementById('clientesDropdown').value;
            const clienteNombre = document.getElementById('clientesDropdown').options[document.getElementById('clientesDropdown').selectedIndex].text;
            document.getElementById('clienteSeleccionado').textContent = clienteNombre;
            document.getElementById('modal').style.display = 'block';
        }

        function redireccionar() {
            const clienteSeleccionado = document.getElementById('clientesDropdown').value;
            window.location.href = '../equipos/create/crearxcliente?idCliente=' + clienteSeleccionado;
        }

        function cerrarModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>