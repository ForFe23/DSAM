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
    <title>D SAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../style/style.css" />
    <script src="../../../../scripts/botonmostrar.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="../../../../scripts/adminread.js"></script>
    <script src="../../../../qrcode/qrcode.js"></script>
    <script src="../../../../qrcode/qrcode.min.js"></script>
    <script src="qrcode.js"></script>
    <script src="../../../../phpqrcode/"></script>
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
</head>

<body>
    <?php

    // *******************
    // DEPENDENCIA CODIGO QR
    // *******************
    require "../../../../phpqrcode/qrlib.php";
    // *******************
    // RELOAD PAGE
    // *******************
    // Verifica si la variable de sesión "reloadOnce" está presente
    if (!isset($_SESSION['reloadOnce'])) {
        // Si no está presente, realiza la recarga y establece la variable de sesión
        echo '<script>window.onload = function() { location.reload(); }</script>';
        $_SESSION['reloadOnce'] = true;
    }

    if (isset($_GET['id_equipo'])) {
        $idEquipo = $_GET['id_equipo'];
        $idCliente = $_GET['id_cliente'];
    } else {
        // Manejar el caso en que los parámetros no estén presentes
        echo "ID Cliente o ID Equipo no proporcionados.";
        exit;
    }

    include '../../../../php/connection.php';
    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $sql = "SELECT i.ID, i.SERIEEQUIPO,i.RESPONSABLE, u.CORREOUSUARIO, c.NOMBRECLIENTE, i.FECHAINCIDENTE, i.DETALLEINCIDENTE, i.COSTOINCIDENTE
    FROM incidente i
    LEFT JOIN usuarios u ON i.IDUSUARIO = u.IDUSUARIO
    LEFT JOIN cliente c ON i.IDCLIENTE = c.IDCLIENTE
    WHERE i.ID = $idEquipo;";


    $result = $conn->query($sql);

    ?>
    <a href="../../read/crudequipos" class="btn btn-primary">Volver</a>
    <!-- Ajustes en la generación de la tabla para reflejar las columnas de incidente -->
    <table class='table'>
        <thead>
            <tr>
                <th>Acciones</th>
                <th>ID</th>
                <th>Serie Equipo</th>
                <th>Tecnico Responsable</th>
                <th>Cliente</th>
                <th>Fecha Incidente</th>
                <th>Detalle Incidente</th>
                <th>Costo Incidente</th>
                <th>Responsable Atencion</th>
            </tr>
        </thead>
        <?php

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                echo " <tbody>";
                echo "<tr>";
                echo "<td data-label='Acciones'>";
                echo "<a href='../update/crudequipoeditar?id_equipo=" . $idEquipo . "&fecha=" . $row["FECHAINCIDENTE"] . "'>Editar</a><br>";
                echo "<a href='../delete/deleteincidente?id_equipo=" . $idEquipo . "&fecha=" . $row["FECHAINCIDENTE"] . "'>Eliminar</a>";
                echo "</td>";
                echo "<td data-label='ID'>" . ($row["ID"] ? $row["ID"] : '-') . "</td>";
                echo "<td data-label='Serie Equipo'>" . ($row["SERIEEQUIPO"] ? $row["SERIEEQUIPO"] : '-') . "</td>";
                echo "<td data-label='TECNICO RESPONSABLE'>" . ($row["CORREOUSUARIO"] ? $row["CORREOUSUARIO"] : '-') . "</td>";
                echo "<td data-label='Nombre Cliente'>" . ($row["NOMBRECLIENTE"] ? $row["NOMBRECLIENTE"] : '-') . "</td>";
                echo "<td data-label='Marca Monitor'>" . ($row["FECHAINCIDENTE"] ? $row["FECHAINCIDENTE"] : '-') . "</td>";
                echo "<td data-label='Modelo Monitor'>" . ($row["DETALLEINCIDENTE"] ? $row["DETALLEINCIDENTE"] : '-') . "</td>";
                echo "<td data-label='Observacion Monitor'>" . ($row["COSTOINCIDENTE"] ? $row["COSTOINCIDENTE"] : '-') . "</td>";
                echo "<td data-label='Responsable de Atencion'>" . ($row["RESPONSABLE"] ? $row["RESPONSABLE"] : '-') . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr>
                <td colspan='5'>SIN REGISTRAR</td>
            </tr>";
            header("Location: ../create/crearincidente?id_equipo=$idEquipo&id_cliente=$idCliente");
            exit();
        }
        ?>
        </tbody>
    </table>

    <!-- Resto del código HTML y JavaScript permanece igual -->
    <!-- Modal para mostrar detalles del equipo -->
    <!-- ... (código del modal) -->
    <?php
    echo "<center><a href=' ../create/crearincidente?id_equipo=$idEquipo&id_cliente=$idCliente'>Crear Nuevo Incidente</a></center>";
    echo "<center><a href='../../../../reporte/incidentes?id_equipo=$idEquipo&id_cliente=$idCliente'>Generar Reporte Incidente</a></center>";  ?>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>