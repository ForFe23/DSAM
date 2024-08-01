<?php
  include 'connection.php';
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
        $deletePerifericosSql = "DELETE FROM PERIFERICOS WHERE ID = $idEquipo";

        // Consulta SQL para eliminar registros relacionados en la tabla INCIDENTE
        $deleteIncidentesSql = "DELETE FROM INCIDENTE WHERE ID = $idEquipo";

        // Consulta SQL para eliminar el equipo con el ID proporcionado
        $deleteEquipoSql = "DELETE FROM EQUIPO WHERE ID = $idEquipo";

        // Ejecutar las consultas
        $conn->query($deletePerifericosSql);
        $conn->query($deleteIncidentesSql);
        $conn->query($deleteEquipoSql);

        // Confirmar la transacción
        $conn->commit();

        // Redireccionar a la página de CRUD Equipos con un mensaje de éxito
        echo '<script>';
        echo 'alert("Equipo y registros relacionados eliminados exitosamente."); history.go(-1);</script>';

        echo '</script>';
    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $conn->rollback();

        // Mostrar mensaje de error y redireccionar a la página de CRUD Equipos
        echo '<script>';
        echo 'alert("Error al eliminar el equipo y registros relacionados: ' . $e->getMessage() . '");';
        echo 'window.location.href = "../../CRUD/READ/crudEquipos.php";';
        echo '</script>';
    }
} else {
    // Si no se proporciona un ID válido, redirigir de todos modos a la página de CRUD Equipos
    header('Location: ../../CRUD/READ/crudEquipos.php');
    exit();
}

// Cerrar la conexión
$conn->close();