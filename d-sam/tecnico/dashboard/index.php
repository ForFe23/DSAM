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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .button {
            display: inline-block;
            padding: 16px 32px;
            margin: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /*----------------------------
      preloader area
  ----------------------------*/

        .loader_bg {
            position: fixed;
            z-index: 9999999;
            background: #fff;
            width: 100%;
            height: 100%;
        }

        .loader {
            height: 100%;
            width: 100%;
            position: absolute;
            left: 0;
            top: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loader img {
            width: 280px;
        }
    </style>
</head>

<body>
    <div class="loader_bg">
        <div class="loader"><img src="https://i.ibb.co/q50WNk1/Login-Form-Dapcom.gif" alt="#" /></div>
    </div>
    <a href="../../../index" class="btn btn-danger">Salir</a>
    <div class="container">
        <img src="https://i.ibb.co/XsZSf9h/Dashboard-Logo.png" />
        <br><br><br><br>
        <a href="../escaneo/scanner" class="button">Escanear Código</a><br>
        <a href="../registrar/seleccion" class="button">Registrar Equipo</a><br>
        <a href="../buscar/index" class="button">Buscar por Código</a><br>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        window.addEventListener('load', function() {
            // Ocultar el loader
            var loaderBg = document.querySelector('.loader_bg');
            loaderBg.style.display = 'none';
        });
    </script>
</body>

</html>