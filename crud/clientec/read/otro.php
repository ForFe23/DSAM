<?php

session_start();

if (isset($_SESSION['CARGOUSUARIO']) && $_SESSION['CARGOUSUARIO'] === 'TRGRTNRS') {
} else {

    header("Location: https://dapcomputer.com/");
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>D SAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../Style/style.css" />
    <script src="../../../../Scripts/BotonMostrar.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="../../../../Scripts/AdminRead.js"></script>
    <script src="../../../../QRCODE/qrcode.js"></script>
    <script src="../../../../QRCODE/qrcode.min.js"></script>
    <script src="qrcode.js"></script>
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">
</head>

<body>
    <?php

    // *******************
    // DEPENDENCIA CODIGO QR
    // *******************
    require "../../../../phpqrcode/qrlib.php";
    // *******************
    // RELOAD PAGE
    // *******************
    // Verifica si la variable de sesión "reloadOnce" está presente
    if (!isset($_SESSION['reloadOnce'])) {
        // Si no está presente, realiza la recarga y establece la variable de sesión
        echo '<script>window.onload = function() { location.reload(); }</script>';
        $_SESSION['reloadOnce'] = true;
    }

    if (isset($_GET['idCliente'])) {
        // Obtener el valor de idCliente
        $idCliente = $_GET['idCliente'];
    } else {
        // Manejar el caso en que el parámetro no esté presente
        echo "ID Cliente no proporcionado.";
    }
    include 'connection.php';
    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta SQL para obtener todos los datos de EQUIPO con el nombre del cliente
    $sql = "SELECT EQUIPO.*, CLIENTE.NOMBRECLIENTE
      FROM EQUIPO
      INNER JOIN CLIENTE ON EQUIPO.IDCLIENTE = CLIENTE.IDCLIENTE
      WHERE EQUIPO.IDCLIENTE = $idCliente";
    $result = $conn->query($sql);
    //TRAER NOMOBRE DE LA EMPRESA
    $sqltitulo = "SELECT NOMBRECLIENTE FROM CLIENTE WHERE IDCLIENTE = $idCliente  ;";
    $resultadotitulo = $conn->query($sqltitulo);
    $rowtitulo = $resultadotitulo->fetch_assoc();
    $nombreCliente = $rowtitulo['NOMBRECLIENTE'];
    ?>
    <input type="text" id="filtroEquipo" placeholder="Filtrar...">

    <h2>Equipos de <?php echo $nombreCliente; ?></h2>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>QR</th>
                    <th>Acciones</th>
                    <th>Administrar</th>
                    <th>ID</th>
                    <th>Serie Equipo</th>
                    <th>ID Cliente</th>
                    <th>Marca Equipo</th>
                    <th>Modelo Equipo</th>
                    <th>Tipo</th>
                    <th>Sistema Op</th>
                    <th>Procesador</th>
                    <th>Memoria</th>
                    <th>HDD</th>
                    <th>Fecha Compra</th>
                    <th>Status</th>
                    <th>IP</th>
                    <th>Ubicacion</th>
                    <th>Departamento</th>
                    <th>Usuario</th>
                    <th>Proveedor</th>
                    <th>Direccion Proveedor</th>
                    <th>Telefono Proveedor</th>
                    <th>Contacto Proveedor</th>
                    <th>Activo N°</th>
                    <th>Office</th>
                    <th>Costo</th>
                    <th>N° Factura</th>
                    <th>Nota</th>
                    <th>Ciudad</th>
                    <th>Nombre Equipo</th>

                </tr>
            </thead>

            <tbody>
                <?php

                if ($result->num_rows > 0) {
                    $serialNumber = 1;

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        //****************************
                        //GENERAR CODIGO QR DE EQUIPOS
                        //****************************
                        // Parámetros de Configuración
                        $tamaño = 4; // Tamaño de Pixel
                        $level = 'L'; // Precisión Baja
                        $framSize = 1; // Tamaño en blanco
                        //variable de la serie del equipo
                        $contenido = $row['SERIEEQUIPO'];
                        // Buffer de salida para que la imagen se muestre directamente en el navegador
                        ob_start();
                        // Enviamos los parámetros a la Función para generar código QR 
                        QRcode::png($contenido, null, $level, $tamaño, $framSize);
                        // Capturamos el contenido del buffer y lo asignamos a una variable
                        $imagenQR = ob_get_contents();
                        // Limpiamos el buffer
                        ob_end_clean();

                        // MANDAR DATOS A PRELIMINAR DE IMPRESION
                        $imagenAdicional = 'https://i.ibb.co/BKj38K9/dapcomlogo.jpg';
                        $ActivoImgPreliminar = $row["ACTIVOEQUIPO"];
                        $NomEquipImgPreliminar = $row["NOMBREEQUIPO"];
                        echo "<td data-label='codigo qr'>";
                        echo "<a href='#' onclick='openImageWindow(\"data:image/png;base64," . base64_encode($imagenQR) . "\", \"$imagenAdicional\", \"$ActivoImgPreliminar\", \"$NomEquipImgPreliminar\")'><img src='data:image/png;base64," . base64_encode($imagenQR) . "' /></a>";
                        echo "</td>";
                        echo '<script>
                        function openImageWindow(qrData, imageData, activo, nombreEquipo) {
                            var imageWindow = window.open("", "_blank", "toolbar=no,scrollbars=yes,resizable=yes,top=50%,left=50%,width=800,height=1000");
                            imageWindow.document.write("<img src=\'" + imageData + "\' style=\'max-width:50%;max-height:90px;float:inline-start;\' />");
                            imageWindow.document.write("<img src=\'" + qrData + "\' style=\'max-width:1--00%;max-height:100%;float:inline-start;\' />");
                            imageWindow.document.write("<p>Activo: " + activo + "</p>");
                            imageWindow.document.write("<p>Nombre de Equipo: " + nombreEquipo + "</p>");
                        }
                        </script>';
                        //****************************
                        //FIN GENERAR CODIGO QR DE EQUIPO
                        //****************************
                        echo "<td data-label='Acciones'><br>";
                        echo "<div class='Acciones'>";

                        echo "<a href='../Perifericos/READ/Index.php?id_equipo=" . $row['ID'] . "&id_cliente=" . $idCliente . "' class='btn btn-primary btn-sm'> Perifericos </a>";
                        echo "<br><br>";
                        echo "<a href='../incidente/READ/Index.php?id_equipo=" . $row['ID'] . "&id_cliente=" . $idCliente . "' class='btn btn-primary btn-sm'> Incidentes </a>";
                        echo "</div>";
                        echo "</td>";
                        // Agregar botones en la última celda
                        echo "<center><td data-label='Administrativo'></center>";
                        echo "<div class='BtnEditar'> ";
                        echo "<a href='../UPDATE/crudEquipoEditar.php?id_equipo=" . $row['ID'] . "' class='btn btn-primary btn-sm'>Editar</a>";
                        echo "</div>";
                        echo "<div class='BtnEliminar'> ";
                        echo "<a href='../Delete/crudEquiposEliminar.php?id=" . $row['ID'] . "' class='btn btn-danger btn-smElim'>Eliminar</a>";
                        echo "</div>";
                        //MANDAR DATOS A SCRIPT
                        echo "<button class='btn btn-info btn-sm'     
         data-id='{$row['ID']}'
         data-serie='{$row['SERIEEQUIPO']}'
         data-cliente='{$row['NOMBRECLIENTE']}'
         data-marca='{$row['MARCAEQUIPO']}'
         data-modelo='{$row['MODELOEQUIPO']}'
         data-tipo='{$row['TIPOEQUIPO']}'
         data-so='{$row['SOEQUIPO']}'
         data-procesador='{$row['PROCESADOREQUIPO']}'
         data-memoria='{$row['MEMORIAEQUIPO']}'
         data-hdd='{$row['HDDEQUIPO']}'
         data-fecha-compra='{$row['FCOMPRAEQUIPO']}'
         data-status='{$row['STATUSEQUIPO']}'
         data-ip='{$row['IPEQUIPO']}'
         data-ubicacion='{$row['UBICACIONUSUARIO']}'
         data-departamento='{$row['DEPUSUARIO']}'
         data-usuario='{$row['NOMBREUSUARIO']}'
         data-proveedor='{$row['NOMBREPROVEEDOR']}'
         data-direccion-proveedor='{$row['DIRECCIONPROVEEDOR']}'
         data-telefono-proveedor='{$row['TELEFONOPROVEEDOR']}'
         data-email-proveedor='{$row['CONTACTOPROVEEDOR']}'
         data-activo-numero='{$row['ACTIVOEQUIPO']}'
         data-office='{$row['OFFICEEQUIPO']}'
         data-costo='{$row['COSTOEQUIPO']}'
         data-numero-factura='{$row['FACTURAEQUIPO']}'
         data-nota='{$row['NOTASEQUIPO']}'
         data-ciudad='{$row['CIUDADEQUIPO']}'
         data-nombre-equipo='{$row['NOMBREEQUIPO']}'
         onclick='mostrarVistaGeneral(this)'>Vista General</button>";
                        echo "</td>";
                        //FIN MANDAR DATOS A SCRIPT

                        echo "<td data-label='Serie Equipo'>" . ($row["ID"] ? $row["ID"] : '-') . "</td>";
                        echo "<td data-label='Serie Equipo'>" . ($row["SERIEEQUIPO"] ? $row["SERIEEQUIPO"] : '-') . "</td>";
                        echo "<td data-label='ID Cliente'>" . ($row["NOMBRECLIENTE"] ? $row["NOMBRECLIENTE"] : '-') . "</td>";
                        echo "<td data-label='Marca Equipo'>" . ($row["MARCAEQUIPO"] ? $row["MARCAEQUIPO"] : '-') . "</td>";
                        echo "<td data-label='Modelo Equipo'>" . ($row["MODELOEQUIPO"] ? $row["MODELOEQUIPO"] : '-') . "</td>";
                        echo "<td data-label='Tipo'>" . ($row["TIPOEQUIPO"] ? $row["TIPOEQUIPO"] : '-') . "</td>";
                        echo "<td data-label='Sistema Op'>" . ($row["SOEQUIPO"] ? $row["SOEQUIPO"] : '-') . "</td>";
                        echo "<td data-label='Procesador'>" . ($row["PROCESADOREQUIPO"] ? $row["PROCESADOREQUIPO"] : '-') . "</td>";
                        echo "<td data-label='Memoria'>" . ($row["MEMORIAEQUIPO"] ? $row["MEMORIAEQUIPO"] : '-') . "</td>";
                        echo "<td data-label='HDD'>" . ($row["HDDEQUIPO"] ? $row["HDDEQUIPO"] : '-') . "</td>";
                        echo "<td data-label='Fecha Compra'>" . ($row["FCOMPRAEQUIPO"] ? $row["FCOMPRAEQUIPO"] : '-') . "</td>";
                        echo "<td data-label='Status'>" . ($row["STATUSEQUIPO"] ? $row["STATUSEQUIPO"] : '-') . "</td>";
                        echo "<td data-label='IP'>" . ($row["IPEQUIPO"] ? $row["IPEQUIPO"] : '-') . "</td>";
                        echo "<td data-label='Ubicacion'>" . ($row["UBICACIONUSUARIO"] ? $row["UBICACIONUSUARIO"] : '-') . "</td>";
                        echo "<td data-label='Departamento'>" . ($row["DEPUSUARIO"] ? $row["DEPUSUARIO"] : '-') . "</td>";
                        echo "<td data-label='Usuario'>" . ($row["NOMBREUSUARIO"] ? $row["NOMBREUSUARIO"] : '-') . "</td>";
                        echo "<td data-label='Proveedor'>" . ($row["NOMBREPROVEEDOR"] ? $row["NOMBREPROVEEDOR"] : '-') . "</td>";
                        echo "<td data-label='Direccion Proveedor'>" . ($row["DIRECCIONPROVEEDOR"] ? $row["DIRECCIONPROVEEDOR"] : '-') . "</td>";
                        echo "<td data-label='Telefono Proveedor'>" . ($row["TELEFONOPROVEEDOR"] ? $row["TELEFONOPROVEEDOR"] : '-') . "</td>";
                        echo "<td data-label='Email Proveedor' style='overflow : auto;'>" . ($row["CONTACTOPROVEEDOR"] ? $row["CONTACTOPROVEEDOR"] : '-') . "</td>";
                        echo "<td data-label='Activo N°'>" . ($row["ACTIVOEQUIPO"] ? $row["ACTIVOEQUIPO"] : '-') . "</td>";
                        echo "<td data-label='Office'>" . ($row["OFFICEEQUIPO"] ? $row["OFFICEEQUIPO"] : '-') . "</td>";
                        echo "<td data-label='Costo'>" . ($row["COSTOEQUIPO"] ? $row["COSTOEQUIPO"] : '-') . "</td>";
                        echo "<td data-label='N° Factura'>" . ($row["FACTURAEQUIPO"] ? $row["FACTURAEQUIPO"] : '-') . "</td>";
                        echo "<td data-label='Nota'>" . ($row["NOTASEQUIPO"] ? $row["NOTASEQUIPO"] : '-') . "</td>";
                        echo "<td data-label='Ciudad'>" . ($row["CIUDADEQUIPO"] ? $row["CIUDADEQUIPO"] : '-') . "</td>";
                        echo "<td data-label='Nombre Equipo'>" . ($row["NOMBREEQUIPO"] ? $row["NOMBREEQUIPO"] : '-') . "</td>";
                        echo "</tr>";
                        $serialNumber++;
                    }
                } else {
                    echo "<tr><td colspan='30'>0 resultados encontrados</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div id="sinResultados" class="text-center" style="display: none;">Sin resultados encontrados</div>
        <?php
        $clientelocal = $idCliente;

        ?>
        <center>
            <a href="../CREATE/crearxCliente.php?idCliente=<?php echo $clientelocal; ?>" class="btn btn-primary btn-sm">Crear</a>
        </center>


    </div>

    <!-- Modal para mostrar detalles del equipo -->
    <div class="modal fade" id="vistaGeneralModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalles del Equipo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="vistaGeneralContent">
                    <!-- Contenido del modal se actualizará dinámicamente -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>