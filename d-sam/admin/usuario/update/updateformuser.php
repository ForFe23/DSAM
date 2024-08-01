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

// Obtener el ID del usuario a editar
if (!empty($_GET['id'])) {
    $idUsuario = $_GET['id'];

    // Obtener datos del usuario seleccionado
    $sql = "SELECT * FROM usuarios WHERE IDUSUARIO = $idUsuario";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        echo "Usuario no encontrado.";
        exit;
    }
} else {
    echo "ID del usuario no proporcionado.";
    exit;
}

// Procesar el formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar"])) {
    $cedula = validarDatos($_POST["cedula"]);
    $apellidos = validarDatos($_POST["apellidos"]);
    $nombres = validarDatos($_POST["nombres"]);
    $cargo = validarDatos($_POST["cargo"]);
    $correo = validarDatos($_POST["correo"]);
    $telefono = validarDatos($_POST["telefono"]);
    $estatus = validarDatos($_POST["estatus"]);
    $fecha = validarDatos($_POST["fRegistroUsuario"]);
    $clave = $_POST["clave"];

    // Hash de la contraseña
    $hashed_clave = password_hash($clave, PASSWORD_DEFAULT);

    $sql = "UPDATE usuarios 
            SET CEDULAUSUARIO = '$cedula', APELLIDOSUSUARIO = '$apellidos', 
                NOMBRESUSUARIO = '$nombres', CARGOUSUARIO = '$cargo', 
                CORREOUSUARIO = '$correo', TELEFONOUSUARIO = '$telefono', 
                ESTATUSUSUARIO = '$estatus', FREGISTROUSUARIO = '$fecha',
                SOLFRNRF = '$hashed_clave'
            WHERE IDUSUARIO = $idUsuario";

    if ($conn->query($sql) === TRUE) {
        // Éxito
        echo "<script>alert('Usuario actualizado exitosamente');</script>";
        echo "<script>window.location.href = '../read/index';</script>";
        exit;
    } else {
        // Error
        echo "<script>alert('Error al actualizar el usuario');</script>";
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
    <title>Editar Usuario</title>
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
    <!-- Incluir Bootstrap desde CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        @media only screen and (max-width: 599px) {
            body {
                padding: 10px;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            body {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2 class="mb-4">Editar Usuario</h2>

        <!-- Formulario para editar el usuario -->
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $idUsuario; ?>">

            <div class="mb-3">
                <label for="cedula" class="form-label">Cédula Usuario:</label>
                <input type="number" class="form-control" name="cedula" VALUE="<?php echo $usuario['CEDULAUSUARIO']; ?>" required oninput="this.value = this.value.toUpperCase()">
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos Usuario:</label>
                <input type="text" class="form-control" name="apellidos" oninput="validarTexto(event)" VALUE="<?php echo $usuario['APELLIDOSUSUARIO']; ?>" required oninput="this.value = this.value.toUpperCase()">
            </div>
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres Usuario:</label>
                <input type="text" class="form-control" name="nombres" oninput="validarTexto(event)" VALUE="<?php echo $usuario['NOMBRESUSUARIO']; ?>" required oninput="this.value = this.value.toUpperCase()">
            </div>
            <div class="mb-3">
                <label for="cargo" class="form-label">Cargo:</label>
                <select class="form-control" name="cargo" required>
                    <?php
                    // Obtener los valores posibles del enum directamente de la definición de la tabla
                    $sql = "SHOW COLUMNS FROM usuarios WHERE Field = 'CARGOUSUARIO'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    // Extraer los valores posibles del enum
                    preg_match("/^enum\(\'(.*)\'\)$/", $row['Type'], $matches);
                    $enum_values = explode("','", $matches[1]);

                    // URL del servicio web que proporciona los nombres clave de los cargos de usuario
                    $service_url = 'https://multiserviciossa.com/obtener_nombres_clave.php';

                    // Realizar una solicitud al servicio web y obtener la respuesta
                    $response = file_get_contents($service_url);

                    // Decodificar la respuesta JSON en un array asociativo
                    $cargo_equivalencias = json_decode($response, true);

                    // Iterar sobre los valores del enum y generar las opciones del select
                    foreach ($enum_values as $value) {
                        // Obtener la equivalencia del cargo de usuario si existe, o usar el valor original si no
                        $cargo_equivalencia = isset($cargo_equivalencias[$value]) ? $cargo_equivalencias[$value] : $value;
                        // Comparar el valor actual con el valor del enum y agregar 'selected' si coinciden
                        $selected = ($usuario['CARGOUSUARIO'] == $value) ? 'selected' : '';
                        echo "<option value='" . $value . "' $selected>" . $cargo_equivalencia . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo Usuario:</label>
                <input type="email" class="form-control" name="correo" VALUE="<?php echo $usuario['CORREOUSUARIO']; ?>" required oninput="this.value = this.value.toUpperCase()">
            </div>
            <div class="mb-3">
                <label for="phone">Teléfono:</label>
                <input id="phone" type="tel" name="telefono" VALUE="<?php echo $usuario['TELEFONOUSUARIO']; ?>" required>

            </div>
            <div class="mb-3">
                <label for="estatus" class="form-label">Estatus Usuario:</label>
                <select class="form-control" name="estatus" required>
                    <option value="A" <?php echo ($usuario['ESTATUSUSUARIO'] == 'A') ? 'selected' : ''; ?>>Activo🟢</option>
                    <option value="I" <?php echo ($usuario['ESTATUSUSUARIO'] == 'I') ? 'selected' : ''; ?>>Inactivo🔴</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="fRegistroUsuario" class="form-label">Fecha de ingreso:</label>
                <input type="date" name="fRegistroUsuario" value="<?php echo $usuario['FREGISTROUSUARIO'] ? date('Y-m-d', strtotime($usuario['FREGISTROUSUARIO'])) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña:</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="contrasena" name="clave" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">Mostrar Contraseña</button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="actualizar">Actualizar Usuario</button>
        </form>
    </div>

    <!-- Incluir Bootstrap JS y Popper.js desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.9/inputmask.min.js"></script>

</body>


<script>
    const phoneInputField = document.querySelector("#phone");
    const phoneInput = window.intlTelInput(phoneInputField, {
        preferredCountries: ["ec", "co", "mx", "ve"],
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });
    const info = document.querySelector(".alert-info");

    function process(event) {
        event.preventDefault();

        const phoneNumber = phoneInput.getNumber();

        info.style.display = "";
        info.innerHTML = `Phone number in E.164 format: <strong>${phoneNumber}</strong>`;
    }

    function getIp(callback) {
        fetch('https://ipinfo.io/json?token=<your token>', {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then((resp) => resp.json())
            .catch(() => {
                return {
                    country: 'us',
                };
            })
            .then((resp) => callback(resp.country));
    }
</script>
<script>
    // Obtener el elemento del input
    var input = document.getElementById('phone');

    // Agregar un listener para el evento 'input' que se activa cuando el valor del input cambia
    input.addEventListener('input', function() {
        // Obtener el valor actual del input
        var value = this.value;

        // Reemplazar cualquier carácter que no sea un número con una cadena vacía
        var newValue = value.replace(/\D/g, '');

        // Si el valor cambiado no es igual al valor original, establecer el valor del input como el nuevo valor
        if (newValue !== value) {
            this.value = newValue;
        }
    });
</script>
<script>
    function togglePassword() {
        var passwordField = document.getElementById("contrasena");
        var toggleButton = document.querySelector('button');

        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleButton.textContent = "Ocultar Contraseña";
        } else {
            passwordField.type = "password";
            toggleButton.textContent = "Mostrar Contraseña";
        }
    }

    function validarTexto(event) {
        const input = event.target;
        const soloLetras = /^[a-zA-Z]+$/;

        if (!soloLetras.test(input.value)) {
            input.value = input.value.replace(/[^a-zA-Z]/g, '');
        }

        // Convertir el texto a mayúsculas
        input.value = input.value.toUpperCase();
    }


    document.addEventListener('DOMContentLoaded', function() {
        const phoneInputField = document.querySelector("#phone");

        // Aplicar la máscara de formato al cargar la página
        formatoTelefono({
            target: phoneInputField
        });

        // Agregar un listener para el evento 'input' que se activa cuando el valor del input cambia
        phoneInputField.addEventListener('input', formatoTelefono);
    });
</script>

</html>
<?php
// Cerrar la conexión al finalizar
$conn->close();
?>