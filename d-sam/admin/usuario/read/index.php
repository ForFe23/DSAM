<?php

session_start();

if (isset($_SESSION['CARGOUSUARIO']) && $_SESSION['CARGOUSUARIO'] === 'TRGRTNRS') {
} else {

    header("Location: https://dapcomputer.com/");
    exit;
}
?>
<?php
include '../../../../php/connection.php';


// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar formulario de eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar"])) {
    $IDUSUARIO = $_POST["IDUSUARIO"];
    $sql = "DELETE FROM usuarios WHERE IDUSUARIO = $IDUSUARIO";
    $conn->query($sql);
}

// Obtener la lista de clientes con JOIN
$sql = "SELECT usuarios.*, cliente.NOMBRECLIENTE as NOMBRECLIENTE FROM usuarios
        INNER JOIN cliente ON usuarios.IDCLIENTE = cliente.IDCLIENTE";
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
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
</head>

<body>
<button type="button" onclick="history.go(-2)" class="btn btn-secondary">Volver</button>

    <div class="container">
        <center>
            <h2 class="mb-4">Lista de usuarios</h2>
        </center>
        <!-- Mostrar la lista de clientes -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NOMBRE CLIENTE</th>
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
                            echo "<td>" . $row["IDUSUARIO"] . "</td>";
                            echo "<td>" . $row["NOMBRECLIENTE"] . "</td>";
                            echo "<td>" . $row["CEDULAUSUARIO"] . "</td>";
                            echo "<td>" . $row["APELLIDOSUSUARIO"] . "</td>";
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
                            echo "<td>" . $row["TELEFONOUSUARIO"] . "</td>";
                            echo "<td style='text-align: center;'>" . $row["ESTATUSUSUARIO"] . "</td>";
                            echo "<td style='text-align: center;'>" . $row["FREGISTROUSUARIO"] . "</td>";

                            echo '<td >
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="IDUSUARIO" value="' . $row["IDUSUARIO"] . '">
                                <button type="submit" class="btn btn-danger btn-sm" name="eliminar">Eliminar</button>
                                <a href="../update/updateformuser?id=' . $row["IDUSUARIO"] . '" class="btn btn-danger btn-sm">Editar</a>
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
                <a href="../create/createuserform" class="btn btn-primary mb-3">Crear Usuaio 🙍‍♂️</a>
            </div>
        </div>
    </div>

    <!-- Incluir Bootstrap JS y Popper.js desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Cerrar la conexión a la base de datos al finalizar
$conn->close();
?>