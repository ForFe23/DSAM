<?php

session_start();

if (isset($_SESSION['CARGOUSUARIO']) && $_SESSION['CARGOUSUARIO'] === 'TRGRTNRS') {
} else {

    header("Location: https://dapcomputer.com/");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Generar Reportes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../style/style.css" />
    <script src="../../../scripts/botonmostrar.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="../../../scripts/adminread.js"></script>
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
                <?php
                include '../../../php/connection.php';
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }
                $sql = "SELECT * FROM cliente;";
                $resultado = $conn->query($sql);
                ?>

                <center>
                    <form method="post" onsubmit="return redireccionar()">
                        <h1>FILTRADO POR EMPRESA CLIENTE</h1>
                        <select name="empresa" required>
                            <?php
                            while ($opcionCliente = $resultado->fetch_assoc()) {
                                echo "<option value='" . $opcionCliente['IDCLIENTE'] . "'>" . $opcionCliente['NOMBRECLIENTE'] . "</option>";
                            }
                            ?>
                        </select>
                        <div class="boton" style="padding: 12px;"><button class="btn btn-primary" style="color:white;">Descargar Excel</button></div>
                    </form>
            </div>
            <div>
                <div class="container">
                    <h1>TODOS LOS EQUIPOS</h1>
                    <center>
                        <div class="boton" style="padding: 12px;"> <a href="../../../reporte/excel/total/reporte" class="btn btn-primary" style="color:white;">Descargar Excel</a></div>
                    </center>
                </div>

            </div>
            <div>
                <div class="container">
                    <h1>FILTRO AVANZADO</h1>
                    <center>
                        <label for="marca">Marca:</label>
                        <select name="marca" id="marca">
                            <option value="">Todas las marcas</option>
                            <?php
                            // Conexión a la base de datos
                            include '../../../php/connection.php';
                            if ($conn->connect_error) {
                                die("Conexión fallida: " . $conn->connect_error);
                            }
                            // Consulta para obtener todas las marcas
                            $sql = "SELECT DISTINCT MARCAEQUIPO FROM equipo";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['MARCAEQUIPO'] . "'>" . $row['MARCAEQUIPO'] . "</option>";
                            }
                            $conn->close();
                            ?>
                        </select><br><br>

                        <label for="tipo">Tipo:</label>
                        <select name="tipo" id="tipo">
                            <option value="">Todos los tipos</option>
                            <?php
                            // Conexión a la base de datos
                            include '../../../php/connection.php';
                            if ($conn->connect_error) {
                                die("Conexión fallida: " . $conn->connect_error);
                            }
                            // Consulta para obtener todos los tipos
                            $sql = "SELECT DISTINCT TIPOEQUIPO FROM equipo";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['TIPOEQUIPO'] . "'>" . $row['TIPOEQUIPO'] . "</option>";
                            }
                            $conn->close();
                            ?>
                        </select><br><br>

                        <label for="status">Status:</label>
                        <select name="status" id="status">
                            <option value="">Todos los status</option>
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="BAJA">BAJA</option>
                            <!-- Agrega más opciones según los posibles status -->
                        </select><br><br>

                        <label for="ubicacion">Ubicación:</label>
                        <select name="ubicacion" id="ubicacion">
                            <option value="">Todas las ubicaciones</option>
                            <?php
                            // Conexión a la base de datos
                            include '../../../php/connection.php';
                            if ($conn->connect_error) {
                                die("Conexión fallida: " . $conn->connect_error);
                            }
                            // Consulta para obtener todas las ubicaciones
                            $sql = "SELECT DISTINCT UBICACIONUSUARIO FROM equipo";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['UBICACIONUSUARIO'] . "'>" . $row['UBICACIONUSUARIO'] . "</option>";
                            }
                            $conn->close();
                            ?>
                        </select><br><br>

                        <label for="nombreusuario">Nombre de Usuario:</label>
                        <select name="nombreusuario" id="nombreusuario">
                            <option value="">Todos los usuarios</option>
                            <?php
                            // Conexión a la base de datos
                            include '../../../php/connection.php';
                            if ($conn->connect_error) {
                                die("Conexión fallida: " . $conn->connect_error);
                            }
                            // Consulta para obtener todos los nombres de usuario
                            $sql = "SELECT DISTINCT NOMBREUSUARIO FROM equipo";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['NOMBREUSUARIO'] . "'>" . $row['NOMBREUSUARIO'] . "</option>";
                            }
                            $conn->close();
                            ?>
                        </select><br><br>

                        <label for="cliente">Cliente:</label>
                        <select name="cliente" id="cliente">
                            <option value="">Todos los clientes</option>
                            <?php
                            // Conexión a la base de datos
                            include '../../../php/connection.php';
                            if ($conn->connect_error) {
                                die("Conexión fallida: " . $conn->connect_error);
                            }
                            // Consulta para obtener todos los clientes
                            $sql = "SELECT DISTINCT NOMBRECLIENTE FROM cliente";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['NOMBRECLIENTE'] . "'>" . $row['NOMBRECLIENTE'] . "</option>";
                            }
                            $conn->close();
                            ?>
                        </select><br><br>
                        <button onclick="consultar()" class="btn btn-primary" style="color:white;">Descargar Excel</button>

                        <script>
                            function consultar() {
                                // Obtener los valores seleccionados por el usuario
                                var marca = document.getElementById("marca").value;
                                var tipo = document.getElementById("tipo").value;
                                var status = document.getElementById("status").value;
                                var ubicacion = document.getElementById("ubicacion").value;
                                var nombreusuario = document.getElementById("nombreusuario").value;
                                var cliente = document.getElementById("cliente").value;

                                // Redirigir al usuario a consulta.php con los valores en la URL
                                window.location.href = "../../../reporte/excel/personalizado/reporte?marca=" + marca + "&tipo=" + tipo + "&status=" + status + "&ubicacion=" + ubicacion + "&nombreusuario=" + nombreusuario + "&cliente=" + cliente;
                            }
                        </script>

                    </center>
                </div>
            </div>
            <div class="container">
                <h1>TODOS LOS INCIDENTES</h1>
                <center>
                    <div class="boton" style="padding: 12px;"> <a href="../../../reporte/excel/incidentes/General" class="btn btn-primary" style="color:white;">Descargar Excel</a></div>
                </center>
            </div>
            <div class="container">
                <?php
                include '../../../php/connection.php';
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }
                $sql = "SELECT * FROM cliente;";
                $resultado = $conn->query($sql);
                ?>

                <center>
                    <form method="post" onsubmit="return redireccionarIncidentes()">
                        <h1>INCIDENTES POR EMPRESA CLIENTE</h1>
                        <select name="empresaIncidente" required>
                            <?php
                            while ($opcionCliente = $resultado->fetch_assoc()) {
                                echo "<option value='" . $opcionCliente['IDCLIENTE'] . "'>" . $opcionCliente['NOMBRECLIENTE'] . "</option>";
                            }
                            ?>
                        </select>
                        <div class="boton" style="padding: 12px;"><button class="btn btn-primary" style="color:white;">Descargar Excel</button></div>
                        <a href=""></a>
                    </form>
            </div>
            </center>
            <script>
                function redireccionar() {
                    // Obtener el valor seleccionado
                    var idCliente = document.querySelector('select[name="empresa"]').value;

                    // Redireccionar a index.html con el valor como parámetro
                    window.location.href = '../../../reporte/excel/xcliente/reporte?idCliente=' + idCliente;

                    // Devolver false para prevenir que el formulario se envíe normalmente
                    return false;
                }
            </script>
            <script>
                function redireccionarIncidentes() {
                    // Obtener el valor seleccionado
                    var idCliente = document.querySelector('select[name="empresaIncidente"]').value;

                    // Redireccionar a index.html con el valor como parámetro
                    window.location.href = '../../../reporte/excel/incidentes/PorCliente?idCliente=' + idCliente;

                    // Devolver false para prevenir que el formulario se envíe normalmente
                    return false;
                }
            </script>

            <!--Aqui Contenido -->

        </main>
    </div>

    <!-- Incluir Google Charts JS -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src=""></script>

</body>

</html>