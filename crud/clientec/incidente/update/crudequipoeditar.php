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
    <link rel="stylesheet" href="../../../../Style/styleEdCr.css" />
    <link rel="stylesheet" href="../../../../Style/style.css" />
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">

</head>

<body>

    <?php
    function actualizarEquipo($idEquipo, $fechaIncidente)
    {
        // Resto del código de procesamiento del formulario...
        echo 'hola';
        include 'connection.php';
        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }
        //*******
        //OBTENER SERIE EQUIPO
        //*******
        $sqlObtenerSerie = "SELECT SERIEEQUIPO FROM EQUIPO WHERE ID=$idEquipo;";
        $resultadoObtenerSerie = $conn->query($sqlObtenerSerie);
        if ($resultadoObtenerSerie->num_rows > 0) {
            $busquedaSerie = $resultadoObtenerSerie->fetch_assoc(); // Obtén la fila de resultados
        }



        $resultadoBusqueda = $busquedaSerie['SERIEEQUIPO'];
        echo "resultado de busqueda " . $resultadoBusqueda . "\n";
        echo "id del equipo es " . $idEquipo . "\n";

        $usuariosubida = 6;
        echo " " . $usuariosubida;
        $DETALLECLIENTE = $_POST['DetalleCliente'];
        $COSTOINCIDENTE = $_POST['CostoIncidente'];
        $fechaActual = date('Y-m-d H:i:s');  // Formato 'YYYY-MM-DD HH:MM:SS'



        // Preparar la consulta SQL para actualizar un equipo existente
        $sql = "UPDATE  incidente 
        SET
        DETALLEINCIDENTE = '$DETALLECLIENTE',
        COSTOINCIDENTE = '$COSTOINCIDENTE'
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

    $servername = "localhost";
    $username = "root";
    $password = ""; // Deja esto vacío si no tienes contraseña
    $dbname = "basedap";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Obtener el ID del equipo de la URL
    if (isset($_GET['id_equipo'])) {
        $idEquipo = $_GET['id_equipo'];
        $fecha = $_GET['fecha'];


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
            $servername = "localhost";
            $username = "root";
            $password = ""; // Deja esto vacío si no tienes contraseña
            $dbname = "basedap";

            $conn = new mysqli($servername, $username, $password, $dbname);

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


    ?>



        <center>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <label for="DetalleCliente">DETALLE CLIENTE :</label>
                <input type="text" name="DetalleCliente" placeholder="<?php echo $row['DETALLEINCIDENTE']; ?>" required list="DetalleClienteList" oninput="this.value = this.value.toUpperCase()" >
                <datalist id="DetalleClienteList">
                    <?php foreach ($DETALLEINCIDENTEOPCIONES as $DETALLEINCIDENTEOPCIONES) : ?>
                        <option value="<?php echo $DETALLEINCIDENTEOPCIONES; ?>">
                        <?php endforeach; ?>
                </datalist>
                <br>
                <label>COSTO ORIGINAL: <?php echo $row['COSTOINCIDENTE']; ?></label><br>
                <label for="CostoIncidente">COSTO DEL INCIDENTE :</label>
                <input id="price" type="tel" name="CostoIncidente" oninput="formatPrice(this)" placeholder="<?php  ?>">
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
    <script type="text/javascript" src="../../../../../Scripts/dist/jquery.priceformat.js"></script>
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


</body>

</html>