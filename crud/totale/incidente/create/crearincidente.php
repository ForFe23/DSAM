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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Equipo</title>
    <link rel="stylesheet" href="../../../../style/styleedcr.css" />
    <link rel="stylesheet" href="../../../../style/style.css" />
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
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
    function actualizarEquipo($idEquipo, $idCliente)
    {
        $usuariosubida = $_SESSION["IDUSUARIO"];

        include '../../../../php/connection.php';
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



        //*******
        //INSERTAR DATOS
        //*******
        $DETALLECLIENTE = $_POST['DetalleCliente'];
        $COSTOINCIDENTE = $_POST['CostoIncidente'];
        $fechaActual = date('Y-m-d H:i:s');  // Formato 'YYYY-MM-DD HH:MM:SS'
        $RESPONSABLE = $_POST['ResponsableAtencion'];



        // Preparar la consulta SQL para actualizar un equipo existente
        $sql = "INSERT INTO incidente 
        (ID, SERIEEQUIPO, IDUSUARIO, IDCLIENTE, FECHAINCIDENTE, DETALLEINCIDENTE, COSTOINCIDENTE, RESPONSABLE )
        VALUES 
        ('$idEquipo',
        '$resultadoBusqueda', 
        '$usuariosubida', 
        '$idCliente',
        '$fechaActual',
        '$DETALLECLIENTE',
        '$COSTOINCIDENTE',
        '$RESPONSABLE'
        )";


        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("incidente CREADOS  exitosamente."); history.go(-2);</script>';
        } else {
            echo '<p>Error al actualizar el equipo: ' . $conn->error . '</p>';
        }

        // Cerrar la conexión
        $conn->close();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verifica si el formulario ha sido enviado
        if (isset($_POST['id_equipo']) && isset($_POST['id_cliente'])) {
            // Llama a la función con ambos parámetros
            actualizarEquipo($_POST['id_equipo'], $_POST['id_cliente']);
        }
    }

    include '../../../../php/connection.php';
    // Obtener el ID del equipo de la URL
    if (isset($_GET['id_equipo'])) {
        $idEquipo = $_GET['id_equipo'];
        $idCliente = $_GET['id_cliente'];



        $sql2 = "SELECT * FROM incidente WHERE ID= $idEquipo"; // Asegúrate de completar tu consulta SQL con las condiciones necesarias

        $res = $conn->query($sql2);

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc(); // Obtén la fila de resultados
        }
        //*********
        //CONSULTA DE OPCIONES
        //*********
        function obtenerOpciones($columna, $tabla)
        {
            include '../../../../php/connection.php';

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
    ?>
        <a href="../../read/crudequipos" class="btn btn-primary">

            Volver
        </a>
        <center>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <label for="DetalleCliente">DETALLE CLIENTE :</label>
                <input type="text" name="DetalleCliente" list="DetalleClienteList" oninput="this.value = this.value.toUpperCase()">
                <datalist id="DetalleClienteList">
                    <?php foreach ($CLIENTEincidenteOPCION as $CLIENTEincidenteOPCION) : ?>
                        <option value="<?php echo $CLIENTEincidenteOPCION; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <label for="CostoIncidente">RESPONSABLE DE ATENCION :</label>
                <input type="text" name="ResponsableAtencion" list="ResponsableAtencionList" oninput="this.value = this.value.toUpperCase()">
                <datalist id="ResponsableAtencionList">
                    <?php foreach ($RESPONSABLEincidenteOPCION as $RESPONSABLEincidenteOPCION) : ?>
                        <option value="<?php echo $RESPONSABLEincidenteOPCION; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <label for="CostoIncidente">COSTO DEL INCIDENTE :</label>
                <input id="price" type="tel" name="CostoIncidente" oninput="formatPrice(this)" placeholder="0.00">

                <datalist id="CostoIncidenteList">
                    <?php foreach ($CLIENTEincidenteOPCION as $CLIENTEincidenteOPCION) : ?>
                        <option value="<?php echo $CLIENTEincidenteOPCION; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <input type="submit" value="Generar Incidente">
                <!-- Campo oculto para el ID del equipo -->
                <input type="hidden" name="id_equipo" value="<?php echo $idEquipo; ?>">
                <!-- Campo oculto para el ID del cliente -->
                <input type="hidden" name="id_cliente" value="<?php echo $idCliente; ?>">

            </form>

        </center>
    <?php
    } else {
        echo "No se encontraron resultados.";
    }

    $conn->close();

    ?>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../../../scripts/dist/jquery.priceformat.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#price').priceformat({
                defaultValue: 0,
                thousandsSeparator: ',',
                suffix: ' $'
            });
        });
    </script>
    <script>
        function formatPrice(input) {
            // Remover caracteres que no son dígitos ni puntos
            input.value = input.value.replace(/[^\d.]/g, '');

            // Obtener la parte entera y la parte decimal
            var parts = input.value.split('.');
            var integerPart = parts[0];
            var decimalPart = parts[1];

            // Formatear la parte entera con separadores de miles
            integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            // Limitar la parte decimal a dos dígitos
            if (decimalPart !== undefined) {
                decimalPart = decimalPart.slice(0, 2);
            }

            // Reemplazar el valor del input con el formato adecuado
            if (decimalPart !== undefined) {
                input.value = integerPart + '.' + decimalPart;
            } else {
                input.value = integerPart;
            }
        }
    </script>
</body>

</html>