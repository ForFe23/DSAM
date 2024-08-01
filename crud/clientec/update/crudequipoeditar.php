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

        $activoEquipo = $_POST['activoEquipo'];
        $officeEquipo = $_POST['officeEquipo'];
        $costoEquipo = $_POST['costoEquipo'];
        $facturaEquipo = $_POST['facturaEquipo'];
        $notasEquipo = $_POST['notasEquipo'];
        $ciudadEquipo = $_POST['ciudadEquipo'];
        $nombreEquipo = $_POST['nombreEquipo'];


        $conn->query("SET FOREIGN_KEY_CHECKS=0");

        // Ejecutar la consulta de actualización
        $sql = "UPDATE EQUIPO 
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

    $servername = "localhost";
    $username = "root";
    $password = ""; // Deja esto vacío si no tienes contraseña
    $dbname = "basedap";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Obtener el ID del equipo de la URL
    if (isset($_GET['id_equipo'])) {
        $idEquipo = $_GET['id_equipo'];



        $sql2 = "SELECT * FROM EQUIPO WHERE ID= $idEquipo"; // Asegúrate de completar tu consulta SQL con las condiciones necesarias
        $res = $conn->query($sql2);

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc(); // Obtén la fila de resultados


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
        // Obtener la fecha del equipo y convertirla al formato ISO si no es nula
        $fechaCompraInput = $row['FCOMPRAEQUIPO'] ? date('Y-m-d', strtotime($row['FCOMPRAEQUIPO'])) : '';

    ?>



        <center>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <!-- Agrega este bloque de código al formulario -->
                <label for="serieEquipo">Serie del Equipo:</label>
                <input type="text" name="serieEquipo" value="<?php echo $row['SERIEEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">


                <br>

                <label for="marcaEquipo">Marca del Equipo:</label>
                <input type="text" name="marcaEquipo" required list="marcasList" value="<?php echo $row['MARCAEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                <datalist id="marcasList">
                    <?php foreach ($marcas as $marca) : ?>
                        <option value="<?php echo $marca; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <label for="modeloEquipo">Modelo del Equipo:</label>
                <input type="text" name="modeloEquipo" required list="modelosList" value="<?php echo $row['MODELOEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                <datalist id="modelosList">
                    <?php foreach ($modelos as $modelo) : ?>
                        <option value="<?php echo $modelo; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <label for="tipoEquipo">Tipo de Equipo:</label>
                <input type="text" name="tipoEquipo" required list="tiposEquipoList" value="<?php echo $row['TIPOEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                <datalist id="tiposEquipoList">
                    <?php foreach ($tiposEquipo as $tipoEquipo) : ?>
                        <option value="<?php echo $tipoEquipo; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <label for="soEquipo">Sistema Operativo:</label>
                <input type="text" name="soEquipo" required list="sistemasOperativosList" value="<?php echo $row['SOEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                <datalist id="sistemasOperativosList">
                    <?php foreach ($sistemasOperativos as $soEquipo) : ?>
                        <option value="<?php echo $soEquipo; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <label for="procesadorEquipo">Procesador:</label>
                <input type="text" name="procesadorEquipo" required list="procesadoresList" value="<?php echo $row['PROCESADOREQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                <datalist id="procesadoresList">
                    <?php foreach ($procesadores as $procesador) : ?>
                        <option value="<?php echo $procesador; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <label for="memoriaEquipo">Memoria RAM:</label>
                <input type="text" name="memoriaEquipo" required list="ramList" value="<?php echo $row['MEMORIAEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                <datalist id="ramList">
                    <?php foreach ($ram as $memoria) : ?>
                        <option value="<?php echo $memoria; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <label for="hddEquipo">Disco Duro:</label>
                <input type="text" name="hddEquipo" required list="hddsList" value="<?php echo $row['HDDEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                <datalist id="hddsList">
                    <?php foreach ($hdds as $hdd) : ?>
                        <option value="<?php echo $hdd; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <label for="fCompraEquipo">Fecha de Compra:</label>
                <label>La anterior fecha es: <br><?php echo $row['FCOMPRAEQUIPO']; ?></label>
                <input type="date" name="fCompraEquipo" value="<?php echo $fechaCompraInput; ?>">
                <br>
                <label for="statusEquipo">Estado del Equipo:</label>
                <select name="statusEquipo">
                    <option value="ACTIVO">ACTIVO</option>
                    <option value="INACTIVO">INACTIVO</option>
                </select>
                <br>
                <label for="ipEquipo">Dirección IP:</label>
                <input type="text" name="ipEquipo" required value="<?php echo $row['IPEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                <br>
                <label for="ubicacionUsuario">Ubicación del Usuario:</label>
                <input type="text" name="ubicacionUsuario" value="<?php echo $row['UBICACIONUSUARIO']; ?>" oninput="this.value = this.value.toUpperCase()">
                <br>
                <label for="depUsuario">Departamento del Usuario:</label>
                <input type="text" name="depUsuario" value="<?php echo $row['DEPUSUARIO']; ?>" oninput="this.value = this.value.toUpperCase()">
                <br>

                <label for="nombreUsuario">Nombre del Usuario:</label>
                <input type="text" name="nombreUsuario" required list="usuariosList" value="<?php echo $row['NOMBREUSUARIO']; ?>" oninput="this.value = this.value.toUpperCase()">
                <datalist id="usuariosList">
                    <?php foreach ($usuarios as $usuario) : ?>
                        <option value="<?php echo $usuario; ?>">
                        <?php endforeach; ?>
                </datalist>

                <br>
                <label for="nombreProveedor">Nombre del Proveedor:</label>
                <input type="text" name="nombreProveedor" value="<?php echo $row['NOMBREPROVEEDOR']; ?>" oninput="this.value = this.value.toUpperCase()">
                <br>
                <label for="direccionProveedor">Dirección del Proveedor:</label>
                <input type="text" name="direccionProveedor" value="<?php echo $row['DIRECCIONPROVEEDOR']; ?>" oninput="this.value = this.value.toUpperCase()">
                <br>
                <label for="telefonoProveedor">Teléfono del Proveedor:</label>
                <input type="text" name="telefonoProveedor" value="<?php echo $row['TELEFONOPROVEEDOR']; ?>" oninput="this.value = this.value.toUpperCase()">
                <br>
                <label for="contactoProveedor">Contacto del Proveedor:</label>
                <input type="text" name="contactoProveedor" value="<?php echo $row['CONTACTOPROVEEDOR']; ?>" oninput="this.value = this.value.toUpperCase()">

                <label for="activoEquipo">Activo del Equipo:</label>
                <input type="text" name="activoEquipo" value="<?php echo $row['ACTIVOEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                <br>
                <label for="officeEquipo">Versión de Office:</label>
                <input type="text" name="officeEquipo" list="versionesOfficeList" value="<?php echo $row['OFFICEEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                <datalist id="versionesOfficeList">
                    <?php foreach ($versionesOffice as $versionOffice) : ?>
                        <option value="<?php echo $versionOffice; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <label for="costoEquipo">Costo del Equipo:</label>
                <input type="text" name="costoEquipo" value="<?php echo $row['COSTOEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                <br>
                <label for="facturaEquipo">Número de Factura:</label>
                <input type="text" name="facturaEquipo" value="<?php echo $row['FACTURAEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                <br>
                <label for="notasEquipo">Notas:</label>
                <textarea name="notasEquipo" rows="4" value="<?php echo $row['NOTASEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()"></textarea>
                <br>
                <label for="ciudadEquipo">Ciudad del Equipo:</label>
                <input type="text" name="ciudadEquipo" value="<?php echo $row['CIUDADEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
                <br>
                <label for="nombreEquipo">Nombre del Equipo:</label>
                <input type="text" name="nombreEquipo" required value="<?php echo $row['NOMBREEQUIPO']; ?>" oninput="this.value = this.value.toUpperCase()">
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
</body>

</html>