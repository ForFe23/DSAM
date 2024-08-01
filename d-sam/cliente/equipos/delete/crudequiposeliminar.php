<?php
 include '../../../../php/connection.php';

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se proporcionó un ID válido para eliminar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idEquipo = $_GET['id'];

    // Consulta SQL para obtener información del equipo antes de la eliminación
    $selectSql = "SELECT * FROM equipo WHERE ID = $idEquipo";
    $result = $conn->query($selectSql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Mostrar confirmación con JavaScript
        echo '<script>';
        echo 'var confirmDelete = confirm("¿Estás seguro de que quieres eliminar el equipo con ID ' . $idEquipo . ' y todos sus registros relacionados?");';
        echo 'if (confirmDelete) {';
        echo '  window.location.href = "eliminar_equipo?id=' . $idEquipo . '";';
        echo '} else {';
        echo ' history.go(-1);';
        echo '}';
        echo '</script>';
    } else {
        // Si no se encuentra el equipo, redirigir a la página de CRUD Equipos
        header('Location: ../../crud/read/crudequipos');
        exit();
    }
} else {
    // Si no se proporciona un ID válido, redirigir de todos modos a la página de CRUD Equipos
    header('Location: ../../crud/read/crudequipos');
    exit();
}

// Cerrar la conexión
$conn->close();
?>
