
<?php
include '../../../php/connection.php';

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Obtener la serie del equipo enviada por la petición AJAX
$serie = $_GET["serie"];

// Consulta SQL para obtener la marca del equipo según la serie
$sql = "SELECT MARCAEQUIPO FROM equipo WHERE SERIEEQUIPO = '$serie'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Si se encuentra el equipo, devolver la marca
    $row = $result->fetch_assoc();
    $marcaEquipo = $row["MARCAEQUIPO"];
    echo $marcaEquipo;
} else {
    // Si no se encuentra el equipo, devolver un mensaje indicando que no se encontró la marca
    echo "No se encontró la marca del equipo.";
}

// Cerrar la conexión con la base de datos
$conn->close();
?>
