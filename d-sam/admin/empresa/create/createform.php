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

// Procesar formulario de creación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["crear"])) {
    $nombre = validarDatos($_POST["nombre"]);
    $contrasena = validarDatos($_POST["contrasena"]);
    $email = validarDatos($_POST["email"]);
    $licencia = validarDatos($_POST["licencia"]);
    $Calle = validarDatos($_POST["calle"]);
    $Ciudad = validarDatos($_POST["ciudad"]);
    $fechaLicencia = date("Y/m/d"); // Esto obtiene la fecha actual en el formato día/mes/año


    $sql = "INSERT INTO cliente (NOMBRECLIENTE, CONTRASENACLIENTE, EMAIL, LICENCIACLIENTE, Calle, Ciudad, FECHALICENCIA) 
            VALUES ('$nombre', '$contrasena', '$email', '$licencia','$Calle','$Ciudad','$fechaLicencia')";

    if ($conn->query($sql) === TRUE) {
        // Éxito
        echo "<script>alert('Cliente creado exitosamente');</script>";
        echo "<script>window.location.href = '../read/index';</script>";
        exit;
    } else {
        // Error
        echo "<script>alert('Error al crear el cliente');</script>";
    }
}

// Función para limpiar y validar datos
function validarDatos($datos)
{
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Crear Cliente</title>
    <!-- Incluir Bootstrap desde CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
    <style>
        body {
            padding: 20px;
        }

        @media only screen and (max-width: 599px) {

            /* Estilos para teléfonos en orientación vertical con una resolución máxima de 599px */
            body {
                padding: 10px;
            }
        }

        @media only screen and (min-width: 600px) and (max-width: 767px) {

            /* Estilos para dispositivos con una resolución entre 600px y 767px */
            body {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2 class="mb-4">Crear Cliente</h2>

        <!-- Formulario para crear nuevo cliente -->
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre Cliente:</label>
                <input type="text" class="form-control" name="nombre" required  oninput="this.value = this.value.toUpperCase()">
            </div>
           
            <div class="mb-3">
                <label for="email" class="form-label">Email Cliente:</label>
                <input type="email" class="form-control" name="email" required  oninput="this.value = this.value.toUpperCase()">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Calle Cliente:</label>
                <input type="text" class="form-control" name="calle" required  oninput="this.value = this.value.toUpperCase()">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Ciudad Cliente:</label>
                <select class="form-control" name="ciudad" required>
                    <option value="" selected disabled>Selecciona una ciudad</option>
                    <option value="Guayaquil">Guayaquil</option>
                    <option value="Quito">Quito</option>
                    <option value="Cuenca">Cuenca</option>
                    <option value="Santo Domingo de los Colorados">Santo Domingo de los Colorados</option>
                    <option value="Eloy Alfaro">Eloy Alfaro</option>
                    <option value="Machala">Machala</option>
                    <option value="Manta">Manta</option>
                    <option value="Portoviejo">Portoviejo</option>
                    <option value="Loja">Loja</option>
                    <option value="Quevedo">Quevedo</option>
                    <option value="Ambato">Ambato</option>
                    <option value="Riobamba">Riobamba</option>
                    <option value="Daule">Daule</option>
                    <option value="Milagro">Milagro</option>
                    <option value="Ibarra">Ibarra</option>
                    <option value="Esmeraldas">Esmeraldas</option>
                    <option value="La Libertad">La Libertad</option>
                    <option value="Babahoyo">Babahoyo</option>
                    <option value="Sangolquí">Sangolquí</option>
                    <option value="Latacunga">Latacunga</option>
                    <option value="Pasaje">Pasaje</option>
                    <option value="Santa Rosa">Santa Rosa</option>
                    <option value="Tulcán">Tulcán</option>
                    <option value="Huaquillas">Huaquillas</option>
                    <option value="Nueva Loja">Nueva Loja</option>
                    <option value="Santa Elena">Santa Elena</option>
                    <option value="Puerto Francisco de Orellana">Puerto Francisco de Orellana</option>
                    <option value="Otavalo">Otavalo</option>
                    <option value="La Troncal">La Troncal</option>
                    <option value="Azogues">Azogues</option>
                    <option value="Salinas">Salinas</option>
                    <option value="Puyo">Puyo</option>
                    <option value="Guaranda">Guaranda</option>
                    <option value="Tena">Tena</option>
                    <option value="Atuntaqui">Atuntaqui</option>
                    <option value="Macas">Macas</option>
                    <option value="Valle">Valle</option>
                    <option value="Zamora">Zamora</option>
                    <option value="San Antonio de Ibarra">San Antonio de Ibarra</option>
                    <option value="Puerto Ayora">Puerto Ayora</option>
                    <option value="Sinincay">Sinincay</option>
                    <option value="Pelileo">Pelileo</option>
                    <option value="Zaruma">Zaruma</option>
                    <option value="Saquisilí">Saquisilí</option>
                    <option value="Puerto Baquerizo Moreno">Puerto Baquerizo Moreno</option>
                    <option value="Chordeleg">Chordeleg</option>
                    <option value="Llacao">Llacao</option>
                    <option value="Cevallos">Cevallos</option>
                </select>

            </div>
            <div class="mb-3">
                <label for="licencia" class="form-label">Licencia Cliente:</label>

                <select class="form-control" name="licencia" required>
                    <option value="error" selected>Seleccionar..</option>
                    <option value="1 AÑO">1 AÑO</option>
                    <option value="DEMO">DEMO</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="crear">Crear Cliente</button>
            <div style="visibility: hidden;" class="mb-3">
                <label for="contrasena" class="form-label">Contraseña Cliente:</label>
                <input type="password" class="form-control" value="-" name="contrasena" required>
            </div>
        </form>
    </div>

    <!-- Incluir Bootstrap JS y Popper.js desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Cerrar la conexión a la base de datos al finalizar
$conn->close();
?>