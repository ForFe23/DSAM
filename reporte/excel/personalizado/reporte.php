<?php
include '../../../php/connection.php';
// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Construir la consulta SQL base
$sql = "SELECT equipo.*, cliente.NOMBRECLIENTE 
        FROM equipo 
        LEFT JOIN cliente ON equipo.IDCLIENTE = cliente.IDCLIENTE";

// Construir la parte del WHERE para aplicar los filtros
$where = " WHERE 1=1"; // Por defecto, siempre verdadero para evitar errores de sintaxis SQL

// Verificar si se han proporcionado filtros y agregarlos a la consulta SQL
if (!empty($_GET['marca'])) {
    $marca = $_GET['marca'];
    $where .= " AND MARCAEQUIPO = '$marca'";
}

if (!empty($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
    $where .= " AND TIPOEQUIPO = '$tipo'";
}

if (!empty($_GET['status'])) {
    $status = $_GET['status'];
    $where .= " AND STATUSEQUIPO = '$status'";
}

if (!empty($_GET['ubicacion'])) {
    $ubicacion = $_GET['ubicacion'];
    $where .= " AND UBICACIONUSUARIO = '$ubicacion'";
}

if (!empty($_GET['nombreusuario'])) {
    $nombreusuario = $_GET['nombreusuario'];
    $where .= " AND NOMBREUSUARIO = '$nombreusuario'";
}

if (!empty($_GET['cliente'])) {
    $cliente = $_GET['cliente'];
    $where .= " AND cliente.NOMBRECLIENTE = '$cliente'";
}

// Combinar la consulta base con la parte del WHERE
$sql .= $where;

// Ejecutar la consulta SQL
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Crear un nombre personalizado para el archivo Excel
    $nombre_archivo = "reporte_personalizado_" . date("Y-m-d_H-i-s");

    // Agregar los filtros aplicados al nombre del archivo
    foreach ($_GET as $filtro => $valor) {
        if (!empty($valor)) {
            $nombre_archivo .= "_$filtro-$valor";
        }
    }

    // Agregar la extensión al nombre del archivo
    $nombre_archivo .= ".xls";

    // Cabeceras para la descarga del archivo Excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $nombre_archivo . '"');

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

    // Iterar sobre los resultados y generar las filas del archivo Excel
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
