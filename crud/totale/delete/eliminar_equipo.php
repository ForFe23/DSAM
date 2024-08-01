<?php
  include '../../../php/connection.php';
// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se proporcionó un ID válido para eliminar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idEquipo = $_GET['id'];

    // Iniciar transacción
    $conn->begin_transaction();

    try {
        // Consulta SQL para eliminar registros relacionados en la tabla PERIFERICOS
        $deletePerifericosSql = "DELETE FROM perifericos WHERE ID = $idEquipo";

        // Consulta SQL para eliminar registros relacionados en la tabla INCIDENTE
        $deleteIncidentesSql = "DELETE FROM incidente WHERE ID = $idEquipo";

        // Consulta SQL para eliminar el equipo con el ID proporcionado
        $deleteEquipoSql = "DELETE FROM equipo WHERE ID = $idEquipo";

        // Ejecutar las consultas
        $conn->query($deletePerifericosSql);
        $conn->query($deleteIncidentesSql);
        $conn->query($deleteEquipoSql);

        // Confirmar la transacción
        $conn->commit();

        // Redireccionar a la página de CRUD Equipos con un mensaje de éxito
        echo '<script>';
        echo 'alert("Equipo y registros relacionados eliminados exitosamente.");';
        echo 'window.location.href = "../read/crudequipos";';
        echo '</script>';
    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $conn->rollback();

        // Mostrar mensaje de error y redireccionar a la página de CRUD Equipos
        echo '<script>';
        echo 'alert("Error al eliminar el equipo y registros relacionados: ' . $e->getMessage() . '");';
        echo 'window.location.href = "../read/crudequipos";';
        echo '</script>';
    }
} else {
    // Si no se proporciona un ID válido, redirigir de todos modos a la página de CRUD Equipos
    header('Location: ../read/crudequipos');
    exit();
}

// Cerrar la conexión
$conn->close();
?>
