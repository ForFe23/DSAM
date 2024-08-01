
$(document).ready(function(){
    $("#filtroEquipo").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        var $tableRows = $("table tbody tr");

        $tableRows.filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });

        // Verificar si hay filas visibles después del filtrado
        var $visibleRows = $tableRows.filter(":visible");
        if ($visibleRows.length === 0) {
            // No hay resultados, mostrar mensaje
            $("#sinResultados").show();
        } else {
            // Hay resultados, ocultar mensaje
            $("#sinResultados").hide();
        }
    });
});
