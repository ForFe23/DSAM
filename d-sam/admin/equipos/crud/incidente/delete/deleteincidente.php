<?php
    $idEquipo = $_GET['id_equipo'];
    $fechaIncidente = $_GET['fecha'];
    include '../../../../../../php/connection.php';
    // Verificar la conexi¨®n
    if ($conn->connect_error) {
        die("Error de conexi¨®n: " . $conn->connect_error);
    }

    // Sentencia DELETE
    $sql = "DELETE FROM incidente WHERE ID = $idEquipo AND FECHAINCIDENTE = '$fechaIncidente' ;";
  

    if ($conn->query($sql) === TRUE) {
      
        // Cerrar la  
        $conn->close();
        
        // Retroceder dos veces en el historial usando JavaScript
        echo '<script>window.history.go(-2);</script>';
        exit;
    } else {
        echo "Error al eliminar el registro: " . $conn->error;
    }

    // Cerrar la conexi¨®n
    $conn->close();
?>
