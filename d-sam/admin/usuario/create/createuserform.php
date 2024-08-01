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

// Obtener la lista de empresas existentes
$sqlEmpresas = "SELECT IDCLIENTE, NOMBRECLIENTE FROM cliente";
$resultEmpresas = $conn->query($sqlEmpresas);

// Procesar formulario de creación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["crear"])) {
    // Obtener el valor de IDCLIENTE del formulario
    $idcliente = $_POST["idcliente"];

    // Otros campos del formulario
    $cedula = $_POST["cedula"];
    $apellidos = $_POST["apellidos"];
    $nombres = $_POST["nombres"];
    $cargo = $_POST["cargo"];
    $correo = $_POST["correo"];
    $telefono = "+593 " . $_POST["telefono"];;
    $estatus = $_POST["estatus"];
    $fecha = $_POST["fCompraEquipo"];
    $clave = $_POST["clave"];
    $hashed_clave = password_hash($clave, PASSWORD_DEFAULT);


    $sql = "INSERT INTO usuarios (IDCLIENTE, CEDULAUSUARIO, APELLIDOSUSUARIO, NOMBRESUSUARIO, CARGOUSUARIO, CORREOUSUARIO, TELEFONOUSUARIO, ESTATUSUSUARIO, FREGISTROUSUARIO, SOLFRNRF) 
            VALUES ('$idcliente', '$cedula', '$apellidos', '$nombres', '$cargo', '$correo', '$telefono', '$estatus', '$fecha', '$hashed_clave' )";


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

?>
<?php

include '../../../../php/connection.php';
// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener los valores de CARGOUSUARIO
$sql = "SELECT DISTINCT CARGOUSUARIO FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Crear Usuario</title>
    <!-- Incluir Bootstrap desde CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
    <style>
        body {
            padding: 20px;
        }

        @media only screen and (max-width: 599px) {
            body {
                padding: 10px;
            }
        }

        @media only screen and (min-width: 600px) and (max-width: 767px) {
            body {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
<button type="button" onclick="history.back()" class="btn btn-secondary">Volver</button>

    <div class="container">
        <h2 class="mb-4">Crear Cliente</h2>

        <!-- Formulario para crear nuevo cliente -->
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Empresa cliente :</label>
                <select class="form-control" name="idcliente" required>
                    <option value="" selected>Seleccionar empresa</option>
                    <?php
                    while ($rowEmpresa = $resultEmpresas->fetch_assoc()) {
                        echo "<option value='" . $rowEmpresa['IDCLIENTE'] . "'>" . $rowEmpresa['NOMBRECLIENTE'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="nombres" class="form-label">Cedula :</label>
                <input type="number" class="form-control" name="cedula" maxlength="10" required oninput="this.value = this.value.toUpperCase()">
            </div>
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres :</label>
                <input type="text" class="form-control" id="nombres" name="nombres" required oninput="validarTexto(event)" minlength="3" oninput="this.value = this.value.toUpperCase()">
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos :</label>
                <input type="text" class="form-control" name="apellidos" required oninput="validarTexto(event)" minlength="3" required oninput="this.value = this.value.toUpperCase()">
            </div>

            <div class="mb-3">
    <label for="cargo" class="form-label">Cargos:</label>
    <select class="form-control" name="cargo" required>
        <?php
        // URL del servicio web que proporciona los nombres clave de los cargos de usuario
        $service_url = 'https://multiserviciossa.com/obtener_nombres_clave.php';

        // Realizar una solicitud al servicio web y obtener la respuesta
        $response = file_get_contents($service_url);

        // Decodificar la respuesta JSON en un array asociativo
        $enum_values = json_decode($response, true);

        // Verificar si se pudo obtener la lista de nombres clave correctamente
        if ($enum_values !== null) {
            // Iterar sobre los valores obtenidos y generar las opciones del select
            foreach ($enum_values as $key => $value) {
                echo "<option value='" . $key . "'>" . $value . "</option>";
            }
        } else {
            // Manejar el caso en que no se pueda obtener la lista de nombres clave
            echo "<option value=''>Error al obtener los nombres clave</option>";
        }
        ?>
    </select>
</div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo :</label>
                <input type="email" class="form-control" name="correo" required oninput="this.value = this.value.toUpperCase()">
            </div>
            <div class="mb-3">
                <label for="phone">Teléfono: </label><label style="color: #808080bd;"> (ejem: 096 128 6397)</label><br>
                <input id="phone" type="tel" name="telefono" placeholder="099 999 9999" required>
            </div>

            <div class="mb-3">
                <label for="licencia" class="form-label">Estado:</label>
                <select class="form-control" name="estatus" required>
                    <option value="" selected>Seleccionar estado</option>
                    <option value="A">Activo🟢</option>
                    <option value="I">Inactivo🔴</option>
                </select>
            </div>
            <div class="mb-3">
                <p>Ingresa Fecha ingreso :</p>
                <input type="date" name="fCompraEquipo" value="0000-01-01" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña:</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="contrasena" name="clave" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">Mostrar Contraseña</button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" name="crear">Crear Cliente</button>
        </form>
        <div class="alert alert-info" style="display: none;"></div>
    </div>

    <!-- Incluir Bootstrap JS y Popper.js desde CDN -->
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
    const soloLetras = /^[a-zA-Z\s]+$/; // Incluimos el espacio '\s' en la expresión regular

    if (!soloLetras.test(input.value)) {
        input.value = input.value.replace(/[^a-zA-Z\s]/g, ''); // Reemplazamos cualquier caracter que no sea una letra o espacio
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

    function formatoTelefono(event) {
        const input = event.target;
        const valor = input.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
        let nuevoValor = '';

        if (valor.length > 0) {
            // Añadir '0' al principio si no está presente
            if (valor.length < 10 && valor[0] !== '0') {
                nuevoValor = '0' + valor;
            } else {
                nuevoValor = valor.substring(0, 10); // Tomar solo los primeros 10 dígitos
            }

            nuevoValor = nuevoValor.replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3'); // Aplicar formato 099 999 9999
        }

        input.value = nuevoValor;
    }
</script>

</html>
<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>