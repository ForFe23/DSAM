
    function mostrarVistaGeneral(button) {
        // Recupera los datos del botón
        var id = button.getAttribute('data-id');
        var serie = button.getAttribute('data-serie');
        var cliente = button.getAttribute('data-cliente');
        var marca = button.getAttribute('data-marca');
        var modelo = button.getAttribute('data-modelo');
        var tipo = button.getAttribute('data-tipo');
        var so = button.getAttribute('data-so');
        var procesador = button.getAttribute('data-procesador');
        var memoria = button.getAttribute('data-memoria');
        var hdd = button.getAttribute('data-hdd');
        var fechaCompra = button.getAttribute('data-fecha-compra');
        var status = button.getAttribute('data-status');
        var ip = button.getAttribute('data-ip');
        var ubicacion = button.getAttribute('data-ubicacion');
        var departamento = button.getAttribute('data-departamento');
        var usuario = button.getAttribute('data-usuario');
        var proveedor = button.getAttribute('data-proveedor');
        var direccionProveedor = button.getAttribute('data-direccion-proveedor');
        var telefonoProveedor = button.getAttribute('data-telefono-proveedor');
        var emailProveedor = button.getAttribute('data-email-proveedor');
        var activoNumero = button.getAttribute('data-activo-numero');
        var office = button.getAttribute('data-office');
        var costo = button.getAttribute('data-costo');
        var numeroFactura = button.getAttribute('data-numero-factura');
        var nota = button.getAttribute('data-nota');
        var ciudad = button.getAttribute('data-ciudad');
        var nombreEquipo = button.getAttribute('data-nombre-equipo');

        // Formatea los datos con estilos alineados a la derecha
        var detallesEquipo = `
            <p><strong>ID del Equipo:</strong> <span style="float: right;">${id}</span></p>
            <p><strong>Serie Equipo:</strong> <span style="float: right;">${serie}</span></p>
            <p><strong>ID Cliente:</strong> <span style="float: right;">${cliente}</span></p>
            <p><strong>Marca Equipo:</strong> <span style="float: right;">${marca}</span></p>
            <p><strong>Modelo Equipo:</strong> <span style="float: right;">${modelo}</span></p>
            <p><strong>Tipo:</strong> <span style="float: right;">${tipo}</span></p>
            <p><strong>Sistema Operativo:</strong> <span style="float: right;">${so}</span></p>
            <p><strong>Procesador:</strong> <span style="float: right;">${procesador}</span></p>
            <p><strong>Memoria:</strong> <span style="float: right;">${memoria}</span></p>
            <p><strong>HDD:</strong> <span style="float: right;">${hdd}</span></p>
            <p><strong>Fecha de Compra:</strong> <span style="float: right;">${fechaCompra}</span></p>
            <p><strong>Status:</strong> <span style="float: right;">${status}</span></p>
            <p><strong>IP:</strong> <span style="float: right;">${ip}</span></p>
            <p><strong>Ubicación:</strong> <span style="float: right;">${ubicacion}</span></p>
            <p><strong>Departamento:</strong> <span style="float: right;">${departamento}</span></p>
            <p><strong>Usuario:</strong> <span style="float: right;">${usuario}</span></p>
            <p><strong>Proveedor:</strong> <span style="float: right;">${proveedor}</span></p>
            <p><strong>Dirección Proveedor:</strong> <span style="float: right;">${direccionProveedor}</span></p>
            <p><strong>Teléfono Proveedor:</strong> <span style="float: right;">${telefonoProveedor}</span></p>
            <p><strong>Email Proveedor:</strong> <span style="float: right;">${emailProveedor}</span></p>
            <p><strong>Activo Número:</strong> <span style="float: right;">${activoNumero}</span></p>
            <p><strong>Office:</strong> <span style="float: right;">${office}</span></p>
            <p><strong>Costo:</strong> <span style="float: right;">${costo}</span></p>
            <p><strong>Número de Factura:</strong> <span style="float: right;">${numeroFactura}</span></p>
            <p><strong>Nota:</strong> <span style="float: right;">${nota}</span></p>
            <p><strong>Ciudad:</strong> <span style="float: right;">${ciudad}</span></p>
            <p><strong>Nombre del Equipo:</strong> <span style="float: right;">${nombreEquipo}</span></p>
            <!-- Agrega más campos según tus necesidades -->
        `;

        // Actualiza el contenido del modal
        document.getElementById('vistaGeneralContent').innerHTML = detallesEquipo;

        // Muestra el modal
        $('#vistaGeneralModal').modal('show');
    }
