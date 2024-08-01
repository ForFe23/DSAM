<?php

session_start();

if (isset($_SESSION['CARGOUSUARIO']) && $_SESSION['CARGOUSUARIO'] === 'CMPRSGRS') {
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
    <title>Crear Perifericos</title>
    <link rel="stylesheet" href="../../../../../style/styleedcr.css" />
    <link rel="stylesheet" href="../../../../../style/style.css" />
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
    <style>
        .hidden {
            display: none;
        }
    </style>
    <style scoped>
        .btn {
            text-decoration: none;
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-primary:focus,
        .btn-primary.focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
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
        $SERIEMONITOR = $_POST['serieEquipo'];
        $MODELOMONITOR = $_POST['modeloMonitor'];
        $MARCAMONITOR = $_POST['marcaMonitor'];
        $activoMonitor = $_POST['marcaEquipo'];
        $MODELOMONITOR = $_POST['modeloMonitor'];
        $OBSERVACIONMONITOR = $_POST['observacionMonitor'];
        $SERIETECLADO = $_POST['serieTeclado'];
        $MARCATECLADO = $_POST['MarcaTeclado'];
        $activoTeclado = $_POST['ActividadTeclado'];
        $OBSERVACIONTECLADO = $_POST['ObservacionTeclado'];
        $MODELOTECLADO = $_POST['ModeloTeclado'];
        $SERIEMOUSE = $_POST['SerieMouse'];
        $MARCAMOUSE = $_POST['MarcaMouse'];
        $OBSERVACIONMOUSE = $_POST['ObservacionMouse'];
        $activoMouse = $_POST['ActividadMouse'];
        $MODELOMOUSE = $_POST['ModeloMouse'];
        $SERIETELEFONO = $_POST['SerieTelefono'];
        $marcaTelefonoes = $_POST['MarcaTelefono'];
        $activoTelefono = $_POST['ActividadTelefono'];
        $MODELOTELEFONO = $_POST['ModeloTelefono'];
        $OBSERVACIONTELEFONO = $_POST['ObservacionTelefono'];
        $CLIENTEPERIFERICOS = $_POST['PerifericoCliente'];
        $idCliente = $_POST['id_cliente'];


        // Preparar la consulta SQL para actualizar un equipo existente
        $sql = "INSERT INTO perifericos 
        (ID, SERIEEQUIPO, SERIEMONITOR, ACTIVOMONITOR, MARCAMONITOR, MODELOMONITOR, OBSERVACIONMONITOR, 
         SERIETECLADO, ACTIVOTECLADO, MARCATECLADO, MODELOTECLADO, OBSERVACIONTECLADO, 
         SERIEMOUSE, ACTIVOMOUSE, MARCAMOUSE, MODELOMOUSE, OBSERVACIONMOUSE, 
         SERIETELEFONO, ACTIVOTELEFONO, MARCATELEFONO, MODELOTELEFONO, OBSERVACIONTELEFONO, 
         CLIENTEPERIFERICOS,IDCLIENTE)
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
        function obtenerOpciones($columna, $tabla, $idCliente)
        {
            include '../../../../../php/connection.php';

            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

            $opciones = [];

            $result = $conn->query("SELECT DISTINCT $columna FROM $tabla WHERE IDCLIENTE = $idCliente");

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $opciones[] = $row[$columna];
                }
            }

            return $opciones;
        }
        $idCliente = $_GET['id_cliente'];
        //*********
        //OPCIONES EN FORMULARIO
        //*********
        $SERIEMONITOROPCION = obtenerOpciones('SERIEMONITOR', 'perifericos', $idCliente);
        $MODELOMONITOROPCION = obtenerOpciones('MODELOMONITOR', 'perifericos', $idCliente);
        $MARCAMONITOROPCION = obtenerOpciones('MARCAMONITOR', 'perifericos', $idCliente);
        $estados = ['ACTIVO', 'INACTIVO'];
        $estados2 = ['ACTIVO', 'INACTIVO'];
        $MODELOMONITOROPCION = obtenerOpciones('MODELOMONITOR', 'perifericos', $idCliente);
        $OBSERVACIONMONITOROPCION = obtenerOpciones('OBSERVACIONMONITOR', 'perifericos', $idCliente);
        $SERIETECLADOOPCION = obtenerOpciones('SERIETECLADO', 'perifericos', $idCliente);
        $MARCATECLADOOPCION = obtenerOpciones('MARCATECLADO', 'perifericos', $idCliente);
        $OBSERVACIONTECLADOOPCION = obtenerOpciones('OBSERVACIONTECLADO', 'perifericos', $idCliente);
        $MODELOTECLADOOPCION = obtenerOpciones('MODELOTECLADO', 'perifericos', $idCliente);
        $SERIEMOUSEOPCION = obtenerOpciones('SERIEMOUSE', 'perifericos', $idCliente);
        $MARCAMOUSEOPCION = obtenerOpciones('MARCAMOUSE', 'perifericos', $idCliente);
        $OBSERVACIONMOUSEOPCION = obtenerOpciones('OBSERVACIONMOUSE', 'perifericos', $idCliente);
        $MODELOMOUSEOPCION = obtenerOpciones('MODELOMOUSE', 'perifericos', $idCliente);
        $SERIETELEFONOOPCION = obtenerOpciones('SERIETELEFONO', 'perifericos', $idCliente);
        $marcaTelefonoOpcionesOPCION = obtenerOpciones('MARCATELEFONO', 'perifericos', $idCliente);
        $MODELOTELEFONOOPCION = obtenerOpciones('MODELOTELEFONO', 'perifericos', $idCliente);
        $OBSERVACIONTELEFONOOPCION = obtenerOpciones('OBSERVACIONTELEFONO', 'perifericos', $idCliente);
        $CLIENTEPERIFERICOSOPCION = obtenerOpciones('CLIENTEPERIFERICOS', 'perifericos', $idCliente);

    ?>
        <a href="../../read/otro" class="btn btn-primary">

            Volver
        </a>
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

</body>

</html>