<?php

session_start();

if (isset($_SESSION['CARGOUSUARIO']) && $_SESSION['CARGOUSUARIO'] === 'BLTRCPLS') {
    $idCliente = $_SESSION['IDCLIENTE'];
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            /* Fondo gris claro */
            padding: 20px;
            color: #333;
            /* Color de texto principal */
        }

        .table {
            background-color: #fff;
            /* Fondo blanco para la tabla */
            border-radius: 10px;
            /* Borde redondeado para la tabla */
            overflow: hidden;
            /* Ocultar cualquier desbordamiento */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Sombra suave */
        }

        .table th,
        .table td {
            border: none;
            /* Eliminar bordes de celda */
        }

        .table th {
            background-color: #007bff;
            /* Color de fondo azul para encabezados */
            color: #fff;
            /* Texto blanco para encabezados */
        }

        .table tbody tr:nth-child(odd) {
            background-color: #f8f9fa;
            /* Color de fondo gris claro para filas impares */
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
            /* Color de fondo gris claro más oscuro al pasar el mouse */
        }

        .btn {
            background-color: #ff7f50;
            /* Color de fondo naranja para botones */
            color: #fff;
            /* Texto blanco para botones */
            border: none;
            /* Eliminar borde de botones */
            border-radius: 5px;
            /* Borde redondeado para botones */
            padding: 8px 16px;
            /* Espaciado interno de botones */
            cursor: pointer;
            transition: background-color 0.3s ease;
            /* Transición suave */
        }

        .btn:hover {
            background-color: #ff6a36;
            /* Color de fondo naranja más oscuro al pasar el mouse */
        }
    </style>
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

    if (isset($_GET['id_equipo'])) {
        $idEquipo = $_GET['id_equipo'];
        $idCliente = $_GET['id_cliente'];
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

    $sql = "SELECT i.ID, i.SERIEEQUIPO, i.RESPONSABLE, u.CORREOUSUARIO, c.NOMBRECLIENTE, i.FECHAINCIDENTE, i.DETALLEINCIDENTE, i.COSTOINCIDENTE
    FROM incidente i
    LEFT JOIN usuarios u ON i.IDUSUARIO = u.IDUSUARIO
    LEFT JOIN cliente c ON i.IDCLIENTE = c.IDCLIENTE
    WHERE i.ID = $idEquipo;";


    $result = $conn->query($sql);

    ?>
    <a class="btn btn-primary" onclick='Retroceder(this)' style="background-color: #007bff;color:white;">Volver</a><br><br>
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
                echo "<a href='../update/crudequipoeditar?id_equipo=" . $idEquipo . "&fecha=" . $row["FECHAINCIDENTE"] . "&id_cliente=" . $idCliente . "'>Editar</a><br>";

                echo "</td>";
                echo "<td data-label='ID'>" . ($row["ID"] ? $row["ID"] : '-') . "</td>";
                echo "<td data-label='Serie Equipo'>" . ($row["SERIEEQUIPO"] ? $row["SERIEEQUIPO"] : '-') . "</td>";
                echo "<td data-label='TECNICO RESPONSABLE'>" . ($row["CORREOUSUARIO"] ? $row["CORREOUSUARIO"] : '-') . "</td>";
                echo "<td data-label='Nombre Cliente'>" . ($row["NOMBRECLIENTE"] ? $row["NOMBRECLIENTE"] : '-') . "</td>";
                echo "<td data-label='Fecha Hora Incidente'>" . ($row["FECHAINCIDENTE"] ? $row["FECHAINCIDENTE"] : '-') . "</td>";
                echo "<td data-label='Detalle Incidente'>" . ($row["DETALLEINCIDENTE"] ? $row["DETALLEINCIDENTE"] : '-') . "</td>";
                echo "<td data-label='Costo Incidente'>" . ($row["COSTOINCIDENTE"] ? $row["COSTOINCIDENTE"] : '-') . "</td>";
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


    <?php


    echo "<center><a href=' ../create/crearincidente?id_equipo=$idEquipo&id_cliente=$idCliente'>Crear Nuevo Incidente</a></center>"; ?>
    <script>
        function Retroceder(button) {
            window.history.go(-1);
        }
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>