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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../Style/styleEdCr.css" />
    <script src="../../../../Scripts/BotonMostrar.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="../../../../Scripts/AdminRead.js"></script>
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
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
        include 'connection.php';
        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Recuperar el nombre del cliente desde el formulario
        $nombreCliente = $_POST['idCliente'];



        // Recuperar los datos del formulario
        // Recuperar los datos del formulario
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
        $sql = "INSERT INTO EQUIPO (SERIEEQUIPO,IDCLIENTE, MARCAEQUIPO, MODELOEQUIPO, TIPOEQUIPO, SOEQUIPO, PROCESADOREQUIPO, MEMORIAEQUIPO, HDDEQUIPO, FCOMPRAEQUIPO, STATUSEQUIPO, IPEQUIPO, UBICACIONUSUARIO, DEPUSUARIO, NOMBREUSUARIO, NOMBREPROVEEDOR, DIRECCIONPROVEEDOR, TELEFONOPROVEEDOR, CONTACTOPROVEEDOR, CLIENTE, ACTIVOEQUIPO, OFFICEEQUIPO, COSTOEQUIPO, FACTURAEQUIPO, NOTASEQUIPO, CIUDADEQUIPO, NOMBREEQUIPO) 
                VALUES ('$serieequipo',$idCliente, '$marcaEquipo', '$modeloEquipo', '$tipoEquipo', '$soEquipo', '$procesadorEquipo', '$memoriaEquipo', '$hddEquipo', '$fCompraEquipo', '$statusEquipo', '$ipEquipo', '$ubicacionUsuario', '$depUsuario', '$nombreUsuario', '$nombreProveedor', '$direccionProveedor', '$telefonoProveedor', '$contactoProveedor', '$cliente', '$activoEquipo', '$officeEquipo', '$costoEquipo', '$facturaEquipo', '$notasEquipo', '$ciudadEquipo', '$nombreEquipo')";
        echo $sql;
        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Equipo creado exitosamente."); window.location.href = "../../EQUIPOS/READ/Otro.php?idCliente=' . $idCliente . '";</script>';
        } else {
            echo '<p>Error al crear el equipo: ' . $conn->error . '</p>';
        }


        // Cerrar la conexión
        $conn->close();
    }


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

        $conn->close();

        return $opciones;
    }

    // Obtener opciones de clientes
    $clientes = obtenerOpciones('NOMBRECLIENTE', 'CLIENTE');

    // Obtener opciones de marcas
    $marcas = obtenerOpciones('MARCAEQUIPO', 'EQUIPO');

    // Obtener opciones de modelos
    $modelos = obtenerOpciones('MODELOEQUIPO', 'EQUIPO');

    // Obtener opciones de tipos de equipo
    $tiposEquipo = obtenerOpciones('TIPOEQUIPO', 'EQUIPO');

    // Obtener opciones de estados
    $estados = ['ACTIVO', 'INACTIVO'];

    // Obtener opciones de usuarios
    $usuarios = obtenerOpciones('NOMBREUSUARIO', 'EQUIPO');

    // Obtener opciones de versiones de Office
    $versionesOffice = obtenerOpciones('OFFICEEQUIPO', 'EQUIPO');

    // Obtener opciones de procesadores
    $procesadores = obtenerOpciones('PROCESADOREQUIPO', 'EQUIPO');

    // Obtener opciones de discos duros
    $hdds = obtenerOpciones('HDDEQUIPO', 'EQUIPO');

    // Obtener opciones de memoria RAM
    $ram = obtenerOpciones('MEMORIAEQUIPO', 'EQUIPO');

    // Obtener opciones de sistemas operativos
    $sistemasOperativos = obtenerOpciones('SOEQUIPO', 'EQUIPO');
    ?>
    <center>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <!-- Agrega este bloque de código al formulario -->
            <label for="serieEquipo">Serie del Equipo:</label>
            <input type="text" name="serieEquipo" oninput="this.value = this.value.toUpperCase()">
            <div class="ocultar" style="display: none;">
                <label for="idCliente">Cliente:</label>
                <input type="text" name="idCliente" value="<?php $nombreCliente ?>" list="clientesList" oninput="this.value = this.value.toUpperCase()">
                <datalist id="clientesList">
                    <?php foreach ($clientes as $cliente) : ?>
                        <option value="<?php echo $cliente; ?>">
                        <?php endforeach; ?>
                </datalist>
            </div>
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
            <label for="tipoEquipo">Tipo de Equipo:</label>
            <input type="text" name="tipoEquipo" list="tiposEquipoList" oninput="this.value = this.value.toUpperCase()">
            <datalist id="tiposEquipoList">
                <?php foreach ($tiposEquipo as $tipoEquipo) : ?>
                    <option value="<?php echo $tipoEquipo; ?>">
                    <?php endforeach; ?>
            </datalist>
            <br>
            <label for="soEquipo">Sistema Operativo:</label>
            <input type="text" name="soEquipo" list="sistemasOperativosList" oninput="this.value = this.value.toUpperCase()">
            <datalist id="sistemasOperativosList">
                <?php foreach ($sistemasOperativos as $soEquipo) : ?>
                    <option value="<?php echo $soEquipo; ?>">
                    <?php endforeach; ?>
            </datalist>
            <br>
            <label for="procesadorEquipo">Procesador:</label>
            <input type="text" name="procesadorEquipo" list="procesadoresList" oninput="this.value = this.value.toUpperCase()">
            <datalist id="procesadoresList">
                <?php foreach ($procesadores as $procesador) : ?>
                    <option value="<?php echo $procesador; ?>">
                    <?php endforeach; ?>
            </datalist>
            <br>
            <label for="memoriaEquipo">Memoria RAM:</label>
            <input type="text" name="memoriaEquipo" list="ramList" oninput="this.value = this.value.toUpperCase()">
            <datalist id="ramList">
                <?php foreach ($ram as $memoria) : ?>
                    <option value="<?php echo $memoria; ?>">
                    <?php endforeach; ?>
            </datalist>
            <br>
            <label for="hddEquipo">Disco Duro:</label>
            <input type="text" name="hddEquipo" list="hddsList" oninput="this.value = this.value.toUpperCase()">
            <datalist id="hddsList">
                <?php foreach ($hdds as $hdd) : ?>
                    <option value="<?php echo $hdd; ?>">
                    <?php endforeach; ?>
            </datalist>
            <br>
            <label for="fCompraEquipo">Fecha de Compra:</label>
            <input type="date" name="fCompraEquipo" value="0000-01-01">
            <br>

            <label for="statusEquipo">Estado del Equipo:</label>
            <select name="statusEquipo">
                <option value="" disabled selected hidden>Selecciona un estado</option>
                <?php foreach ($estados as $estado) : ?>
                    <option value="<?php echo $estado; ?>"><?php echo $estado; ?></option>
                <?php endforeach; ?>
            </select>

            <br>
            <label for="ipEquipo">Dirección IP:</label>
            <input type="text" name="ipEquipo" oninput="this.value = this.value.toUpperCase()">
            <br>
            <label for="ubicacionUsuario">Ubicación del Usuario:</label>
            <input type="text" name="ubicacionUsuario" oninput="this.value = this.value.toUpperCase()">
            <br>
            <label for="depUsuario">Departamento del Usuario:</label>
            <input type="text" name="depUsuario" oninput="this.value = this.value.toUpperCase()">
            <br>

            <label for="nombreUsuario">Nombre del Usuario:</label>
            <input type="text" name="nombreUsuario" list="usuariosList" oninput="this.value = this.value.toUpperCase()">
            <datalist id="usuariosList">
                <?php foreach ($usuarios as $usuario) : ?>
                    <option value="<?php echo $usuario; ?>">
                    <?php endforeach; ?>
            </datalist>
            <br>
            <label for="nombreProveedor">Nombre del Proveedor:</label>
            <input type="text" name="nombreProveedor" oninput="this.value = this.value.toUpperCase()">
            <br>
            <label for="direccionProveedor">Dirección del Proveedor:</label>
            <input type="text" name="direccionProveedor" oninput="this.value = this.value.toUpperCase()">
            <br>
            <label for="telefonoProveedor">Teléfono del Proveedor:</label>
            <input type="text" name="telefonoProveedor" oninput="this.value = this.value.toUpperCase()">
            <br>
            <label for="contactoProveedor">Contacto del Proveedor:</label>
            <input type="text" name="contactoProveedor" oninput="this.value = this.value.toUpperCase()">

            <label for="activoEquipo">Activo del Equipo:</label>
            <input type="text" name="activoEquipo" oninput="this.value = this.value.toUpperCase()">
            <br>
            <label for="officeEquipo">Versión de Office:</label>
            <input type="text" name="officeEquipo" list="versionesOfficeList" oninput="this.value = this.value.toUpperCase()">
            <datalist id="versionesOfficeList">
                <?php foreach ($versionesOffice as $versionOffice) : ?>
                    <option value="<?php echo $versionOffice; ?>">
                    <?php endforeach; ?>
            </datalist>
            <br>
            <label for="costoEquipo">Costo del Equipo:</label>
            <input type="text" name="costoEquipo" oninput="this.value = this.value.toUpperCase()">
            <br>
            <label for="facturaEquipo">Número de Factura:</label>
            <input type="text" name="facturaEquipo" oninput="this.value = this.value.toUpperCase()">
            <br>
            <label for="notasEquipo">Notas:</label>
            <textarea name="notasEquipo" rows="4" oninput="this.value = this.value.toUpperCase()"></textarea>
            <br>
            <label for="ciudadEquipo">Ciudad del Equipo:</label>
            <input type="text" name="ciudadEquipo" oninput="this.value = this.value.toUpperCase()">
            <br>
            <label for="nombreEquipo">Nombre del Equipo:</label>
            <input type="text" name="nombreEquipo" oninput="this.value = this.value.toUpperCase()">
            <br>
            <input type="submit" value="Crear Equipo">
        </form>
    </center>
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