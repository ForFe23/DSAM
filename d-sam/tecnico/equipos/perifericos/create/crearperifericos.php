<?php

session_start();

if (isset($_SESSION['CARGOUSUARIO']) && $_SESSION['CARGOUSUARIO'] === 'BLTRCPLS') {
    $idCliente = $_GET['id_cliente'];
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
    <title>Crear Equipo</title>
    <link rel="stylesheet" href="../../../../style/styleedcr.css" />
    <link rel="stylesheet" href="../../../../style/style.css" />
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .hidden {
            display: none;
        }
    </style>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            /* Fondo gris claro */
            padding: 20px;
            color: #333;
            /* Color de texto principal */
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            /* Fondo blanco para el formulario */
            padding: 20px;
            border-radius: 10px;
            /* Borde redondeado */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            /* Sombra suave */
        }

        label {
            display: block;
            /* Mostrar etiquetas en bloques separados */
            margin-bottom: 5px;
            /* Espaciado inferior entre etiquetas */
        }

        input[type="text"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            /* Espaciado inferior entre campos */
            border: 1px solid #ccc;
            /* Borde gris */
            border-radius: 5px;
            /* Borde redondeado */
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #007bff;
            /* Azul */
            color: #fff;
            /* Texto blanco */
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
            /* Azul más oscuro al pasar el mouse */
        }
    </style>

</head>

<body>

    <?php
    function actualizarEquipo($idEquipo)
    {
        include '../../../../../php/connection.php';

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }
        //*******
        //OBTENER SERIE EQUIPO
        //*******
        $sqlObtenerSerie = "SELECT SERIEEQUIPO FROM equipo WHERE ID=$idEquipo;";
        $resultadoObtenerSerie = $conn->query($sqlObtenerSerie);
        if ($resultadoObtenerSerie->num_rows > 0) {
            $busquedaSerie = $resultadoObtenerSerie->fetch_assoc(); // Obtén la fila de resultados


        }
        $resultadoBusqueda = $busquedaSerie['SERIEEQUIPO'];



        //*******
        //INSERTAR DATOS
        //*******
        $SERIEMONITOR = isset($_POST['serieEquipo']) ? $_POST['serieEquipo'] : '-';
        $MODELOMONITOR = isset($_POST['modeloMonitor']) ? $_POST['modeloMonitor'] : '-';
        $MARCAMONITOR = isset($_POST['marcaMonitor']) ? $_POST['marcaMonitor'] : '-';
        $activoMonitor = isset($_POST['marcaEquipo']) ? $_POST['marcaEquipo'] : '-';
        $MODELOMONITOR = isset($_POST['modeloMonitor']) ? $_POST['modeloMonitor'] : '-';
        $OBSERVACIONMONITOR = isset($_POST['observacionMonitor']) ? $_POST['observacionMonitor'] : '-';
        $SERIETECLADO = isset($_POST['serieTeclado']) ? $_POST['serieTeclado'] : '-';
        $MARCATECLADO = isset($_POST['MarcaTeclado']) ? $_POST['MarcaTeclado'] : '-';
        $activoTeclado = isset($_POST['ActividadTeclado']) ? $_POST['ActividadTeclado'] : '-';
        $OBSERVACIONTECLADO = isset($_POST['ObservacionTeclado']) ? $_POST['ObservacionTeclado'] : '-';
        $MODELOTECLADO = isset($_POST['ModeloTeclado']) ? $_POST['ModeloTeclado'] : '-';
        $SERIEMOUSE = isset($_POST['SerieMouse']) ? $_POST['SerieMouse'] : '-';
        $MARCAMOUSE = isset($_POST['MarcaMouse']) ? $_POST['MarcaMouse'] : '-';
        $OBSERVACIONMOUSE = isset($_POST['ObservacionMouse']) ? $_POST['ObservacionMouse'] : '-';
        $activoMouse = isset($_POST['ActividadMouse']) ? $_POST['ActividadMouse'] : '-';
        $MODELOMOUSE = isset($_POST['ModeloMouse']) ? $_POST['ModeloMouse'] : '-';
        $SERIETELEFONO = isset($_POST['SerieTelefono']) ? $_POST['SerieTelefono'] : '-';
        $marcaTelefonoes = isset($_POST['MarcaTelefono']) ? $_POST['MarcaTelefono'] : '-';
        $activoTelefono = isset($_POST['ActividadTelefono']) ? $_POST['ActividadTelefono'] : '-';
        $MODELOTELEFONO = isset($_POST['ModeloTelefono']) ? $_POST['ModeloTelefono'] : '-';
        $OBSERVACIONTELEFONO = isset($_POST['ObservacionTelefono']) ? $_POST['ObservacionTelefono'] : '-';
        $idCliente = $_POST['id_cliente'];
        $CLIENTEPERIFERICOS = isset($_POST['PerifericoCliente']) ? $_POST['PerifericoCliente'] : '-';




        // Preparar la consulta SQL para actualizar un equipo existente
        $sql = "INSERT INTO perifericos 
        (ID, SERIEEQUIPO, SERIEMONITOR, ACTIVOMONITOR, MARCAMONITOR, MODELOMONITOR, OBSERVACIONMONITOR, 
         SERIETECLADO, ACTIVOTECLADO, MARCATECLADO, MODELOTECLADO, OBSERVACIONTECLADO, 
         SERIEMOUSE, ACTIVOMOUSE, MARCAMOUSE, MODELOMOUSE, OBSERVACIONMOUSE, 
         SERIETELEFONO, ACTIVOTELEFONO, MARCATELEFONO, MODELOTELEFONO, OBSERVACIONTELEFONO, 
         CLIENTEPERIFERICOS, IDCLIENTE)
        VALUES 
        ('$idEquipo',
        '$resultadoBusqueda', 
        '$SERIEMONITOR',
        '$activoMonitor',
        '$MARCAMONITOR',
        '$MODELOMONITOR',
        '$OBSERVACIONMONITOR', 
        '$SERIETECLADO',
        '$activoTeclado',
        '$MARCATECLADO',
        '$MODELOTECLADO',
        '$OBSERVACIONTECLADO', 
        '$SERIEMOUSE',
        '$activoMouse',
        '$MARCAMOUSE',
        '$MODELOMOUSE',
        '$OBSERVACIONMOUSE', 
        '$SERIETELEFONO',
        '$activoTelefono',
        '$marcaTelefonoes',
        '$MODELOTELEFONO',
        '$OBSERVACIONTELEFONO', 
        '$CLIENTEPERIFERICOS',
        '$idCliente')";


        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("PERIFERICOS CREADOS  exitosamente."); history.go(-2);</script>';
        } else {
            echo '<p>Error al actualizar el equipo: ' . $conn->error . '</p>';
        }

        // Cerrar la conexión
        $conn->close();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verifica si el formulario ha sido enviado
        if (isset($_POST['id_equipo'])) {
            // Llama a la función solo si el ID del equipo está presente
            actualizarEquipo($_POST['id_equipo']);
        }
    }

    include '../../../../../php/connection.php';
    // Obtener el ID del equipo de la URL
    if (isset($_GET['id_equipo'])) {
        $idEquipo = $_GET['id_equipo'];




        $sql2 = "SELECT * FROM perifericos WHERE ID= $idEquipo"; // Asegúrate de completar tu consulta SQL con las condiciones necesarias

        $res = $conn->query($sql2);

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc(); // Obtén la fila de resultados


        }
        //*********
        //CONSULTA DE OPCIONES
        //*********
        function obtenerOpciones($columna, $tabla, $idClienteOpciones)
        {
            include '../../../../../php/connection.php';

            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

            $opciones = [];

            $result = $conn->query("SELECT DISTINCT $columna FROM $tabla WHERE IDCLIENTE = '$idClienteOpciones'");

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $opciones[] = $row[$columna];
                }
            }

            return $opciones;
        }
        $idClienteOpciones = $_GET['id_cliente'];
        //*********
        //OPCIONES EN FORMULARIO
        //*********
        $SERIEMONITOROPCION = obtenerOpciones('SERIEMONITOR', 'perifericos', $idClienteOpciones);
        $MODELOMONITOROPCION = obtenerOpciones('MODELOMONITOR', 'perifericos', $idClienteOpciones);
        $MARCAMONITOROPCION = obtenerOpciones('MARCAMONITOR', 'perifericos', $idClienteOpciones);
        $estados = ['ACTIVO', 'INACTIVO'];
        $estados2 = ['ACTIVO', 'INACTIVO'];
        $MODELOMONITOROPCION = obtenerOpciones('MODELOMONITOR', 'perifericos', $idClienteOpciones);
        $OBSERVACIONMONITOROPCION = obtenerOpciones('OBSERVACIONMONITOR', 'perifericos', $idClienteOpciones);
        $SERIETECLADOOPCION = obtenerOpciones('SERIETECLADO', 'perifericos', $idClienteOpciones);
        $MARCATECLADOOPCION = obtenerOpciones('MARCATECLADO', 'perifericos', $idClienteOpciones);
        $OBSERVACIONTECLADOOPCION = obtenerOpciones('OBSERVACIONTECLADO', 'perifericos', $idClienteOpciones);
        $MODELOTECLADOOPCION = obtenerOpciones('MODELOTECLADO', 'perifericos', $idClienteOpciones);
        $SERIEMOUSEOPCION = obtenerOpciones('SERIEMOUSE', 'perifericos', $idClienteOpciones);
        $MARCAMOUSEOPCION = obtenerOpciones('MARCAMOUSE', 'perifericos', $idClienteOpciones);
        $OBSERVACIONMOUSEOPCION = obtenerOpciones('OBSERVACIONMOUSE', 'perifericos', $idClienteOpciones);
        $MODELOMOUSEOPCION = obtenerOpciones('MODELOMOUSE', 'perifericos', $idClienteOpciones);
        $SERIETELEFONOOPCION = obtenerOpciones('SERIETELEFONO', 'perifericos', $idClienteOpciones);
        $marcaTelefonoOpcionesOPCION = obtenerOpciones('MARCATELEFONO', 'perifericos', $idClienteOpciones);
        $MODELOTELEFONOOPCION = obtenerOpciones('MODELOTELEFONO', 'perifericos', $idClienteOpciones);
        $OBSERVACIONTELEFONOOPCION = obtenerOpciones('OBSERVACIONTELEFONO', 'perifericos', $idClienteOpciones);
        $CLIENTEPERIFERICOSOPCION = obtenerOpciones('CLIENTEPERIFERICOS', 'perifericos', $idClienteOpciones);

    ?>
        <a class="btn btn-primary" onclick='Retroceder(this)'>Volver</a>
        <center>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <!-- Pantalla 1 -->
                <div id="pantalla1">

                    <h2>Datos Monitor</h2>
                    <label for="serieEquipo">Serie del Monitor:</label>
                    <input type="text" name="serieEquipo" list="serieEquipoList" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="serieEquipoList">
                        <?php foreach ($SERIEMONITOROPCION as $SERIEMONITOROPCION) : ?>
                            <option value="<?php echo $SERIEMONITOROPCION; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>


                    <label for="marcaEquipo">Activo Monitor:</label>

                    <input type="text" name="marcaEquipo" list="marcaEquipoList" oninput="this.value = this.value.toUpperCase()">
                    <br>

                    <label for="marcaMonitor">Marca del Monitor:</label>
                    <input type="text" name="marcaMonitor" list="marcaMonitor" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="marcaMonitor">
                        <?php foreach ($MARCAMONITOROPCION as $MARCAMONITOROPCION) : ?>
                            <option value="<?php echo $MARCAMONITOROPCION; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>
                    <label for="modeloMonitor">Modelo del Monitor:</label>
                    <input type="text" name="modeloMonitor" list="modeloMonitorList" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="modeloMonitorList">
                        <?php foreach ($MODELOMONITOROPCION as $MODELOMONITOROPCION) : ?>
                            <option value="<?php echo $MODELOMONITOROPCION; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>
                    <label for="observacionMonitor">Observacion del Monitor:</label>
                    <input type="text" name="observacionMonitor" list="observacionMonitorList" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="observacionMonitorList">
                        <?php foreach ($OBSERVACIONMONITOROPCION as $OBSERVACIONMONITOROPCION) : ?>
                            <option value="<?php echo $OBSERVACIONMONITOROPCION; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <button type="button" onclick="nextStep('pantalla1', 'pantalla2')">Siguiente</button>
                </div>

                <!-- Pantalla 2 -->
                <div id="pantalla2" class="hidden">

                    <h2>Datos Teclado</h2>
                    <label for="serieTeclado">Serie del Teclado:</label>
                    <input type="text" name="serieTeclado" list="serieTecladoList" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="serieTecladoList">
                        <?php foreach ($SERIETECLADOOPCION as $SERIETECLADOOPCION) : ?>
                            <option value="<?php echo $SERIETECLADOOPCION; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>
                    <label for="ActividadTeclado">Activo Teclado:</label>

                    <input type="text" name="ActividadTeclado" list="ActividadTecladoList" oninput="this.value = this.value.toUpperCase()">



                    <br>
                    <label for="MarcaTeclado">Marca del Teclado:</label>
                    <input type="text" name="MarcaTeclado" list="MarcaTecladoList" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="MarcaTecladoList">
                        <?php foreach ($MARCATECLADOOPCION as $MARCATECLADOOPCION) : ?>
                            <option value="<?php echo $MARCATECLADOOPCION; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>
                    <label for="ModeloTeclado">Modelo del Teclado:</label>
                    <input type="text" name="ModeloTeclado" list="ModeloTecladoList" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="ModeloTecladoList">
                        <?php foreach ($MODELOTECLADOOPCION as $MODELOTECLADOOPCION) : ?>
                            <option value="<?php echo $MODELOTECLADOOPCION; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>
                    <label for="ObservacionTeclado">Observacion del Teclado:</label>
                    <input type="text" name="ObservacionTeclado" list="ObservacionTecladoList" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="ObservacionTecladoList">
                        <?php foreach ($OBSERVACIONTECLADOOPCION as $OBSERVACIONTECLADOOPCION) : ?>
                            <option value="<?php echo $OBSERVACIONTECLADOOPCION; ?>">
                            <?php endforeach; ?>
                    </datalist>

                    <button type="button" onclick="prevStep('pantalla2', 'pantalla1')">Anterior</button>
                    <button type="button" onclick="nextStep('pantalla2', 'pantalla3')">Siguiente</button>
                </div>

                <!-- Pantalla 3 -->
                <div id="pantalla3" class="hidden">
                    <h2>Datos Mouse</h2>
                    <label for="SerieMouse">Serie del Mouse:</label>
                    <input type="text" name="SerieMouse" list="SerieMouseList" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="SerieMouseList">
                        <?php foreach ($SERIEMOUSEOPCION as $SERIEMOUSEOPCION) : ?>
                            <option value="<?php echo $SERIEMOUSEOPCION; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>
                    <label for="ActividadMouse">Activo Mouse:</label>

                    <input type="text" name="ActividadMouse" list="ActividadMouseList" oninput="this.value = this.value.toUpperCase()">
                    <br>
                    <label for="MarcaMouse">Marca del Mouse:</label>
                    <input type="text" name="MarcaMouse" list="MarcaMouseList" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="MarcaMouseList">
                        <?php foreach ($MARCAMOUSEOPCION as $MARCAMOUSEOPCION) : ?>
                            <option value="<?php echo $MARCAMOUSEOPCION; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>
                    <label for="ModeloMouse">Modelo del Mouse:</label>
                    <input type="text" name="ModeloMouse" list="ModeloMouseList" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="ModeloMouseList">
                        <?php foreach ($MODELOMOUSEOPCION as $MODELOMOUSEOPCION) : ?>
                            <option value="<?php echo $MODELOMOUSEOPCION; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>
                    <label for="ObservacionMouse">Observacion del Mouse:</label>
                    <input type="text" name="ObservacionMouse" list="ObservacionMouseList" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="ObservacionMouseList">
                        <?php foreach ($OBSERVACIONMOUSEOPCION as $OBSERVACIONMOUSEOPCION) : ?>
                            <option value="<?php echo $OBSERVACIONMOUSEOPCION; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>

                    <button type="button" onclick="prevStep('pantalla3', 'pantalla2')">Anterior</button>
                    <button type="button" onclick="nextStep('pantalla3', 'pantalla4')">Siguiente</button>
                </div>

                <!-- Pantalla 4 -->
                <div id="pantalla4" class="hidden">
                    <h2>Datos Telefono</h2>
                    <label for="SerieTelefono">Serie del Telefono:</label>
                    <input type="text" name="SerieTelefono" list="SerieTelefonoList" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="SerieTelefonoList">
                        <?php foreach ($SERIETELEFONOOPCION as $SERIETELEFONOOPCION) : ?>
                            <option value="<?php echo $SERIETELEFONOOPCION; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>
                    <label for="ActividadTelefono">Activo Telefono:</label>


                    <input type="text" name="ActividadTelefono" list="ActividadTelefonoList" oninput="this.value = this.value.toUpperCase()">
                    <br>
                    <label for="MarcaTelefono">Marca del Telefono:</label>
                    <input type="text" name="MarcaTelefono" list="MarcaTelefonoList" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="MarcaTelefonoList">
                        <?php foreach ($marcaTelefonoOpcionesOPCION as $marcaTelefonoOpcionesOPCION) : ?>
                            <option value="<?php echo $marcaTelefonoOpcionesOPCION; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>
                    <label for="ModeloTelefono">Modelo del Telefono:</label>
                    <input type="text" name="ModeloTelefono" list="ModeloTelefonoList" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="ModeloTelefonoList">
                        <?php foreach ($MODELOTELEFONOOPCION as $MODELOTELEFONOOPCION) : ?>
                            <option value="<?php echo $MODELOTELEFONOOPCION; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>
                    <label for="ObservacionTelefono">Observacion del Telefono:</label>
                    <input type="text" name="ObservacionTelefono" list="ObservacionTelefonoList" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="ObservacionTelefonoList">
                        <?php foreach ($OBSERVACIONTELEFONOOPCION as $OBSERVACIONTELEFONOOPCION) : ?>
                            <option value="<?php echo $OBSERVACIONTELEFONOOPCION; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>

                    <button type="button" onclick="prevStep('pantalla4', 'pantalla3')">Anterior</button>
                    <button type="button" onclick="nextStep('pantalla4', 'pantalla5')">Siguiente</button>
                </div>

                <!-- Pantalla 5 -->
                <div id="pantalla5" class="hidden">
                    <h2>Otros Perifericos</h2>
                    <label for="PerifericoCliente">Perifericos del Cliente :</label>
                    <input type="text" name="PerifericoCliente" list="PerifericoClienteList" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="PerifericoClienteList">
                        <?php foreach ($CLIENTEPERIFERICOSOPCION as $CLIENTEPERIFERICOSOPCION) : ?>
                            <option value="<?php echo $CLIENTEPERIFERICOSOPCION; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <input type="hidden" name="id_equipo" value="<?php echo $idEquipo; ?>">
                    <button type="button" onclick="prevStep('pantalla5', 'pantalla4')">Anterior</button>
                    <button onclick="finish()">Enviar Datos</button>
                </div>
                <!-- Campo oculto para el ID del equipo -->
                <input type="hidden" name="id_equipo" value="<?php echo $idEquipo; ?>">
                <input type="hidden" name="id_cliente" value="<?php echo $idCliente ?>">
            </form>
        </center>
    <?php
    } else {
        echo "No se encontraron resultados.";
    }

    $conn->close();

    ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        function nextStep(currentStepId, nextStepId) {
            // Obtener todos los campos de la pantalla actual
            var currentStepInputs = document.querySelectorAll(`#${currentStepId} input[type='text']`);
            var incompleteInputs = Array.from(currentStepInputs).filter(input => input.value.trim() === '');

            // Verificar si hay campos incompletos
            if (incompleteInputs.length > 0) {
                // Construir mensaje de alerta indicando los campos omitidos
                var missingFields = incompleteInputs.map(input => input.name).join(', ');
                var confirmation = confirm('Estás omitiendo los siguientes campos: ' + missingFields + '. ¿Deseas continuar?');
                if (!confirmation) {
                    return; // Detener el avance si el usuario elige no continuar
                }
            }

            // Ocultar pantalla actual y mostrar la siguiente
            document.getElementById(currentStepId).classList.add('hidden');
            document.getElementById(nextStepId).classList.remove('hidden');
        }

        function prevStep(currentStepId, prevStepId) {
            // Ocultar pantalla actual y mostrar la anterior
            document.getElementById(currentStepId).classList.add('hidden');
            document.getElementById(prevStepId).classList.remove('hidden');
        }

        function finish() {
            // Validar campos de la última pantalla
            var currentStepId = 'pantalla5';
            var currentStepInputs = document.querySelectorAll(`#${currentStepId} input[type='text']`);
            var allFieldsEmpty = Array.from(currentStepInputs).every(input => input.value.trim() === '');
            if (allFieldsEmpty) {
                alert('Completa al menos un campo antes de crear el equipo.');
                return;
            }

            // Si al menos un campo está completo, envía el formulario
            document.querySelector('form').submit();
        }
    </script>
    <script>
        function Retroceder(button) {
            window.history.go(-1);
        }
    </script>
</body>

</html>