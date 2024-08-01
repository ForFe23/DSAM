<?php

// Conexión a la base de datos
include '../../../php/connection.php';
// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener todos los incidentes con los datos necesarios, incluyendo el nombre del usuario y del cliente
$sql = "SELECT 
            i.SERIEEQUIPO, 
            u.NOMBRESUSUARIO AS NOMBRE_USUARIO,
            c.NOMBRECLIENTE AS NOMBRE_CLIENTE, 
            i.FECHAINCIDENTE, 
            i.DETALLEINCIDENTE, 
            i.RESPONSABLE,
            i.COSTOINCIDENTE 
        FROM 
            incidente i 
        LEFT JOIN 
            usuarios u ON i.IDUSUARIO = u.IDUSUARIO 
        LEFT JOIN 
            cliente c ON i.IDCLIENTE = c.IDCLIENTE
        ORDER BY i.SERIEEQUIPO"; // Ordenar por serie de equipo

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Crear un archivo Excel
    $filename = "Reporte_general_incidentes_" . date("Y-m-d_H-i-s") . ".xls";
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Estilo CSS para el formato
    echo '<style>';
    echo 'table { width: 100%; border-collapse: collapse; }';
    echo 'th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }';
    echo 'th { background-color: #f2f2f2; }';
    echo 'tr { height: 20px; }'; // Ajustar la altura de las filas aquí
    echo '</style>';

    // Inicializar el ID del equipo actual
    $current_equipment_id = null;

    // Salida del archivo Excel
    echo '<table>';
    echo '<tr><th>Serie Equipo</th><th>Nombre Usuario</th><th>Nombre Cliente</th><th>Fecha Incidente</th><th>Detalle Incidente</th><th>Costo Incidente</th><th>Responsable de Atencion</th></tr>';

    while ($row = $result->fetch_assoc()) {
        // Verificar si el ID del equipo ha cambiado
        if ($row['SERIEEQUIPO'] !== $current_equipment_id) {
            // Agregar salto de fila si el ID del equipo ha cambiado
            if ($current_equipment_id !== null) {
                echo '<tr style="background-color: #f2f2f2;"><td colspan="6"></td></tr>'; // Fila de separación
            }
            $current_equipment_id = $row['SERIEEQUIPO'];
        }

        // Imprimir información del incidente
        echo '<tr>';
        echo '<td>' . $row['SERIEEQUIPO'] . '</td>';
        echo '<td>' . $row['NOMBRE_USUARIO'] . '</td>';
        echo '<td>' . $row['NOMBRE_CLIENTE'] . '</td>';
        echo '<td>' . $row['FECHAINCIDENTE'] . '</td>';
        echo '<td>' . $row['DETALLEINCIDENTE'] . '</td>';
        echo '<td>' . $row['COSTOINCIDENTE'] . '</td>';
        echo '<td>' . $row['RESPONSABLE'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo "No se encontraron incidentes.";
}

// Cerrar conexión
$conn->close();
