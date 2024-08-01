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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lista de Clientes</title>
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

    <div class="app">
        <div class="sidebar">
            <a href="../../../../index.php" class="btn btn-danger btn-sm">Salir</a>
            <br>
            <br>
            <img src="https://i.ibb.co/7Ynhxw2/DSAM-DASHBOARD.png" />
            <br><br>
            <nav class="menu">
                <a href="../../dashboard" class="menu-item is-active">Inicio</a>
                <a href="../../empleados/index" class="menu-item">Empleados</a>
                <a href="../../acciones/index" class="menu-item">Acciones</a>
                <a href="../../rendimiento/index" class="menu-item">Rendimiento</a>
            </nav>
        </div>
        <main class="content">
            <div class="container">

                <?php
                include '../../../../php/connection.php';

                // Verificar la conexión
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                // Procesar formulario de eliminación
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar"])) {
                    $idCliente = $_POST["idCliente"];
                    $sql = "DELETE FROM cliente WHERE IDCLIENTE = $idCliente";
                    $conn->query($sql);
                }

                // Obtener la lista de clientes
                $sql = "SELECT * FROM cliente";
                $result = $conn->query($sql);

                ?>


                <h2 class="mb-4">Listar de Clientes DAPCOM</h2>

                <!-- Mostrar la lista de clientes -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Licencia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["NOMBRECLIENTE"] . "</td>";
                                    echo "<td>" . $row["EMAIL"] . "</td>";
                                    echo "<td>" . $row["LICENCIACLIENTE"] . "</td>";
                                    echo '<td>
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="idCliente" value="' . $row["IDCLIENTE"] . '">
                                <a href="../delete/delete?id=' . $row['IDCLIENTE'] . '" class="btn btn-danger btn-sm" name="eliminar">Eliminar</a>
                                <a href="../update/updateform?id=' . $row["IDCLIENTE"] . '" class="btn btn-danger btn-sm">Editar</a>
                                <a href="../baja/action?id=' . $row["IDCLIENTE"] . '" class="btn btn-warning">Dar de baja</a>
                          
                                </form>
                          </td>';
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No hay clientes registrados.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Botón para crear nuevo cliente -->
                    <div class="text-center">
                        <a href="../create/createform" class="btn btn-primary mb-3">Crear Cliente</a>
                    </div>
                </div>


                <!-- Incluir Bootstrap JS y Popper.js desde CDN -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


                <?php
                // Cerrar la conexión a la base de datos al finalizar
                $conn->close();
                ?>
            </div>
        </main>
    </div>

    <!-- Incluir Google Charts JS -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</body>

</html>