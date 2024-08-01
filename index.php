<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'php/connection.php';    // Verificar la conexión
    // Verificar conexión
    if ($conn->connect_error) {
        die("La conexión ha fallado: " . $conn->connect_error);
    }

    $query = "SELECT CARGOUSUARIO, SOLFRNRF, NOMBRESUSUARIO, IDCLIENTE, IDUSUARIO, ESTATUSUSUARIO FROM usuarios WHERE UPPER(CORREOUSUARIO) = UPPER(?) LIMIT 1";

    // Preparar la consulta
    $stmt = $conn->prepare($query);

    // Enlazar parámetros
    $stmt->bind_param("s", $correo_electronico);

    // Asignar valores a los parámetros y eliminar espacios en blanco
    $correo_electronico = trim($_POST["correo_electronico"]);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener resultados
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Obtener datos de usuario
        $row = $result->fetch_assoc();
        $stored_password = $row['SOLFRNRF'];
        $rol_usuario = $row['CARGOUSUARIO'];
        $nombre_usuario = $row['NOMBRESUSUARIO'];
        $idCliente = $row['IDCLIENTE'];
        $idUsuario = $row['IDUSUARIO'];
        $estado = $row['ESTATUSUSUARIO'];
        // Verificar contraseña y estado de usuario
        if (password_verify($_POST['pssd'], $stored_password) && $estado == 'A') {
            // Guardar datos del usuario en la sesión
            $_SESSION["CARGOUSUARIO"] = $rol_usuario;
            $_SESSION["NOMBREUSUARIO"] = $nombre_usuario;
            $_SESSION["IDCLIENTE"] = $idCliente;
            $_SESSION["IDUSUARIO"] = $idUsuario;
            // Redirigir según el rol
            switch ($rol_usuario) {
                case 'CMPRSGRS':
                    header("Location: d-sam/cliente/equipos/read/otro");
                    exit();
                case 'TRGRTNRS':
                    header("location: d-sam/admin/dashboard");
                    exit();
                case 'BLTRCPLS':
                    header("location: d-sam/tecnico/dashboard/index ");
                    exit();
                default:
                    header("Location: http://www.dapcomputer.com/");
                    exit();
            }
        } else {
            $login_error = "Contraseña o usuario incorrectos";
        }
    } else {
        $login_error = "Contraseña o usuario incorrectos";
    }

    // Cerrar consultas y conexión
    $stmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso D-SAM</title>
    <link rel="stylesheet" href="loginstyle.css">
    <link rel="stylesheet" href="">
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
</head>

<body style="background-color: #ebebeb;">

    <div class="login-form">

        <div class="container">
            <div class="main">
                <div class="form-img">
                    <img src="https://i.ibb.co/Dzw7v7Y/Login-Form-Dapcom.png" alt="">
                </div>
                <div class="content">
                    <img src="https://i.ibb.co/L1b8sXM/d-sam-log.png" />
                    <form method="post">
                        <label>Usuario</label>
                        <input type="text" name="correo_electronico" required autofocus="">
                        <label>Clave</label>
                        <input type="password" name="pssd" required autofocus="">
                        <button class="btn" type="submit">
                            Ingresa
                        </button>
                        <?php if (isset($login_error)) { ?>
                            <p style="color: red;"><?php echo $login_error; ?></p>
                        <?php } ?>
                    </form>
                    <p class="account" style="text-align: right;"><a href="#">¿Deseas Adquirir D-SAM?</a></p>

                </div>

            </div>
        </div>
    </div>

</body>

</html>