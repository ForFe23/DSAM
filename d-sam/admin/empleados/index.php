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
    <title>Vista de Usuarios</title>
    <!-- Incluir Bootstrap desde CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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
                // Verificar la conexión
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                // Procesar formulario de eliminación
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar"])) {
                    $IDUSUARIO = $_POST["IDUSUARIO"];

                    // Verificar si el usuario está siendo utilizado como clave foránea
                    $sql_check_foreign_key = "SELECT COUNT(*) as num_references FROM incidente WHERE IDUSUARIO = $IDUSUARIO";
                    $result_check_foreign_key = $conn->query($sql_check_foreign_key);

                    if ($result_check_foreign_key && $result_check_foreign_key->num_rows > 0) {
                        $row_check_foreign_key = $result_check_foreign_key->fetch_assoc();
                        $num_references = $row_check_foreign_key['num_references'];

                        if ($num_references > 0) {
                            // Mostrar mensaje de error si el usuario está siendo utilizado como clave foránea
                            echo "<script>alert('No puedes eliminar un usuario que está siendo utilizado en otras tablas.')</script>";
                        } else {
                            // Eliminar usuario si no está siendo utilizado como clave foránea
                            $sql = "DELETE FROM usuarios WHERE IDUSUARIO = $IDUSUARIO";
                            $conn->query($sql);
                        }
                    }
                }

                // Obtener la lista de clientes con JOIN
                $sql = "SELECT usuarios.*, cliente.NOMBRECLIENTE AS NOMBRECLIENTE 
                FROM usuarios 
                INNER JOIN cliente ON usuarios.IDCLIENTE = cliente.IDCLIENTE;
                ";

                $result = $conn->query($sql);

                ?>

                <!DOCTYPE html>
                <html lang="es">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                    <title>Listar y Eliminar Clientes</title>
                    <!-- Incluir Bootstrap desde CDN -->
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
                </head>

                <body>


                    <center>
                        <h2 class="mb-4">Lista de usuarios</h2>
                    </center>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>AFILIADO A</th>
                                <th>CEDULA</th>
                                <th>APELLIDOS</th>
                                <th>NOMBRES</th>
                                <th>CARGO</th>
                                <th>CORREO</th>
                                <th>TELEFONO</th>
                                <th>ESTADO</th>
                                <th>FECHA REGISTRO</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["NOMBRECLIENTE"] . "</td>";
                                    echo "<td>" . $row["CEDULAUSUARIO"] . "</td>";
                                    echo "<td>" . $row["APELLIDOSUSUARIO"] . "</td>";
                                    echo "<td>" . $row["NOMBRESUSUARIO"] . "</td>";
                                    // URL del servicio web que proporciona los nombres clave de los cargos de usuario
                            $service_url = 'https://multiserviciossa.com/obtener_nombres_clave.php';

                            // Realizar una solicitud al servicio web y obtener la respuesta
                            $response = file_get_contents($service_url);

                            // Decodificar la respuesta JSON en un array asociativo
                            $cargo_equivalencias = json_decode($response, true);

                            // Obtener el valor del cargo de usuario de la fila actual
                            $cargo_usuario = $row["CARGOUSUARIO"];

                            // Obtener la equivalencia correspondiente si existe, o el valor original del cargo de usuario
                            $cargo_usuario_equivalencia = isset($cargo_equivalencias[$cargo_usuario]) ? $cargo_equivalencias[$cargo_usuario] : $cargo_usuario;

                            // Mostrar los datos en las celdas de la tabla
                            echo "<td>" . $row["NOMBRESUSUARIO"] . "</td>";
                            echo "<td>" . $cargo_usuario_equivalencia . "</td>";
                            
                                    echo "<td>" . $row["CORREOUSUARIO"] . "</td>";
                                    $telefono = $row["TELEFONOUSUARIO"];

                                    // Verificar si $telefono no es null y no está vacío
                                    if ($telefono !== null && $telefono !== '') {
                                        // Remover espacios en blanco y el signo de "+"
                                        $telefonoLimpio = str_replace([' ', '+'], '', $telefono);

                                        // Si el número ya tiene "593" al principio, mantenerlo
                                        if (substr($telefonoLimpio, 0, 3) === '593') {
                                            $telefonoLimpio = substr($telefonoLimpio, 3); // Eliminar "593"
                                        }

                                        // Construir el enlace
                                        if (!empty($telefonoLimpio)) {
                                            echo "<td><a href='https://wa.me/593" . $telefonoLimpio . "?text=Hola' target='_blank'>" . $telefono . "</a></td>";
                                        } else {
                                            echo "<td>Número de teléfono inválido</td>";
                                        }
                                    } else {
                                        echo "<td>Sin numero de teléfono</td>";
                                    }



                                    echo "<td style='text-align: center;'>" . $row["ESTATUSUSUARIO"] . "</td>";
                                    echo "<td style='text-align: center;'>" . $row["FREGISTROUSUARIO"] . "</td>";

                                    echo '<td >
                            <form method="post" style="display: inline;">
                                    <center>
                                        <input type="hidden" name="IDUSUARIO" value="' . $row["IDUSUARIO"] . '">
                                        <button type="submit" class="btn btn-danger btn-sm" name="eliminar">Eliminar</button>
                                        <a href="../usuario/update/updateformuser?id=' . $row["IDUSUARIO"] . '" class="btn btn-danger btn-sm">Editar</a>
                                    </center>
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
                        <a href="../usuario/create/createuserform" class="btn btn-primary mb-3">Crear Usuaio 🙍‍♂️</a>
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>