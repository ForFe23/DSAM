<?php
include '../../../../php/connection.php';

// Verificar si se proporcionó el parámetro 'id' en la URL
if (!empty($_GET['id'])) {
    $idCliente = $_GET['id'];

    // Realizar la eliminación
    $sql = "UPDATE usuarios SET ESTATUSUSUARIO = 'I' WHERE IDCLIENTE = $idCliente ";

    if ($conn->query($sql) === TRUE) {
        // Éxito
        echo "<script>alert('Usuarios de baja exitosamente');</script>";
        echo "<script>window.location.href = '../read/index';</script>";
        exit;
    } else {
        // Error
        echo "<script>alert('Error al eliminar el cliente');</script>";
    }
} else {
    // ID no proporcionado
    echo "<script>alert('ID del cliente no proporcionado');</script>";
}

// Cerrar la conexión al finalizar
$conn->close();
