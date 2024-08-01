<?php
    $idEquipo = $_GET['id_equipo'];

    include '../../../../../../php/connection.php';
    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Sentencia DELETE
    $sql = "DELETE FROM perifericos WHERE ID = $idEquipo";

    if ($conn->query($sql) === TRUE) {
        echo "Registro eliminado correctamente";
        
        // Cerrar la conexión
        $conn->close();
        
        // Retroceder dos veces en el historial usando JavaScript
        echo '<script>window.history.go(-2);</script>';
        exit;
    } else {
        echo "Error al eliminar el registro: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
?>
