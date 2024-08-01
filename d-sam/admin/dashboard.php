<?php

session_start();

if (isset($_SESSION['CARGOUSUARIO']) && $_SESSION['CARGOUSUARIO'] === 'TRGRTNRS') {
} else {

    header("Location: https://dapcomputer.com/");
    exit;
}
include '../../php/connection.php';
// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener el número de usuarios y tipos de usuarios
$sqlUsuarios = "SELECT COUNT(IDUSUARIO) as total, CARGOUSUARIO FROM usuarios GROUP BY CARGOUSUARIO";
$resultUsuarios = $conn->query($sqlUsuarios);

// Consulta para obtener el número total de equipos
$sqlEquipos = "SELECT COUNT(ID) as total FROM equipo";
$resultEquipos = $conn->query($sqlEquipos);

// Consulta para obtener el número de empresas y cuántos equipos tiene cada una
$sqlEmpresasEquipos = "SELECT c.NOMBRECLIENTE, COUNT(e.ID) as total_equipos FROM cliente c LEFT JOIN equipo e ON c.IDCLIENTE = e.IDCLIENTE GROUP BY c.IDCLIENTE";
$resultEmpresasEquipos = $conn->query($sqlEmpresasEquipos);

// Consulta para obtener el número de equipos por empresa
$sqlEquiposPorEmpresa = "SELECT c.NOMBRECLIENTE, COUNT(e.ID) as total_equipos FROM cliente c LEFT JOIN equipo e ON c.IDCLIENTE = e.IDCLIENTE GROUP BY c.IDCLIENTE";
$resultEquiposPorEmpresa = $conn->query($sqlEquiposPorEmpresa);

// Procesar los resultados de las consultas y almacenarlos en arrays
$usuariosData = [];
while ($row = $resultUsuarios->fetch_assoc()) {
    // Verificar si CARGOUSUARIO está vacío
    $cargoUsuario = !empty($row['CARGOUSUARIO']) ? $row['CARGOUSUARIO'] : 'POR ASIGNAR';
    
    // Obtener la equivalencia del cargo de usuario si existe, o usar el valor original si no
    $service_url = 'https://multiserviciossa.com/obtener_nombres_clave.php';
    $response = file_get_contents($service_url);
    $cargo_equivalencias = json_decode($response, true);
    $cargo_equivalencia = isset($cargo_equivalencias[$cargoUsuario]) ? $cargo_equivalencias[$cargoUsuario] : $cargoUsuario;

    // Almacenar el nombre equivalente y el total en el array
    $usuariosData[$cargo_equivalencia] = $row['total'];
}



$equiposData = $resultEquipos->fetch_assoc();

$empresasEquiposData = [];
while ($row = $resultEmpresasEquipos->fetch_assoc()) {
    $empresasEquiposData[$row['NOMBRECLIENTE']] = $row['total_equipos'];
}

$equiposPorEmpresaData = [];
while ($row = $resultEquiposPorEmpresa->fetch_assoc()) {
    $equiposPorEmpresaData[$row['NOMBRECLIENTE']] = $row['total_equipos'];
}

// Convertir datos a formato JSON para ser utilizados en JavaScript
$usuariosJson = json_encode($usuariosData);
$empresasEquiposJson = json_encode($empresasEquiposData);
$equiposPorEmpresaJson = json_encode($equiposPorEmpresaData);

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Panel Administrativo</title>
    <!-- Incluir Bootstrap desde CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../style/stylesidebar.css">
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
</head>

<body>
    <div class="app">
        <div class="menu-toggle">
            <div class="hamburger">
                <span></span>
            </div>
        </div>

        <aside class="sidebar">
            <a href="../../index" class="btn btn-danger btn-sm">Salir</a>
            <br>
            <br>
            <img src="https://i.ibb.co/7Ynhxw2/DSAM-DASHBOARD.png" />
            <br><br>
            <h4 style="color:white;">Bienvenido <?php echo $_SESSION["NOMBREUSUARIO"]; ?></h4>
            <nav class="menu">
                <a href="../admin/dashboard" class="menu-item is-active">Inicio</a>
                <a href="../admin/empleados/index" class="menu-item">Empleados</a>
                <a href="../admin/acciones/index" class="menu-item">Acciones</a>
                <a href="../admin/rendimiento/index" class="menu-item">Rendimiento</a>
            </nav>

        </aside>

        <main class="content">
            <div class="container mt-5">
                <h1 class="text-center mb-5">Panel de Control</h1>
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel">
                            <h2 class="panel-title">Usuarios</h2>
                            <canvas id="chartUsuarios" width="400" height="400"></canvas>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel">
                            <h2 class="panel-title">Equipos</h2>
                            <canvas id="chartEquipos" width="400" height="400"></canvas>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel">
                            <h2 class="panel-title">Equipos por Empresa</h2>
                            <canvas id="chartEquiposPorEmpresa" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>






    <!-- Incluir Bootstrap JS y Popper.js desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Datos de usuarios, equipos y empresas proporcionados por PHP
        var usuariosData = <?php echo $usuariosJson; ?>;
        var equiposData = <?php echo json_encode($equiposData); ?>;
        var empresasEquiposData = <?php echo $empresasEquiposJson; ?>;
        var equiposPorEmpresaData = <?php echo $equiposPorEmpresaJson; ?>;

        // Gráfico de pastel para usuarios
        var ctxUsuarios = document.getElementById('chartUsuarios').getContext('2d');
        var chartUsuarios = new Chart(ctxUsuarios, {
            type: 'pie',
            data: {
                labels: Object.keys(usuariosData),
                datasets: [{
                    data: Object.values(usuariosData),
                    backgroundColor: ['#CEDCE5','#36a2eb', '#ffcd56', '#3F5FFF'] // Colores de ejemplo
                }]
            },
            options: {
                responsive: true
            }
        });

        // Gráfico de pastel para número total de equipos
        var ctxEquipos = document.getElementById('chartEquipos').getContext('2d');
        var chartEquipos = new Chart(ctxEquipos, {
            type: 'pie',
            data: {
                labels: ['Equipos'],
                datasets: [{
                    data: [equiposData['total']],
                    backgroundColor: ['#c48400'] // Color de ejemplo
                }]
            },
            options: {
                responsive: true
            }
        });



        // Gráfico de barras para número de equipos por empresa
        var ctxEquiposPorEmpresa = document.getElementById('chartEquiposPorEmpresa').getContext('2d');
        var chartEquiposPorEmpresa = new Chart(ctxEquiposPorEmpresa, {
            type: 'bar',
            data: {
                labels: Object.keys(equiposPorEmpresaData),
                datasets: [{
                    label: 'Equipos',
                    data: Object.values(equiposPorEmpresaData),
                    backgroundColor: '#ffcd5685', // Color de relleno de ejemplo
                    borderColor: '#5d4aff', // Color del borde de ejemplo
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        const menu_toggle = document.querySelector('.menu-toggle');
        const sidebar = document.querySelector('.sidebar');

        menu_toggle.addEventListener('click', () => {
            menu_toggle.classList.toggle('is-active');
            sidebar.classList.toggle('is-active');
        });
    </script>


</body>

</html>