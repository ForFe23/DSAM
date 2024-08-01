
<?php

// Verificar si se ha proporcionado un ID de cliente en la URL
if (isset($_GET['idCliente'])) {
    $idCliente = $_GET['idCliente'];
    include '../../../php/connection.php';
    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener el nombre del cliente correspondiente al ID proporcionado
    $sql_cliente = "SELECT NOMBRECLIENTE FROM cliente WHERE IDCLIENTE = $idCliente";
    $result_cliente = $conn->query($sql_cliente);

    if ($result_cliente->num_rows > 0) {
        $row_cliente = $result_cliente->fetch_assoc();
        $nombreCliente = $row_cliente['NOMBRECLIENTE'];

        // Consulta para obtener todos los equipos filtrados por el ID de cliente
        $sql = "SELECT equipo.*, cliente.NOMBRECLIENTE 
                FROM equipo 
                LEFT JOIN cliente ON equipo.IDCLIENTE = cliente.IDCLIENTE
                WHERE equipo.IDCLIENTE = $idCliente";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Crear un archivo Excel
            $filename = "Reporte_equipos_" . $nombreCliente . "_" . date("Y-m-d_H-i-s") . ".xls";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            // Estilo CSS para el formato
            echo '<style>';
            echo 'table { width: 100%; border-collapse: collapse; }';
            echo 'th, td { border: 1px solid #ddd; padding: 8px; text-align: left; width: 100px; }'; // Ancho fijo para todas las celdas
            echo 'th { background-color: #f2f2f2; }';
            echo 'tr { height: 30px; }'; // Altura fija para todas las filas
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
            echo "No se encontraron equipos para el cliente con ID: $idCliente.";
        }
    } else {
        echo "No se encontró el cliente con ID: $idCliente.";
    }

    // Cerrar conexión
    $conn->close();
} else {
    echo "No se proporcionó un ID de cliente válido en la URL.";
}

?>