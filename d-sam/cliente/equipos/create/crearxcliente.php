<?php

session_start();

if (isset($_SESSION['CARGOUSUARIO']) && $_SESSION['CARGOUSUARIO'] === 'CMPRSGRS') {
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../style/styleedcr.css" />
    <script src="../../../../scripts/botonmostrar.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="../../../../scripts/adminread.js"></script>
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
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

    // Capturar el idCliente por primera vez o desde la cookie
    if (isset($_GET['idCliente'])) {
        // Si se proporciona por primera vez, establecer la cookie
        setcookie('idCliente', $_GET['idCliente'], time() + (86400 * 30), "/"); // La cookie se mantiene por 30 días
    } elseif (isset($_COOKIE['idCliente'])) {
        // Si ya existe la cookie, usar su valor
        $idCliente = $_COOKIE['idCliente'];
    } else {
        // Si no se proporciona y no hay cookie, mostrar un mensaje de error o redirigir a otra página
        die("Error: El idCliente no está especificado.");
    }
    // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include '../../../../php/connection.php';

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }





        // Recuperar los datos del formulario
        // Recuperar los datos del formulario
        $serieequipo = $_POST['serieEquipo'];
        // Verificar si ya existe un registro con la misma serie de equipo en la base de datos
        $sql_validar = "SELECT * FROM equipo WHERE serieequipo = '$serieequipo'";
        $result_validar = $conn->query($sql_validar);

        if ($result_validar->num_rows > 0) {
            // Si ya existe un registro con la misma serie de equipo, mostrar una alerta
            echo '<script>alert("ALERTA: Ya existe esta serie de equipo registrada.");</script>';
            // Regresar al formulario sin realizar la inserción
            echo '<script>window.history.back();</script>';
            return;
        }


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
            $statusEquipo = 'ACTIVO';
        }
        $ipEquipo = $_POST['ipEquipo'];
        $ubicacionUsuario = $_POST['ubicacionUsuario'];
        $depUsuario = $_POST['depUsuario'];
        $nombreUsuario = $_POST['nombreUsuario'];
        $nombreProveedor = $_POST['nombreProveedor'];
        $direccionProveedor = $_POST['direccionProveedor'];
        $telefonoProveedor = $_POST['telefonoProveedor'];
        $contactoProveedor = $_POST['contactoProveedor'];
        $cliente = $idCliente;
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
        // Preparar la consulta SQL para insertar un nuevo equipo
        $sql = "INSERT INTO equipo (SERIEEQUIPO,IDCLIENTE, MARCAEQUIPO, MODELOEQUIPO, TIPOEQUIPO, SOEQUIPO, PROCESADOREQUIPO, MEMORIAEQUIPO, HDDEQUIPO, FCOMPRAEQUIPO, STATUSEQUIPO, IPEQUIPO, UBICACIONUSUARIO, DEPUSUARIO, NOMBREUSUARIO, NOMBREPROVEEDOR, DIRECCIONPROVEEDOR, TELEFONOPROVEEDOR, CONTACTOPROVEEDOR, CLIENTE, ACTIVOEQUIPO, OFFICEEQUIPO, COSTOEQUIPO, FACTURAEQUIPO, NOTASEQUIPO, CIUDADEQUIPO, NOMBREEQUIPO) 
                VALUES ('$serieequipo',$idCliente, '$marcaEquipo', '$modeloEquipo', '$tipoEquipo', '$soEquipo', '$procesadorEquipo', '$memoriaEquipo', '$hddEquipo', '$fCompraEquipo', '$statusEquipo', '$ipEquipo', '$ubicacionUsuario', '$depUsuario', '$nombreUsuario', '$nombreProveedor', '$direccionProveedor', '$telefonoProveedor', '$contactoProveedor', '$cliente', '$activoEquipo', '$officeEquipo', '$costoEquipo', '$facturaEquipo', '$notasEquipo', '$ciudadEquipo', '$nombreEquipo')";

        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Equipo creado exitosamente."); window.location.href = "../../equipos/read/otro?idCliente=' . $idCliente . '";</script>';
        } else {
            echo '<p>Error al crear el equipo: ' . $conn->error . '</p>';
        }


        // Cerrar la conexión
        $conn->close();
    }


    function obtenerOpciones($columna, $tabla, $idCliente)
    {
        include '../../../../php/connection.php';

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        $opciones = [];

        $result = $conn->query("SELECT DISTINCT $columna FROM $tabla WHERE IDCLIENTE = $idCliente ;");


        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $opciones[] = $row[$columna];
            }
        }

        $conn->close();

        return $opciones;
    }

    // Obtener opciones de clientes
    $clientes = obtenerOpciones('NOMBRECLIENTE', 'cliente', $idCliente);

    // Obtener opciones de marcas
    $marcas = obtenerOpciones('MARCAEQUIPO', 'equipo', $idCliente);

    // Obtener opciones de modelos
    $modelos = obtenerOpciones('MODELOEQUIPO', 'equipo', $idCliente);

    // Obtener opciones de tipos de equipo
    $tiposEquipo = obtenerOpciones('TIPOEQUIPO', 'equipo', $idCliente);

    // Obtener opciones de estados
    $estados = ['ACTIVO', 'INACTIVO'];

    // Obtener opciones de usuarios
    $usuarios = obtenerOpciones('NOMBREUSUARIO', 'equipo', $idCliente);

    // Obtener opciones de versiones de Office
    $versionesOffice = obtenerOpciones('OFFICEEQUIPO', 'equipo', $idCliente);

    // Obtener opciones de procesadores
    $procesadores = obtenerOpciones('PROCESADOREQUIPO', 'equipo', $idCliente);

    // Obtener opciones de discos duros
    $hdds = obtenerOpciones('HDDEQUIPO', 'equipo', $idCliente);

    // Obtener opciones de memoria RAM
    $ram = obtenerOpciones('MEMORIAEQUIPO', 'equipo', $idCliente);

    // Obtener opciones de sistemas operativos
    $sistemasOperativos = obtenerOpciones('SOEQUIPO', 'equipo', $idCliente);
    ?>
    <a class="btn btn-primary" href="../read/otro">Volver</a>
    <center>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <!-- Pantalla 1 -->
            <div id="pantalla1">
                <h2>Datos Marca</h2>
                <label for="serieEquipo">Serie del Equipo:</label>
                <input type="text" name="serieEquipo" oninput="this.value = this.value.toUpperCase()"><br>
                <label for="activoEquipo">Activo del Equipo:</label>
                <input type="text" name="activoEquipo" oninput="this.value = this.value.toUpperCase()">
                <label for="marcaEquipo">Marca del Equipo:</label>
                <input type="text" name="marcaEquipo" list="marcasList" oninput="this.value = this.value.toUpperCase()">
                <datalist id="marcasList">
                    <?php foreach ($marcas as $marca) : ?>
                        <option value="<?php echo $marca; ?>">
                        <?php endforeach; ?>
                </datalist>
                <label for="modeloEquipo">Modelo del Equipo:</label>
                <input type="text" name="modeloEquipo" list="modelosList" oninput="this.value = this.value.toUpperCase()">
                <datalist id="modelosList">
                    <?php foreach ($modelos as $modelo) : ?>
                        <option value="<?php echo $modelo; ?>">
                        <?php endforeach; ?>
                </datalist>
                <label for="nombreEquipo">Nombre del Equipo:</label>
                <input type="text" name="nombreEquipo" oninput="this.value = this.value.toUpperCase()"><br>
                <label for="tipoEquipo">Tipo de Equipo:</label>
                <input type="text" name="tipoEquipo" list="tiposEquipoList" oninput="this.value = this.value.toUpperCase()">
                <datalist id="tiposEquipoList">
                    <?php foreach ($tiposEquipo as $tipoEquipo) : ?>
                        <option value="<?php echo $tipoEquipo; ?>">
                        <?php endforeach; ?>
                </datalist>
                <button type="button" onclick="nextStep('pantalla1', 'pantalla2')">Siguiente</button>
            </div>

            <!-- Pantalla 2 -->
            <div id="pantalla2" class="hidden">
                <h2>Datos de Hardware</h2>
                <label for="procesadorEquipo">Procesador:</label>
                <input type="text" name="procesadorEquipo" list="procesadoresList" oninput="this.value = this.value.toUpperCase()">
                <datalist id="procesadoresList">
                    <?php foreach ($procesadores as $procesador) : ?>
                        <option value="<?php echo $procesador; ?>">
                        <?php endforeach; ?>
                </datalist>
                <label for="memoriaEquipo">Memoria RAM:</label>
                <input type="text" name="memoriaEquipo" list="ramList" oninput="this.value = this.value.toUpperCase()">
                <datalist id="ramList">
                    <?php foreach ($ram as $memoria) : ?>
                        <option value="<?php echo $memoria; ?>">
                        <?php endforeach; ?>
                </datalist>
                <label for="hddEquipo">Disco Duro:</label>
                <input type="text" name="hddEquipo" list="hddsList" oninput="this.value = this.value.toUpperCase()">
                <datalist id="hddsList">
                    <?php foreach ($hdds as $hdd) : ?>
                        <option value="<?php echo $hdd; ?>">
                        <?php endforeach; ?>
                </datalist>
                <label for="ipEquipo">Dirección IP:</label>
                <input type="text" name="ipEquipo" oninput="this.value = this.value.toUpperCase()"><br>
                <label for="soEquipo">Sistema Operativo:</label>
                <input type="text" name="soEquipo" list="sistemasOperativosList" oninput="this.value = this.value.toUpperCase()">
                <datalist id="sistemasOperativosList">
                    <?php foreach ($sistemasOperativos as $soEquipo) : ?>
                        <option value="<?php echo $soEquipo; ?>">
                        <?php endforeach; ?>
                </datalist>
                <label for="officeEquipo">Versión de Office:</label>
                <input type="text" name="officeEquipo" list="versionesOfficeList" oninput="this.value = this.value.toUpperCase()">
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
                <label for="fCompraEquipo">Fecha de Compra del Equipo:</label>
<input type="date" name="fCompraEquipo" id="fCompraEquipo">
<button type="button" onclick="ponerFechaActual()">Fecha Actual</button>

                <br>
                <label for="statusEquipo">Estado del Equipo:</label>
                <select name="statusEquipo">
                    <option value="" disabled selected hidden>Selecciona un estado</option>
                    <?php foreach ($estados as $estado) : ?>
                        <option value="<?php echo $estado; ?>"><?php echo $estado; ?></option>
                    <?php endforeach; ?>
                </select>
                <br>
                <label for="nombreProveedor">Nombre del Proveedor:</label>
                <input type="text" name="nombreProveedor" oninput="this.value = this.value.toUpperCase()">
                <label for="direccionProveedor">Dirección del Proveedor:</label>
                <input type="text" name="direccionProveedor" oninput="this.value = this.value.toUpperCase()">
                <label for="telefonoProveedor">Teléfono del Proveedor:</label>
                <input type="text" name="telefonoProveedor" oninput="this.value = this.value.toUpperCase()">
                <label for="contactoProveedor">email del Proveedor:</label>
                <input type="text" name="contactoProveedor" oninput="this.value = this.value.toUpperCase()">
                <label for="notasEquipo">Notas:</label>
                <input name="notasEquipo" rows="4" oninput="this.value = this.value.toUpperCase()"></input>
                <button type="button" onclick="prevStep('pantalla3', 'pantalla2')">Anterior</button>
                <button type="button" onclick="nextStep('pantalla3', 'pantalla4')">Siguiente</button>
            </div>

            <!-- Pantalla 4 -->
            <div id="pantalla4" class="hidden">
                <h2>Datos de area</h2>
                <label for="ciudadEquipo">Ciudad del Equipo:</label>
                <input type="text" name="ciudadEquipo" oninput="this.value = this.value.toUpperCase()">

                <label for="nombreUsuario">Nombre del Usuario:</label>
                <input type="text" name="nombreUsuario" list="usuariosList" oninput="this.value = this.value.toUpperCase()">
                <datalist id="usuariosList">
                    <?php foreach ($usuarios as $usuario) : ?>
                        <option value="<?php echo $usuario; ?>">
                        <?php endforeach; ?>
                </datalist>
                <label for="depUsuario">Departamento del Usuario:</label>
                <input type="text" name="depUsuario" oninput="this.value = this.value.toUpperCase()">
                <label for="ubicacionUsuario">Ubicación del Usuario:</label>
                <input type="text" name="ubicacionUsuario" oninput="this.value = this.value.toUpperCase()">
                <button type="button" onclick="prevStep('pantalla4', 'pantalla3')">Anterior</button>
                <button type="button" onclick="nextStep('pantalla4', 'pantalla5')">Siguiente</button>
            </div>

            <!-- Pantalla 5 -->
            <div id="pantalla5" class="hidden">
                <h2>Datos de facturacion</h2>
                <label for="costoEquipo">Costo del Equipo:</label>
                <input type="text" name="costoEquipo" oninput="this.value = this.value.toUpperCase()">
                <label for="facturaEquipo">Número de Factura:</label>
                <input type="text" name="facturaEquipo" oninput="this.value = this.value.toUpperCase()">

                <button type="button" onclick="prevStep('pantalla5', 'pantalla4')">Anterior</button>
                <button onclick="finish()">Enviar Datos</button>
            </div>
        </form>

        <script>
        function ponerFechaActual() {
    var fechaInput = document.getElementById('fCompraEquipo');
    var hoy = new Date();
    var mes = ('0' + (hoy.getMonth() + 1)).slice(-2);
    var dia = ('0' + hoy.getDate()).slice(-2);
    var fechaFormateada = hoy.getFullYear() + '-' + mes + '-' + dia;
    fechaInput.value = fechaFormateada;
}

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
    // Construir la información a mostrar
    var confirmationInfo = "<p>Costo del Equipo: " + document.getElementsByName('costoEquipo')[0].value.trim() + "</p>";
    confirmationInfo += "<p>Nombre del Proveedor: " + document.getElementsByName('nombreProveedor')[0].value.trim() + "</p>";
    confirmationInfo += "<p>Teléfono del Proveedor: " + document.getElementsByName('telefonoProveedor')[0].value.trim() + "</p>";

    // Mostrar el contenedor con la información
    document.getElementById('confirmationInfo').innerHTML = confirmationInfo;
    document.getElementById('confirmationContainer').classList.remove('hidden');
}

function sendForm() {
    // Enviar el formulario
    document.querySelector('form').submit();
}

function editForm() {
    // Ocultar el contenedor de confirmación y volver al formulario
    document.getElementById('confirmationContainer').classList.add('hidden');
}


        document.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
            }
        });
    </script>
    <script>
        document.querySelector('form').onsubmit = function() {
            var inputs = document.querySelectorAll('input[type="text"]');
            var emptyInputs = [];
            var emptyInputNames = [];

            // Validar campos de texto vacíos
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].name !== 'idCliente' && inputs[i].value.trim() === '') {
                    emptyInputs.push(inputs[i]);
                    emptyInputNames.push(inputs[i].getAttribute('name'));
                }
            }

            // Validar fecha de compra
            var fechaCompra = document.querySelector('input[name="fCompraEquipo"]');
            if (!fechaCompra.value) {
                emptyInputs.push(fechaCompra);
                emptyInputNames.push('fCompraEquipo');
            }

            // Validar selección de estado del equipo
            var estadoEquipo = document.querySelector('select[name="statusEquipo"]');
            if (!estadoEquipo.value) {
                emptyInputs.push(estadoEquipo);
                emptyInputNames.push('statusEquipo');
            }

            // Mostrar mensaje de error si hay campos vacíos
            if (emptyInputs.length > 0) {
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