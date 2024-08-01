<?php

// Conexión a la base de datos
include '../../../php/connection.php';
// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener todos los equipos con el nombre del cliente
$sql = "SELECT equipo.*, cliente.NOMBRECLIENTE 
        FROM equipo 
        LEFT JOIN cliente ON equipo.IDCLIENTE = cliente.IDCLIENTE";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Crear un archivo Excel
    $filename = "Reporte_general_equipos_" . date("Y-m-d_H-i-s") . ".xls";
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Estilo CSS para el formato
    echo '<style>';
    echo 'table { width: 100%; border-collapse: collapse; }';
    echo 'th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }';
    echo 'th { background-color: #f2f2f2; }';
    echo 'tr { height: 20px; }'; // Ajustar la altura de las filas aquí
    echo '</style>';

    // Salida del archivo Excel
    echo '<table>';
    echo '<tr><th>ID</th><th>Serie Equipo</th><th>Nombre Cliente</th><th>Marca Equipo</th><th>Modelo Equipo</th><th>Tipo Equipo</th><th>Sistema Operativo Equipo</th><th>Procesador Equipo</th><th>Memoria Equipo</th><th>Disco Duro Equipo</th><th>Fecha Compra Equipo</th><th>Status Equipo</th><th>IP Equipo</th><th>Ubicación Usuario</th><th>Departamento Usuario</th><th>Nombre Usuario</th><th>Nombre Proveedor</th><th>Dirección Proveedor</th><th>Teléfono Proveedor</th><th>Contacto Proveedor</th><th>Cliente</th><th>Activo Equipo</th><th>Office Equipo</th><th>Costo Equipo</th><th>Factura Equipo</th><th>Notas Equipo</th><th>Ciudad Equipo</th><th>Nombre Equipo</th></tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['ID'] . '</td>';
        echo '<td>' . $row['SERIEEQUIPO'] . '</td>';
        echo '<td>' . $row['NOMBRECLIENTE'] . '</td>';
        echo '<td>' . $row['MARCAEQUIPO'] . '</td>';
        echo '<td>' . $row['MODELOEQUIPO'] . '</td>';
        echo '<td>' . $row['TIPOEQUIPO'] . '</td>';
        echo '<td>' . $row['SOEQUIPO'] . '</td>';
        echo '<td>' . $row['PROCESADOREQUIPO'] . '</td>';
        echo '<td>' . $row['MEMORIAEQUIPO'] . '</td>';
        echo '<td>' . $row['HDDEQUIPO'] . '</td>';
        echo '<td>' . $row['FCOMPRAEQUIPO'] . '</td>';
        echo '<td>' . $row['STATUSEQUIPO'] . '</td>';
        echo '<td>' . $row['IPEQUIPO'] . '</td>';
        echo '<td>' . $row['UBICACIONUSUARIO'] . '</td>';
        echo '<td>' . $row['DEPUSUARIO'] . '</td>';
        echo '<td>' . $row['NOMBREUSUARIO'] . '</td>';
        echo '<td>' . $row['NOMBREPROVEEDOR'] . '</td>';
        echo '<td>' . $row['DIRECCIONPROVEEDOR'] . '</td>';
        echo '<td>' . $row['TELEFONOPROVEEDOR'] . '</td>';
        echo '<td>' . $row['CONTACTOPROVEEDOR'] . '</td>';
        echo '<td>' . $row['CLIENTE'] . '</td>';
        echo '<td>' . $row['ACTIVOEQUIPO'] . '</td>';
        echo '<td>' . $row['OFFICEEQUIPO'] . '</td>';
        echo '<td>' . $row['COSTOEQUIPO'] . '</td>';
        echo '<td>' . $row['FACTURAEQUIPO'] . '</td>';
        echo '<td>' . $row['NOTASEQUIPO'] . '</td>';
        echo '<td>' . $row['CIUDADEQUIPO'] . '</td>';
        echo '<td>' . $row['NOMBREEQUIPO'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo "No se encontraron equipos.";
}

// Cerrar conexión
$conn->close();
