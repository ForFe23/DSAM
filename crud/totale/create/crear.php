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
    <link rel="stylesheet" href="../../../style/styleedcr.css" />
    <link rel="stylesheet" href="../../../style/style.css" />
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
        .hidden {
    display: none;
}

    </style>
</head>

<body>

    <?php
    function actualizarEquipo($idEquipo)
    {
        include '../../../php/connection.php';

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Obtener la serie del equipo del formulario POST
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
        // Consultar la base de datos para obtener más información sobre el cliente
        $sql22 = "SELECT * FROM cliente WHERE NOMBRECLIENTE = '$nombreCliente'";
        $result = $conn->query($sql22);

        if ($result->num_rows > 0) {
            while ($row5 = $result->fetch_assoc()) {

                $IDCLIENTE = $row5["IDCLIENTE"];

                // Puedes agregar más campos según la estructura de tu tabla de clientes
            }
        } else {
            echo "No se encontraron resultados para el ID de cliente proporcionado.";
        }
        // Preparar la consulta SQL para actualizar un equipo existente
        $sql = "INSERT INTO equipo (
            serieequipo, 
            idcliente, 
            marcaequipo, 
            modeloequipo, 
            tipoequipo, 
            soequipo, 
            procesadorequipo,
            memoriaequipo,
            hddequipo, 
            fcompraequipo, 
            statusequipo, 
            ipequipo, 
            ubicacionusuario,
            depusuario, 
            nombreusuario, 
            nombreproveedor, 
            direccionproveedor, 
            telefonoproveedor, 
            contactoproveedor, 
            activoequipo, 
            officeequipo, 
            costoequipo, 
            facturaequipo, 
            notasequipo, 
            ciudadequipo, 
            nombreequipo)
        VALUES ('$serieequipo', '$IDCLIENTE', '$marcaEquipo', '$modeloEquipo', '$tipoEquipo', '$soEquipo', '$procesadorEquipo', '$memoriaEquipo', '$hddEquipo', '$fCompraEquipo', '$statusEquipo', '$ipEquipo', '$ubicacionUsuario', '$depUsuario', '$nombreUsuario', '$nombreProveedor', '$direccionProveedor', '$telefonoProveedor', '$contactoProveedor', '$activoEquipo', '$officeEquipo', '$costoEquipo', '$facturaEquipo', '$notasEquipo', '$ciudadEquipo', '$nombreEquipo')";


        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Equipo creado exitosamente."); window.location.href = "../read/crudequipos";</script>';
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


    function obtenerOpciones($columna, $tabla)
    {
        include '../../../php/connection.php';

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

    // Obtener opciones de clientes
    $clientes = obtenerOpciones('NOMBRECLIENTE', 'cliente');

    // Obtener opciones de marcas
    $marcas = obtenerOpciones('MARCAEQUIPO', 'equipo');

    // Obtener opciones de modelos
    $modelos = obtenerOpciones('MODELOEQUIPO', 'equipo');

    // Obtener opciones de tipos de equipo
    $tiposEquipo = obtenerOpciones('TIPOEQUIPO', 'equipo');

    // Obtener opciones de estados
    $estados = ['ACTIVO', 'INACTIVO'];

    // Obtener opciones de usuarios
    $usuarios = obtenerOpciones('NOMBREUSUARIO', 'equipo');

    // Obtener opciones de versiones de Office
    $versionesOffice = obtenerOpciones('OFFICEEQUIPO', 'equipo');

    // Obtener opciones de procesadores
    $procesadores = obtenerOpciones('PROCESADOREQUIPO', 'equipo');

    // Obtener opciones de discos duros
    $hdds = obtenerOpciones('HDDEQUIPO', 'equipo');

    // Obtener opciones de memoria RAM
    $ram = obtenerOpciones('MEMORIAEQUIPO', 'equipo');

    // Obtener opciones de sistemas operativos
    $sistemasOperativos = obtenerOpciones('SOEQUIPO', 'equipo');

    ?>
    <a href="../read/crudequipos" class="btn btn-primary">
        Volver
    </a>
    <center>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

            <!-- Pantalla 1 -->
            <div id="pantalla1">
                <h2>Datos Marca</h2>
                <label for="serieEquipo">Serie del Equipo:</label>
                <input type="text" name="serieEquipo" oninput="this.value = this.value.toUpperCase()">
                <br>
                <label for="activoEquipo">Activo del Equipo:</label>
                <input type="text" name="activoEquipo" oninput="this.value = this.value.toUpperCase()">
                <br>
                <label for="idCliente">Cliente:</label>
                <select name="idCliente">
                    <option value="" disabled selected>Selecciona un cliente</option>
                    <?php foreach ($clientes as $cliente) : ?>
                        <option value="<?php echo $cliente; ?>"><?php echo $cliente; ?></option>
                    <?php endforeach; ?>
                </select>
                <br>
                <label for="marcaEquipo">Marca del Equipo:</label>
                <input type="text" name="marcaEquipo" list="marcasList" oninput="this.value = this.value.toUpperCase()">
                <datalist id="marcasList">
                    <?php foreach ($marcas as $marca) : ?>
                        <option value="<?php echo $marca; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <label for="modeloEquipo">Modelo del Equipo:</label>
                <input type="text" name="modeloEquipo" list="modelosList" oninput="this.value = this.value.toUpperCase()">
                <datalist id="modelosList">
                    <?php foreach ($modelos as $modelo) : ?>
                        <option value="<?php echo $modelo; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <label for="nombreEquipo">Nombre del Equipo:</label>
                <input type="text" name="nombreEquipo" oninput="this.value = this.value.toUpperCase()">
                <br>
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
            <!-- Campo oculto para el ID del equipo -->
            <input type="hidden" name="id_equipo">
       

        </form>
    </center>
    <?php




    ?>
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