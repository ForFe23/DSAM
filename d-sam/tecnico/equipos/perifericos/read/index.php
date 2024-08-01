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
    <title>D SAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../../style/style.css" />
    <script src="../....//../../scripts/botonmostrar.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="../../../../../scripts/adminread.js"></script>
    <script src="../../../../../qrcode/qrcode.js"></script>
    <script src="../../../../../qrcode/qrcode.min.js"></script>
    <script src="qrcode.js"></script>
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
</head>

<body>
    <?php
    // *******************
    // DEPENDENCIA CODIGO QR
    // *******************
    require "../../../../../phpqrcode/qrlib.php";
    // *******************
    // RELOAD PAGE
    // *******************
    // Verifica si la variable de sesión "reloadOnce" está presente
    if (!isset($_SESSION['reloadOnce'])) {
        // Si no está presente, realiza la recarga y establece la variable de sesión
        echo '<script>window.onload = function() { location.reload(); }</script>';
        $_SESSION['reloadOnce'] = true;
    }

    if (isset($_GET['id_cliente']) && isset($_GET['id_equipo'])) {
        // Obtener el valor de idCliente e idEquipo
        $idCliente = $_GET['id_cliente'];
        $idEquipo = $_GET['id_equipo'];
    } else {
        // Manejar el caso en que los parámetros no estén presentes
        echo "ID Cliente o ID Equipo no proporcionados.";
        exit;
    }

    include '../../../../../php/connection.php';

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta SQL para obtener todos los datos de PERIFERICOS con el id del cliente y del equipo
    $sql = "SELECT * FROM perifericos WHERE ID = $idEquipo;";

    $result = $conn->query($sql);

    ?>

    <!-- Ajustes en la generación de la tabla para reflejar las columnas de PERIFERICOS -->
    <a  class="btn btn-primary" onclick='Retroceder(this)' style="color:white;" >Volver</a>
    <?php

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Acciones</th>";
            echo "<th>ID</th>";
            echo "<th>Serie Equipo</th>";
            echo "<th>Serie Monitor</th>";
            echo "<th>Activo Monitor</th>";
            echo "<th>Marca Monitor</th>";
            echo "<th>Modelo Monitor</th>";
            echo "<th>Observacion Monitor</th>";
            echo "<th>Serie Teclado</th>";
            echo "<th>Activo Teclado</th>";
            echo "<th>Marca Teclado</th>";
            echo "<th>Modelo Teclado</th>";
            echo "<th>Observacion Teclado</th>";
            echo "<th>Serie Mouse</th>";
            echo "<th>Activo Mouse</th>";
            echo "<th>Marca Mouse</th>";
            echo "<th>Modelo Mouse</th>";
            echo "<th>Observacion Mouse</th>";
            echo "<th>Serie Telefono</th>";
            echo "<th>Activo Telefono</th>";
            echo "<th>Marca Telefono</th>";
            echo "<th>Modelo Telefono</th>";
            echo "<th>Observacion Telefono</th>";
            echo "<th>Cliente Perifericos</th>";
            echo "<!-- Agregar más encabezados según sea necesario -->";
            echo "</tr>";
            echo "</thead>";
            echo " <tbody>";
            echo "<tr>";
            echo "<td data-label='Acciones'>";
            echo "<a href='../update/crudequipoeditar?id_equipo=" . $idEquipo . "&id_cliente=".$idCliente."'>Editar</a><br>";

            echo "</td>";
            echo "<td data-label='ID'>" . ($row["ID"] ? $row["ID"] : '-') . "</td>";
            echo "<td data-label='Serie Equipo'>" . ($row["SERIEEQUIPO"] ? $row["SERIEEQUIPO"] : '-') . "</td>";
            echo "<td data-label='Serie Monitor'>" . ($row["SERIEMONITOR"] ? $row["SERIEMONITOR"] : '-') . "</td>";
            echo "<td data-label='Activo Monitor'>" . ($row["ACTIVOMONITOR"] ? $row["ACTIVOMONITOR"] : '-') . "</td>";
            echo "<td data-label='Marca Monitor'>" . ($row["MARCAMONITOR"] ? $row["MARCAMONITOR"] : '-') . "</td>";
            echo "<td data-label='Modelo Monitor'>" . ($row["MODELOMONITOR"] ? $row["MODELOMONITOR"] : '-') . "</td>";
            echo "<td data-label='Observacion Monitor'>" . ($row["OBSERVACIONMONITOR"] ? $row["OBSERVACIONMONITOR"] : '-') . "</td>";
            echo "<td data-label='Serie Teclado'>" . ($row["SERIETECLADO"] ? $row["SERIETECLADO"] : '-') . "</td>";
            echo "<td data-label='Activo Teclado'>" . ($row["ACTIVOTECLADO"] ? $row["ACTIVOTECLADO"] : '-') . "</td>";
            echo "<td data-label='Marca Teclado'>" . ($row["MARCATECLADO"] ? $row["MARCATECLADO"] : '-') . "</td>";
            echo "<td data-label='Modelo Teclado'>" . ($row["MODELOTECLADO"] ? $row["MODELOTECLADO"] : '-') . "</td>";
            echo "<td data-label='Observacion Teclado'>" . ($row["OBSERVACIONTECLADO"] ? $row["OBSERVACIONTECLADO"] : '-') . "</td>";
            echo "<td data-label='Serie Mouse'>" . ($row["SERIEMOUSE"] ? $row["SERIEMOUSE"] : '-') . "</td>";
            echo "<td data-label='Activo Mouse'>" . ($row["ACTIVOMOUSE"] ? $row["ACTIVOMOUSE"] : '-') . "</td>";
            echo "<td data-label='Marca Mouse'>" . ($row["MARCAMOUSE"] ? $row["MARCAMOUSE"] : '-') . "</td>";
            echo "<td data-label='Modelo Mouse'>" . ($row["MODELOMOUSE"] ? $row["MODELOMOUSE"] : '-') . "</td>";
            echo "<td data-label='Observacion Mouse'>" . ($row["OBSERVACIONMOUSE"] ? $row["OBSERVACIONMOUSE"] : '-') . "</td>";
            echo "<td data-label='Serie Telefono'>" . ($row["SERIETELEFONO"] ? $row["SERIETELEFONO"] : '-') . "</td>";
            echo "<td data-label='Activo Telefono'>" . ($row["ACTIVOTELEFONO"] ? $row["ACTIVOTELEFONO"] : '-') . "</td>";
            echo "<td data-label='Marca Telefono'>" . ($row["MARCATELEFONO"] ? $row["MARCATELEFONO"] : '-') . "</td>";
            echo "<td data-label='Modelo Telefono'>" . ($row["MODELOTELEFONO"] ? $row["MODELOTELEFONO"] : '-') . "</td>";
            echo "<td data-label='Observacion Telefono'>" . ($row["OBSERVACIONTELEFONO"] ? $row["OBSERVACIONTELEFONO"] : '-') . "</td>";
            echo "<td data-label='Cliente Perifericos'>" . ($row["CLIENTEPERIFERICOS"] ? $row["CLIENTEPERIFERICOS"] : '-') . "</td>";
            // Agregar más celdas según sea necesario para las otras columnas de PERIFERICOS
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>SIN REGISTRAR</td></tr>";
        $nombreCliente = $_GET['nombre_cliente'];
        header("Location: ../create/crearperifericos?id_equipo=$idEquipo&id_cliente=$idCliente");
        exit();
    }
    ?>
    </tbody>
    </table>

    <!-- Resto del código HTML y JavaScript permanece igual -->
    <!-- Modal para mostrar detalles del equipo -->
    <!-- ... (código del modal) -->

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
    function Retroceder (button){
        window.history.go(-1);
    }
    </script>
</body>

</html>