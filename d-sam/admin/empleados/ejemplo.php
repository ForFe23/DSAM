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
    <title>Vista con Bootstrap</title>
    <!-- Incluir Bootstrap desde CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
            color: #3bba9c;
            border-right: 5px solid #3bba9c;
        }

        .sidebar .menu .menu-item:hover {
            border-right: 5px solid #3bba9c;
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
            <h3>Menu</h3>
            <nav class="menu">
                <a href="../DashBoard.php" class="menu-item is-active">Inicio</a>
                <a href="#" class="menu-item">Empleados</a>
                <a href="#" class="menu-item">Acciones</a>

            </nav>
        </div>
        <main class="content">
            <div class="container">
                <!--Aqui Contenido -->
            </div>
        </main>
    </div>

    <!-- Incluir Google Charts JS -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</body>

</html>