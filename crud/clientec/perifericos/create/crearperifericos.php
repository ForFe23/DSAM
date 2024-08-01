<?php

session_start();

if (isset($_SESSION['CARGOUSUARIO']) && $_SESSION['CARGOUSUARIO'] === 'TRGRTNRS') {
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
    <link rel="stylesheet" href="../../../../Style/styleEdCr.css" />
    <link rel="stylesheet" href="../../../../Style/style.css" />
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">

</head>

<body>

    <?php
    function actualizarEquipo($idEquipo)
    {

        include 'connection.php';
        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }
        //*******
        //OBTENER SERIE EQUIPO
        //*******
        $sqlObtenerSerie = "SELECT SERIEEQUIPO FROM EQUIPO WHERE ID=$idEquipo;";
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



        // Preparar la consulta SQL para actualizar un equipo existente
        $sql = "INSERT INTO PERIFERICOS 
        (ID, SERIEEQUIPO, SERIEMONITOR, ACTIVOMONITOR, MARCAMONITOR, MODELOMONITOR, OBSERVACIONMONITOR, 
         SERIETECLADO, ACTIVOTECLADO, MARCATECLADO, MODELOTECLADO, OBSERVACIONTECLADO, 
         SERIEMOUSE, ACTIVOMOUSE, MARCAMOUSE, MODELOMOUSE, OBSERVACIONMOUSE, 
         SERIETELEFONO, ACTIVOTELEFONO, MARCATELEFONO, MODELOTELEFONO, OBSERVACIONTELEFONO, 
         CLIENTEPERIFERICOS)
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
        '$CLIENTEPERIFERICOS')";


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

    $servername = "localhost";
    $username = "root";
    $password = ""; // Deja esto vacío si no tienes contraseña
    $dbname = "basedap";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Obtener el ID del equipo de la URL
    if (isset($_GET['id_equipo'])) {
        $idEquipo = $_GET['id_equipo'];




        $sql2 = "SELECT * FROM PERIFERICOS WHERE ID= $idEquipo"; // Asegúrate de completar tu consulta SQL con las condiciones necesarias

        $res = $conn->query($sql2);

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc(); // Obtén la fila de resultados


        }
        //*********
        //CONSULTA DE OPCIONES
        //*********
        function obtenerOpciones($columna, $tabla)
        {
            $servername = "localhost";
            $username = "root";
            $password = ""; // Deja esto vacío si no tienes contraseña
            $dbname = "basedap";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

            $opciones = [];

            $result = $conn->query("SELECT DISTINCT $columna FROM $tabla");

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $opciones[] = $row[$columna];
                }
            }

            return $opciones;
        }
        //*********
        //OPCIONES EN FORMULARIO
        //*********
        $SERIEMONITOROPCION = obtenerOpciones('SERIEMONITOR', 'PERIFERICOS');
        $MODELOMONITOROPCION = obtenerOpciones('MODELOMONITOR', 'PERIFERICOS');
        $MARCAMONITOROPCION = obtenerOpciones('MARCAMONITOR', 'PERIFERICOS');
        $estados = ['ACTIVO', 'INACTIVO'];
        $estados2 = ['ACTIVO', 'INACTIVO'];
        $MODELOMONITOROPCION = obtenerOpciones('MODELOMONITOR', 'PERIFERICOS');
        $OBSERVACIONMONITOROPCION = obtenerOpciones('OBSERVACIONMONITOR', 'PERIFERICOS');
        $SERIETECLADOOPCION = obtenerOpciones('SERIETECLADO', 'PERIFERICOS');
        $MARCATECLADOOPCION = obtenerOpciones('MARCATECLADO', 'PERIFERICOS');
        $OBSERVACIONTECLADOOPCION = obtenerOpciones('OBSERVACIONTECLADO', 'PERIFERICOS');
        $MODELOTECLADOOPCION = obtenerOpciones('MODELOTECLADO', 'PERIFERICOS');
        $SERIEMOUSEOPCION = obtenerOpciones('SERIEMOUSE', 'PERIFERICOS');
        $MARCAMOUSEOPCION = obtenerOpciones('MARCAMOUSE', 'PERIFERICOS');
        $OBSERVACIONMOUSEOPCION = obtenerOpciones('OBSERVACIONMOUSE', 'PERIFERICOS');
        $MODELOMOUSEOPCION = obtenerOpciones('MODELOMOUSE', 'PERIFERICOS');
        $SERIETELEFONOOPCION = obtenerOpciones('SERIETELEFONO', 'PERIFERICOS');
        $marcaTelefonoOpcionesOPCION = obtenerOpciones('MARCATELEFONO', 'PERIFERICOS');
        $MODELOTELEFONOOPCION = obtenerOpciones('MODELOTELEFONO', 'PERIFERICOS');
        $OBSERVACIONTELEFONOOPCION = obtenerOpciones('OBSERVACIONTELEFONO', 'PERIFERICOS');
        $CLIENTEPERIFERICOSOPCION = obtenerOpciones('CLIENTEPERIFERICOS', 'PERIFERICOS');

    ?>



        <center>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <!-- Agrega este bloque de código al formulario -->
                <label for="serieEquipo">Serie del Monitor:</label>
                <input type="text" name="serieEquipo" list="serieEquipoList" oninput="this.value = this.value.toUpperCase()">
                <datalist id="serieEquipoList">
                    <?php foreach ($SERIEMONITOROPCION as $SERIEMONITOROPCION) : ?>
                        <option value="<?php echo $SERIEMONITOROPCION; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>


                <label for="marcaEquipo">Activo Monitor:</label>
                <select name="marcaEquipo">
                    <option value="ACTIVO">ACTIVO</option>
                    <option value="INACTIVO">INACTIVO</option>
                </select>
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
                <br>
                <label for="serieTeclado">Serie del Teclado:</label>
                <input type="text" name="serieTeclado" list="serieTecladoList" oninput="this.value = this.value.toUpperCase()">
                <datalist id="serieTecladoList">
                    <?php foreach ($SERIETECLADOOPCION as $SERIETECLADOOPCION) : ?>
                        <option value="<?php echo $SERIETECLADOOPCION; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <label for="ActividadTeclado">Activo Teclado:</label>
                <select name="ActividadTeclado">
                    <option value="ACTIVO">ACTIVO</option>
                    <option value="INACTIVO">INACTIVO</option>
                </select>
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
                <br>
                <label for="SerieMouse">Serie del Mouse:</label>
                <input type="text" name="SerieMouse" list="SerieMouseList" oninput="this.value = this.value.toUpperCase()">
                <datalist id="SerieMouseList">
                    <?php foreach ($SERIEMOUSEOPCION as $SERIEMOUSEOPCION) : ?>
                        <option value="<?php echo $SERIEMOUSEOPCION; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <label for="ActividadMouse">Actividad del Mouse:</label>
                <select name="ActividadMouse">
                    <option value="ACTIVO">ACTIVO</option>
                    <option value="INACTIVO">INACTIVO</option>
                </select>
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
                <label for="SerieTelefono">Serie del Telefono:</label>
                <input type="text" name="SerieTelefono" list="SerieTelefonoList" oninput="this.value = this.value.toUpperCase()">
                <datalist id="SerieTelefonoList">
                    <?php foreach ($SERIETELEFONOOPCION as $SERIETELEFONOOPCION) : ?>
                        <option value="<?php echo $SERIETELEFONOOPCION; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <label for="ActividadTelefono">Actividad del Telefono:</label>

                <select name="ActividadTelefono">
                    <option value="ACTIVO">ACTIVO</option>
                    <option value="INACTIVO">INACTIVO</option>
                </select>
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
                <label for="PerifericoCliente">Perifericos del Cliente :</label>
                <input type="text" name="PerifericoCliente" list="PerifericoClienteList" oninput="this.value = this.value.toUpperCase()">
                <datalist id="PerifericoClienteList">
                    <?php foreach ($CLIENTEPERIFERICOSOPCION as $CLIENTEPERIFERICOSOPCION) : ?>
                        <option value="<?php echo $CLIENTEPERIFERICOSOPCION; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <input type="submit" value="Actualizar Equipo">
                <!-- Campo oculto para el ID del equipo -->
                <input type="hidden" name="id_equipo" value="<?php echo $idEquipo; ?>">
            </form>
        </center>
    <?php
    } else {
        echo "No se encontraron resultados.";
    }

    $conn->close();

    ?>
    <script>
        document.querySelector('form').onsubmit = function() {
            var inputs = document.querySelectorAll('input[type="text"]');
            var emptyInputs = [];
            var emptyInputNames = [];

            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].value.trim() === '') {
                    emptyInputs.push(inputs[i]);
                    emptyInputNames.push(inputs[i].getAttribute('name'));
                }
            }

            if (emptyInputs.length === inputs.length) {
                alert('Por favor, llena todos los campos. No puedes enviar un formulario en blanco.');
                return false;
            } else if (emptyInputs.length > 0) {
                var missingFieldsMsg = 'Te faltan datos en los siguientes campos:\n\n';
                for (var j = 0; j < emptyInputNames.length; j++) {
                    missingFieldsMsg += emptyInputNames[j] + '\n';
                }
                missingFieldsMsg += '\n¿Estás seguro de enviar el formulario?';
                var confirmSubmit = confirm(missingFieldsMsg);
                if (!confirmSubmit) {
                    return false;
                }
            }
        };
    </script>

</body>

</html>