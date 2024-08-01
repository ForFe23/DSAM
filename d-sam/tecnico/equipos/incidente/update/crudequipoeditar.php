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
    <title>Crear Equipo</title>
    <link rel="stylesheet" href="../../../../style/styleedcr.css" />
    <link rel="stylesheet" href="../../../../style/style.css" />
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            /* Fondo gris claro */
            padding: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="tel"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }


        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
    <style scoped>
        .btn {
            text-decoration: none;
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-primary:focus,
        .btn-primary.focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
        }
    </style>
</head>

<body>

    <?php
    function actualizarEquipo($idEquipo, $fechaIncidente)
    {
        include '../../../../../php/connection.php';

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }
        //*******
        //OBTENER SERIE EQUIPO
        //*******
        $sqlObtenerSerie = "SELECT SERIEEQUIPO FROM equipo WHERE ID=$idEquipo;";
        $resultadoObtenerSerie = $conn->query($sqlObtenerSerie);
        if ($resultadoObtenerSerie->num_rows > 0) {
            $busquedaSerie = $resultadoObtenerSerie->fetch_assoc(); // Obtén la fila de resultados
        }



        $resultadoBusqueda = $busquedaSerie['SERIEEQUIPO'];
        $usuariosubida = 6;
        $DETALLECLIENTE = $_POST['DetalleCliente'];
        $COSTOINCIDENTE = $_POST['CostoIncidente'];
        $fechaActual = date('Y-m-d H:i:s');  // Formato 'YYYY-MM-DD HH:MM:SS'
        $RESPONSABLE = $_POST['ResponsableAtencion'];


        // Preparar la consulta SQL para actualizar un equipo existente
        $sql = "UPDATE  incidente 
        SET
        DETALLEINCIDENTE = '$DETALLECLIENTE',
        COSTOINCIDENTE = '$COSTOINCIDENTE',
        RESPONSABLE =  '$RESPONSABLE'
        WHERE FECHAINCIDENTE = '$fechaIncidente';";



        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Equipo actualizado exitosamente."); history.go(-2);</script>';
        } else {
            echo '<p>Error al actualizar el equipo: ' . $conn->error . '</p>';
        }

        // Cerrar la conexión
        $conn->close();
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verifica si el formulario ha sido enviado
        if (isset($_POST['id_equipo'])) {
            // Llama a la función solo si el ID del equipo está presente
            actualizarEquipo($_POST['id_equipo'], $_POST['fecha_incidente']);
        }
    }

    include '../../../../../php/connection.php';
    // Obtener el ID del equipo de la URL
    if (isset($_GET['id_equipo'])) {
        $idEquipo = $_GET['id_equipo'];
        $fecha = $_GET['fecha'];


        $sql2 = "SELECT * FROM incidente WHERE ID= $idEquipo AND FECHAINCIDENTE = '$fecha'"; // Asegúrate de completar tu consulta SQL con las condiciones necesarias

        $res = $conn->query($sql2);

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc(); // Obtén la fila de resultados


        }
        //*********
        //CONSULTA DE OPCIONES
        //*********
        function obtenerOpciones($columna, $tabla)
        {
            include '../../../../../php/connection.php';

            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

            $opciones = [];

            $result = $conn->query("SELECT DISTINCT $columna FROM $tabla");

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $opciones[] = $row[$columna];
                }
            }

            return $opciones;
        }
        //*********
        //OPCIONES EN FORMULARIO
        //*********
        $DETALLEINCIDENTEOPCIONES = obtenerOpciones('DETALLEINCIDENTE', 'incidente');
        $COSTOINCIDENTEOPCIONES = obtenerOpciones('COSTOINCIDENTE', 'incidente');
        $RESPONSABLEincidenteOPCION = obtenerOpciones('RESPONSABLE', 'incidente');
    ?>
        <a onclick='Retroceder(this)' class="btn btn-primary">

            Volver
        </a>
        <center>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <label for="DetalleCliente">DETALLE CLIENTE :</label>
                <input type="text" name="DetalleCliente" VALUE="<?php echo $row['DETALLEINCIDENTE']; ?>" required list="DetalleClienteList" oninput="this.value = this.value.toUpperCase()" s>
                <datalist id="DetalleClienteList">
                    <?php foreach ($DETALLEINCIDENTEOPCIONES as $DETALLEINCIDENTEOPCIONES) : ?>
                        <option value="<?php echo $DETALLEINCIDENTEOPCIONES; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <label for="CostoIncidente">RESPONSABLE DE ATENCION :</label>
                <input type="text" name="ResponsableAtencion" list="ResponsableAtencionList" value="<?php echo $row['RESPONSABLE']; ?>" oninput="this.value = this.value.toUpperCase()">
                <datalist id="ResponsableAtencionList">
                    <?php foreach ($RESPONSABLEincidenteOPCION as $RESPONSABLEincidenteOPCION) : ?>
                        <option value="<?php echo $RESPONSABLEincidenteOPCION; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <label for="CostoIncidente">COSTO DEL INCIDENTE :</label><br>
                <!-- El campo de texto -->
                <!-- El campo de número -->
                <input type="number" step="0.01" name="CostoIncidente" id="CostoIncidente" value="<?php echo $row['COSTOINCIDENTE']; ?>" required list="CostoIncidenteList" oninput="formatDecimal(this)">

                <!-- Script JavaScript -->

                <datalist id="CostoIncidenteList">
                    <?php foreach ($COSTOINCIDENTEOPCIONES as $COSTOINCIDENTEOPCIONES) : ?>
                        <option value="<?php echo $COSTOINCIDENTEOPCIONES; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <input type="submit" value="Actualizar Equipo">
                <!-- Campo oculto para el ID del equipo -->
                <input type="hidden" name="id_equipo" value="<?php echo $idEquipo; ?>">
                <!-- Campo oculto para el ID del cliente -->
                <input type="hidden" name="id_cliente" value="<?php echo $idCliente; ?>">
                <!-- Campo oculto para el ID del cliente -->
                <input type="hidden" name="fecha_incidente" value="<?php echo $fecha; ?>">
            </form>
        </center>
    <?php
    } else {
        echo "No se encontraron resultados.";
    }

    $conn->close();

    ?>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../../../../scripts/dist/jquery.priceformat.js"></script>
    <script type="text/javascript" src=""></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#price').priceformat({
                defaultValue: 0,
                thousandsSeparator: ',',
                suffix: ' $'
            });

            // Variable para almacenar el valor predeterminado del marcador de posición
            var placeholderValue = '<?php echo $row['COSTOINCIDENTE']; ?>';

            // Evento focus: elimina el marcador de posición cuando el campo obtiene foco
            $('#price').focus(function() {
                $(this).attr('placeholder', '');
            });

            // Evento blur: restablece el marcador de posición solo si el campo está vacío
            $('#price').blur(function() {
                if ($(this).val() === '') {
                    $(this).attr('placeholder', placeholderValue);
                }
            });
        });
    </script>
    <script>
        function Retroceder(button) {
            window.history.go(-1);
        }
    </script>

    <!-- Script JavaScript -->
    <script>
        function validateNumberInput(input) {
            // Obtener el valor actual del campo
            let value = input.value;

            // Verificar si el valor es un número
            if (!isNumeric(value)) {
                // Si no es un número, eliminar el último carácter
                input.value = value.slice(0, -1);
            }
        }

        function isNumeric(value) {
            // Esta función verifica si el valor es numérico
            return /^\d+$/.test(value);
        }
    </script>
    <script>
        function formatDecimal(input) {
            // Obtener el valor actual del campo
            let value = input.value;

            // Convertir el valor a un número flotante con 2 decimales
            let floatValue = parseFloat(value);

            // Verificar si es un número válido
            if (!isNaN(floatValue)) {
                // Redondear el número a 2 decimales
                let roundedValue = floatValue.toFixed(2);

                // Actualizar el valor del campo
                input.value = roundedValue;
            }
        }
    </script>
</body>

</html>