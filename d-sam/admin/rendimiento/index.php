<!DOCTYPE html>
<?php

session_start();

if (isset($_SESSION['CARGOUSUARIO']) && $_SESSION['CARGOUSUARIO'] === 'TRGRTNRS') {
} else {

    header("Location: https://dapcomputer.com/");
    exit;
}

?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Rendimiento de Base de Datos</title>
    <!-- Incluir Bootstrap desde CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        p {
            text-align: center;
            color: #666;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        #chart_div {
            margin: 0 auto;
            width: 80%;
            height: 300px;
        }

        .panel {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .panel-title {
            font-size: 24px;
            margin-bottom: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        .app {
            display: flex;
            min-height: 100vh;
        }

        .menu-toggle {
            display: none;
            position: fixed;
            top: 2rem;
            right: 2rem;
            width: 60px;
            height: 60px;
            border-radius: 99px;
            background-color: #2e3047;
            cursor: pointer;
        }

        .hamburger {
            position: relative;
            top: calc(50% - 2px);
            left: 50%;
            transform: translate(-50%, -50%);
            width: 32px;
        }

        .hamburger>span,
        .hamburger>span::before,
        .hamburger>span::after {
            display: block;
            position: absolute;
            width: 100%;
            height: 4px;
            border-radius: 99px;
            background-color: #FFF;
            transition-duration: .25s;
        }

        .hamburger>span::before {
            content: '';
            top: -8px;
        }

        .hamburger>span::after {
            content: '';
            top: 8px;
        }

        .menu-toggle.is-active .hamburger>span {
            transform: rotate(45deg);
        }

        .menu-toggle.is-active .hamburger>span::before {
            top: 0;
            transform: rotate(0deg);
        }

        .menu-toggle.is-active .hamburger>span::after {
            top: 0;
            transform: rotate(90deg);
        }

        .sidebar {
            flex: 1 1 0;
            max-width: 300px;
            padding: 2rem 1rem;
            background-color: #2e3047;
        }

        .sidebar h3 {
            color: #707793;
            font-size: 0.75rem;
            text-transform: uppercase;
            margin-bottom: 0.5em;
        }

        .sidebar .menu {
            margin: 0 -1rem;
        }

        .sidebar .menu .menu-item {
            display: block;
            padding: 1em;
            color: #FFF;
            text-decoration: none;
            transition: 0.2s linear;
        }

        .sidebar .menu .menu-item:hover,
        .sidebar .menu .menu-item.is-active {
            color: #ffbf00;
            border-right: 5px solid #ffbf00;
        }

        .sidebar .menu .menu-item:hover {
            border-right: 5px solid #ffbf00;
        }

        .content {
            flex: 1 1 0;
            padding: 2rem;
        }

        .content h1 {
            color: #3C3F58;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .content p {
            color: #707793;
        }

        @media (max-width: 1024px) {
            .sidebar {
                max-width: 200px;
            }
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            .content {
                padding-top: 8rem;
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: -300px;
                height: 100vh;
                width: 100%;
                max-width: 300px;
                transition: 0.2s linear;
            }

            .sidebar.is-active {
                left: 0;
            }
        }
    </style>
</head>

<body>
    <?php
    include '../../../php/connection.php';

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta para obtener el número de usuarios conectados actualmente
    $query_users = "SELECT COUNT(*) AS num_users FROM INFORMATION_SCHEMA.PROCESSLIST WHERE user <> 'system user'";
    $result_users = $conn->query($query_users);

    // Consulta para obtener el número de consultas por segundo
    $query_qps = "SHOW GLOBAL STATUS LIKE 'Questions'";
    $result_qps = $conn->query($query_qps);

    // Consulta para obtener el tiempo de respuesta promedio de las consultas
    $query_response_time = "SHOW GLOBAL STATUS LIKE 'Com_select%'";
    $result_response_time = $conn->query($query_response_time);

    // Consulta para obtener el espacio de almacenamiento utilizado
    $query_storage = "SELECT SUM(data_length + index_length) AS total_size FROM information_schema.tables";
    $result_storage = $conn->query($query_storage);

    // Procesar y mostrar los resultados
    $num_users = 0;
    if ($result_users->num_rows > 0) {
        while ($row = $result_users->fetch_assoc()) {
            $num_users = $row["num_users"];
        }
    } else {
        echo "No se encontraron resultados de usuarios conectados.";
    }

    $qps = 0;
    if ($result_qps->num_rows > 0) {
        while ($row = $result_qps->fetch_assoc()) {
            $qps = $row["Value"];
        }
    } else {
        echo "No se encontraron resultados de consultas por segundo.";
    }

    $response_time = 0;
    if ($result_response_time->num_rows > 0) {
        while ($row = $result_response_time->fetch_assoc()) {
            $response_time = $row["Value"];
        }
    } else {
        echo "No se encontraron resultados de tiempo de respuesta promedio.";
    }

    $storage_used = 0;
    if ($result_storage->num_rows > 0) {
        while ($row = $result_storage->fetch_assoc()) {
            $storage_used = $row["total_size"];
        }
    } else {
        echo "No se encontraron resultados de espacio de almacenamiento utilizado.";
    }

    // Cerrar la conexión
    $conn->close();
    ?>

    <div class="app">
        <div class="sidebar">
            <a href="../../../index" class="btn btn-danger btn-sm">Salir</a>
            <br>
            <br>
            <img src="https://i.ibb.co/7Ynhxw2/DSAM-DASHBOARD.png" />
            <br><br>
            <nav class="menu">
                <a href="../dashboard" class="menu-item is-active">Inicio</a>
                <a href="../empleados/index" class="menu-item">Empleados</a>
                <a href="../acciones/index" class="menu-item">Acciones</a>
                <a href="../rendimiento/index" class="menu-item">Rendimiento</a>
            </nav>
        </div>

        <main class="content">
            <div class="container">
                <h1>Rendimiento de MySQL</h1>
                <p>Número de usuarios conectados actualmente: <?php echo $num_users; ?></p>
                <!-- Gráfico de barras para usuarios conectados -->
                <div id="chart_users"></div>
                <hr>
                <!-- Gráfico de línea para consultas por segundo -->
                <div id="chart_qps"></div>
                <hr>
                <!-- Gráfico de línea para tiempo de respuesta promedio -->
                <div id="chart_response_time"></div>
                <hr>
                <!-- Gráfico de línea para espacio de almacenamiento utilizado -->
                <div id="chart_storage"></div>
            </div>
        </main>
    </div>

    <!-- Incluir Google Charts JS -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            // Datos para usuarios conectados
            var data_users = google.visualization.arrayToDataTable([
                ['Usuarios', 'Conexiones'],
                ['Conectados', <?php echo $num_users; ?>],
                ['Máximo permitido', 100] // Ajusta este valor al máximo permitido de conexiones
            ]);

            // Opciones para usuarios conectados
            var options_users = {
                title: 'Usuarios conectados actualmente',
                bars: 'vertical'
            };

            // Gráfico de barras para usuarios conectados
            var chart_users = new google.visualization.ColumnChart(document.getElementById('chart_users'));
            chart_users.draw(data_users, options_users);

            // Datos y opciones para consultas por segundo
            var data_qps = google.visualization.arrayToDataTable([
                ['Tiempo', 'Consultas por segundo'],
                ['Hora 1', <?php echo $qps; ?>],
                ['Hora 2', 50], // Ejemplo de datos para la segunda hora
                ['Hora 3', 60]  // Ejemplo de datos para la tercera hora
            ]);

            var options_qps = {
                title: 'Consultas por segundo',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart_qps = new google.visualization.LineChart(document.getElementById('chart_qps'));
            chart_qps.draw(data_qps, options_qps);

            // Datos y opciones para tiempo de respuesta promedio
            var data_response_time = google.visualization.arrayToDataTable([
                ['Tiempo', 'Tiempo de respuesta promedio'],
                ['Hora 1', <?php echo $response_time; ?>],
                ['Hora 2', 0.5], // Ejemplo de datos para la segunda hora
                ['Hora 3', 0.4]  // Ejemplo de datos para la tercera hora
            ]);

            var options_response_time = {
                title: 'Tiempo de respuesta promedio (segundos)',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart_response_time = new google.visualization.LineChart(document.getElementById('chart_response_time'));
            chart_response_time.draw(data_response_time, options_response_time);

            // Datos y opciones para espacio de almacenamiento utilizado
            var data_storage = google.visualization.arrayToDataTable([
                ['Tiempo', 'Espacio utilizado'],
                ['Hora 1', <?php echo $storage_used; ?>],
                ['Hora 2', 800], // Ejemplo de datos para la segunda hora
                ['Hora 3', 1000]  // Ejemplo de datos para la tercera hora
            ]);

            var options_storage = {
                title: 'Espacio de Almacenamiento Utilizado (MB)',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart_storage = new google.visualization.LineChart(document.getElementById('chart_storage'));
            chart_storage.draw(data_storage, options_storage);
        }
    </script>
</body>


</html>