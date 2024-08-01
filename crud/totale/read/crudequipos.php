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
    <link rel="stylesheet" href="../../../style/style.css" />
    <script src="../../../scripts/botonmostrar.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="../../../scripts/adminread.js"></script>
    <link rel="icon" href="https://i.ibb.co/L16xwqN/icon-d.png">

    <style>
        /* Estilos para la tabla */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        /* Estilos para los botones de acción */
        .btn {
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
        }

        /* Otros estilos según sea necesario */
    </style>
    <style>
        /*----------------------------
      preloader area
  ----------------------------*/

        .loader_bg {
            position: fixed;
            z-index: 9999999;
            background: #fff;
            width: 100%;
            height: 100%;
        }

        .loader {
            height: 100%;
            width: 100%;
            position: absolute;
            left: 0;
            top: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loader img {
            width: 280px;
        }
    </style>
</head>

<body>
    <div class="loader_bg">
        <div class="loader"><img src="https://i.ibb.co/pPK56kK/DAPCOM-GIF-CARGANDO.gif" alt="#" /></div>
    </div>
    <a class="btn btn-primary" href="../../../d-sam/admin/equipos/seleccion">Volver</a>
    <h2>Lista de TODOS los equipos</h2>
    <center> <a href='../create/crear' class='btn btn-primary btn-sm'>Crear Equipo</a> </center>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>

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
                include '../../../php/connection.php';
                // Verificar la conexión
                if ($conn->connect_error) {
                    die("Error de conexión: " . $conn->connect_error);
                }

                // Consulta SQL para obtener todos los datos de EQUIPO con el nombre del cliente
                $sql = "SELECT equipo.*, cliente.NOMBRECLIENTE
                    FROM equipo
                    INNER JOIN cliente ON equipo.IDCLIENTE = cliente.IDCLIENTE";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $serialNumber = 1;

                    while ($row = $result->fetch_assoc()) {
                        if ($row['STATUSEQUIPO'] == 'BAJA') {
                            echo "<tr style='background-color: #3b3b415c;'>";
                        } else {
                            echo "<tr>";
                        }

                        echo "<td data-label='Acciones'><br>";
                        echo "<div class='Acciones'>";
                        echo "<a href='../perifericos/read/index?id_equipo=" . $row['ID'] . "&id_cliente=" . $row['IDCLIENTE']  . "' class='btn btn-primary btn-sm'> Perifericos </a>";
                        echo "<br><br>";
                        echo "<a href='../incidente/read/index?id_equipo=" . $row['ID'] . "&id_cliente=" . $row['IDCLIENTE'] . "' class='btn btn-primary btn-sm'> Incidentes </a>";
                        echo "</div>";
                        echo "</td>";
                        // Agregar botones en la última celda
                        echo "<center><td data-label='Administrativo'></center>";
                        echo "<div class='BtnEditar'> ";
                        echo "<a href='../update/crudequipoeditar?id_equipo=" . $row['ID'] . "' class='btn btn-primary btn-sm'>Editar</a>";
                        echo "</div>";
                        echo "<div class='BtnEliminar'> ";
                        echo "<a href='../delete/crudequiposeliminar?id=" . $row['ID'] . "' class='btn btn-danger btn-smElim'>Eliminar</a>";
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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script>
    <link href="https://nightly.datatables.net/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Registros",
                    "infoFiltered": "(Filtrado de _MAX_ total Registros)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Registros",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
            });
        });
    </script>
    <script>
        window.addEventListener('load', function() {
            // Ocultar el loader
            var loaderBg = document.querySelector('.loader_bg');
            loaderBg.style.display = 'none';
        });
    </script>
</body>

</html>