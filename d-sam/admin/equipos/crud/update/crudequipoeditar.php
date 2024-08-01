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
    <title>Actualizar Equipo</title>
    <link rel="stylesheet" href="../../../../../style/styleedcr.css" />
    <link rel="stylesheet" href="../../../../../style/style.css" />
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
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
    <style>
        .hidden {
            display: none;
        }

        .required-field {
            color: red;
            margin-left: 5px;
        }
    </style>
</head>

<body>

    <?php
    function actualizarEquipo($idEquipo)
    {
        // Resto del código de procesamiento del formulario...
        include '../../../../../php/connection.php';

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        $serieequipo = $_POST['serieEquipo'];

        $nombreCliente = $_POST['idCliente'];
        $marcaEquipo = $_POST['marcaEquipo'];
        $modeloEquipo = $_POST['modeloEquipo'];
        $tipoEquipo = $_POST['tipoEquipo'];
        $soEquipo = $_POST['soEquipo'];
        $procesadorEquipo = $_POST['procesadorEquipo'];
        $memoriaEquipo = $_POST['memoriaEquipo'];
        $hddEquipo = $_POST['hddEquipo'];
        $fCompraEquipo = $_POST['fCompraEquipo'];
        $statusEquipo = $_POST['statusEquipo'];
        if (empty($statusEquipo)) {
            $statusEquipo = $_POST['StatusEquipoHid'];
        }
        echo $_POST['StatusEquipoHid'];
        $ipEquipo = $_POST['ipEquipo'];
        $ubicacionUsuario = $_POST['ubicacionUsuario'];
        $depUsuario = $_POST['depUsuario'];
        $nombreUsuario = $_POST['nombreUsuario'];
        $nombreProveedor = $_POST['nombreProveedor'];
        $direccionProveedor = $_POST['direccionProveedor'];
        $telefonoProveedor = $_POST['telefonoProveedor'];
        $contactoProveedor = $_POST['contactoProveedor'];
        $activoEquipo = $_POST['activoEquipo'];
        $officeEquipo = $_POST['officeEquipo'];
        $costoEquipo = $_POST['costoEquipo'];
        $facturaEquipo = $_POST['facturaEquipo'];
        $notasEquipo = $_POST['notasEquipo'];
        $ciudadEquipo = $_POST['ciudadEquipo'];
        $nombreEquipo = $_POST['nombreEquipo'];
        if (empty($fCompraEquipo)) {
            // Establecer la fecha predeterminada si no se proporciona ninguna fecha
            $fCompraEquipo = '0000-01-01 00:00:00';
        }
        $conn->query("SET FOREIGN_KEY_CHECKS=0");

        // Ejecutar la consulta de actualización
        $sql = "UPDATE equipo 
        SET 
            SERIEEQUIPO = '$serieequipo',
            MARCAEQUIPO = '$marcaEquipo',
            MODELOEQUIPO = '$modeloEquipo',
            TIPOEQUIPO = '$tipoEquipo',
            SOEQUIPO = '$soEquipo',
            PROCESADOREQUIPO = '$procesadorEquipo',
            MEMORIAEQUIPO = '$memoriaEquipo',
            HDDEQUIPO = '$hddEquipo',
            FCOMPRAEQUIPO = '$fCompraEquipo',
            STATUSEQUIPO = '$statusEquipo',
            IPEQUIPO = '$ipEquipo',
            UBICACIONUSUARIO = '$ubicacionUsuario',
            DEPUSUARIO = '$depUsuario',
            NOMBREUSUARIO = '$nombreUsuario',
            NOMBREPROVEEDOR = '$nombreProveedor',
            DIRECCIONPROVEEDOR = '$direccionProveedor',
            TELEFONOPROVEEDOR = '$telefonoProveedor',
            CONTACTOPROVEEDOR = '$contactoProveedor',
            ACTIVOEQUIPO = '$activoEquipo',
            OFFICEEQUIPO = '$officeEquipo',
            COSTOEQUIPO = '$costoEquipo',
            FACTURAEQUIPO = '$facturaEquipo',
            NOTASEQUIPO = '$notasEquipo',
            CIUDADEQUIPO = '$ciudadEquipo',
            NOMBREEQUIPO = '$nombreEquipo'
        WHERE ID = $idEquipo";
        if ($conn->query($sql) === TRUE) {

            echo '<script>alert("Equipo actualizado exitosamente."); history.go(-2);</script>';
            exit(); // Es importante incluir exit() para asegurarse de que el script se detenga después de la redirección

        } else {
            echo "Error al actualizar el equipo: " . $conn->error;
        }

        // Volver a activar las restricciones de clave externa
        $conn->query("SET FOREIGN_KEY_CHECKS=1");
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



        $sql2 = "SELECT * FROM equipo WHERE ID= $idEquipo"; // Asegúrate de completar tu consulta SQL con las condiciones necesarias
        $res = $conn->query($sql2);

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc(); // Obtén la fila de resultados


        }

        function obtenerOpciones($columna, $tabla, $IdClienteOpcion)
        {
            include '../../../../../php/connection.php';
            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

            $opciones = [];

            $result = $conn->query("SELECT DISTINCT $columna FROM $tabla WHERE IDCLIENTE = $IdClienteOpcion");

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $opciones[] = $row[$columna];
                }
            }

            $conn->close();

            return $opciones;
        }
        $IdClienteOpcion = $_GET['id_cliente'];

        // Obtener opciones de clientes
        $clientes = obtenerOpciones('NOMBRECLIENTE', 'cliente', $IdClienteOpcion);

        // Obtener opciones de marcas
        $marcas = obtenerOpciones('MARCAEQUIPO', 'equipo', $IdClienteOpcion);

        // Obtener opciones de modelos
        $modelos = obtenerOpciones('MODELOEQUIPO', 'equipo', $IdClienteOpcion);

        // Obtener opciones de tipos de equipo
        $tiposEquipo = obtenerOpciones('TIPOEQUIPO', 'equipo', $IdClienteOpcion);

        // Obtener opciones de estados
        $estados = ['ACTIVO', 'BAJA'];

        // Obtener opciones de usuarios
        $usuarios = obtenerOpciones('NOMBREUSUARIO', 'equipo', $IdClienteOpcion);

        // Obtener opciones de versiones de Office
        $versionesOffice = obtenerOpciones('OFFICEEQUIPO', 'equipo', $IdClienteOpcion);

        // Obtener opciones de procesadores
        $procesadores = obtenerOpciones('PROCESADOREQUIPO', 'equipo', $IdClienteOpcion);

        // Obtener opciones de discos duros
        $hdds = obtenerOpciones('HDDEQUIPO', 'equipo', $IdClienteOpcion);

        // Obtener opciones de memoria RAM
        $ram = obtenerOpciones('MEMORIAEQUIPO', 'equipo', $IdClienteOpcion);

        // Obtener opciones de sistemas operativos
        $sistemasOperativos = obtenerOpciones('SOEQUIPO', 'equipo', $IdClienteOpcion);
        // Obtener la fecha del equipo y convertirla al formato ISO si no es nula
        $fechaCompraInput = $row['FCOMPRAEQUIPO'] ? date('Y-m-d', strtotime($row['FCOMPRAEQUIPO'])) : '';

    ?>

        <a onclick="VolverHistorial(this)" class="btn btn-primary">

            Volver
        </a>
        <center>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <!-- Pantalla 1 -->
                <div id="pantalla1">
                    <h2>Datos Marca</h2>
                    <label for="serieEquipo">Serie del Equipo:</label>
                    <input type="text" name="serieEquipo" value="<?php echo $row['SERIEEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <br>
                    <label for="activoEquipo">Activo del Equipo:</label>
                    <input type="text" name="activoEquipo" value="<?php echo $row['ACTIVOEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <br>
                    <label for="marcaEquipo">Marca del Equipo:</label>
                    <input type="text" name="marcaEquipo" list="marcasList" value="<?php echo $row['MARCAEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="marcasList">
                        <?php foreach ($marcas as $marca) : ?>
                            <option value="<?php echo $marca; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>
                    <label for="modeloEquipo">Modelo del Equipo:</label>
                    <input type="text" name="modeloEquipo" list="modelosList" value="<?php echo $row['MODELOEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="modelosList">
                        <?php foreach ($modelos as $modelo) : ?>
                            <option value="<?php echo $modelo; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>
                    <label for="tipoEquipo">Tipo de Equipo:</label>
                    <input type="text" name="tipoEquipo" list="tiposEquipoList" value="<?php echo $row['TIPOEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="tiposEquipoList">
                        <?php foreach ($tiposEquipo as $tipoEquipo) : ?>
                            <option value="<?php echo $tipoEquipo; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>
                    <label for="nombreEquipo">Nombre del Equipo:</label>
                    <input type="text" name="nombreEquipo" value="<?php echo $row['NOMBREEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">

                    <button type="button" onclick="nextStep('pantalla1', 'pantalla2')">Siguiente</button>
                </div>

                <!-- Pantalla 2 -->
                <div id="pantalla2" class="hidden">
                    <h2>Datos de Hardware</h2>
                    <br>
                    <label for="procesadorEquipo">Procesador:</label>
                    <input type="text" name="procesadorEquipo" list="procesadoresList" value="<?php echo $row['PROCESADOREQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="procesadoresList">
                        <?php foreach ($procesadores as $procesador) : ?>
                            <option value="<?php echo $procesador; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>
                    <label for="memoriaEquipo">Memoria RAM:</label>
                    <input type="text" name="memoriaEquipo" list="ramList" value="<?php echo $row['MEMORIAEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="ramList">
                        <?php foreach ($ram as $memoria) : ?>
                            <option value="<?php echo $memoria; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>
                    <label for="hddEquipo">Disco Duro:</label>
                    <input type="text" name="hddEquipo" list="hddsList" value="<?php echo $row['HDDEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="hddsList">
                        <?php foreach ($hdds as $hdd) : ?>
                            <option value="<?php echo $hdd; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>
                    <label for="ipEquipo">Dirección IP:</label>
                    <input type="text" name="ipEquipo" value="<?php echo $row['IPEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <br>
                    <label for="soEquipo">Sistema Operativo:</label>
                    <input type="text" name="soEquipo" list="sistemasOperativosList" value="<?php echo $row['SOEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="sistemasOperativosList">
                        <?php foreach ($sistemasOperativos as $soEquipo) : ?>
                            <option value="<?php echo $soEquipo; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <br>
                    <label for="officeEquipo">Versión de Office:</label>
                    <input type="text" name="officeEquipo" list="versionesOfficeList" value="<?php echo $row['OFFICEEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="versionesOfficeList">
                        <?php foreach ($versionesOffice as $versionOffice) : ?>
                            <option value="<?php echo $versionOffice; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <button type="button" onclick="prevStep('pantalla2', 'pantalla1')">Anterior</button>
                    <button type="button" onclick="nextStep('pantalla2', 'pantalla3')">Siguiente</button>
                </div>

                <!-- Pantalla 3 -->
                <div id="pantalla3" class="hidden">
                    <h2>Datos de seguimiento</h2>
                    <label for="fCompraEquipo">Fecha de Compra:</label>
                    <input type="date" name="fCompraEquipo" value="<?php echo $fechaCompraInput; ?>">
                    <label for="statusEquipo">Estado del Equipo:</label>
                    <select name="statusEquipo">
                        <option value="<?php $row['STATUSEQUIPO'] ?>" disabled selected> <?php echo $row['STATUSEQUIPO'] ?> </option>
                        <option value="ACTIVO">ACTIVO</option>
                        <option value="BAJA">BAJA</option>
                    </select>
                    <label for="nombreProveedor">Nombre del Proveedor:</label>
                    <input type="text" name="nombreProveedor" value="<?php echo $row['NOMBREPROVEEDOR']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <br>
                    <label for="direccionProveedor">Dirección del Proveedor:</label>
                    <input type="text" name="direccionProveedor" value="<?php echo $row['DIRECCIONPROVEEDOR']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <br>
                    <label for="telefonoProveedor">Teléfono del Proveedor:</label>
                    <input type="text" name="telefonoProveedor" value="<?php echo $row['TELEFONOPROVEEDOR']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <br>
                    <label for="contactoProveedor">Email del Proveedor:</label>
                    <input type="text" name="contactoProveedor" value="<?php echo $row['CONTACTOPROVEEDOR']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <label for="notasEquipo">Notas:</label>
                    <input name="notasEquipo" rows="4" value="<?php echo $row['NOTASEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()"></input>
                    <button type="button" onclick="prevStep('pantalla3', 'pantalla2')">Anterior</button>
                    <button type="button" onclick="nextStep('pantalla3', 'pantalla4')">Siguiente</button>
                </div>

                <!-- Pantalla 4 -->
                <div id="pantalla4" class="hidden">
                    <h2>Datos de area</h2>
                    <label for="ciudadEquipo">Ciudad del Equipo:</label>
                    <input type="text" name="ciudadEquipo" value="<?php echo $row['CIUDADEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <label for="ubicacionUsuario">Ubicación del Usuario:</label>
                    <input type="text" name="ubicacionUsuario" value="<?php echo $row['UBICACIONUSUARIO']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <br>
                    <label for="depUsuario">Departamento del Usuario:</label>
                    <input type="text" name="depUsuario" value="<?php echo $row['DEPUSUARIO']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <br>

                    <label for="nombreUsuario">Nombre del Usuario:</label>
                    <input type="text" name="nombreUsuario" list="usuariosList" value="<?php echo $row['NOMBREUSUARIO']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <datalist id="usuariosList">
                        <?php foreach ($usuarios as $usuario) : ?>
                            <option value="<?php echo $usuario; ?>">
                            <?php endforeach; ?>
                    </datalist>
                    <button type="button" onclick="prevStep('pantalla4', 'pantalla3')">Anterior</button>
                    <button type="button" onclick="nextStep('pantalla4', 'pantalla5')">Siguiente</button>
                </div>

                <!-- Pantalla 5 -->
                <div id="pantalla5" class="hidden">
                    <h2>Datos de facturacion</h2>
                    <label for="costoEquipo">Costo del Equipo:</label>
                    <input type="text" name="costoEquipo" value="<?php echo $row['COSTOEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <label for="facturaEquipo">Número de Factura:</label>
                    <input type="text" name="facturaEquipo" value="<?php echo $row['FACTURAEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                    <button type="button" onclick="prevStep('pantalla5', 'pantalla4')">Anterior</button>
                    <button onclick="finish()">Enviar Datos</button>
                </div>
                <input type="hidden" name="id_equipo" value="<?php echo $idEquipo; ?>">
                <input type="hidden" name="StatusEquipoHid" value="<?php echo $row['STATUSEQUIPO'] ?>">

            </form>

        </center>
    <?php
    } else {
        echo "No se encontraron resultados.";
    }

    $conn->close();

    ?>
    <script>
        function VolverHistorial(button) {
            history.go(-1);
        }
    </script>

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
            var costoEquipo = document.getElementsByName('costoEquipo')[0].value.trim();
            var nombreProveedor = document.getElementsByName('nombreProveedor')[0].value.trim();
            var telefonoProveedor = document.getElementsByName('telefonoProveedor')[0].value.trim();



            // Si al menos un campo está completo, envía el formulario
            document.querySelector('form').submit();
        }

        document.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
            }
        });
    </script>

</body>

</html>