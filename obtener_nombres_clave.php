<?php
// Definir los nombres clave asociados a cada cargo de usuario
$cargos = array(
    'TRGRTNRS' => 'Administrador',
    'BLTRCPLS' => 'Trabajador',
    'CMPRSGRS' => 'Cliente'
);

// Convertir el array a JSON y devolverlo
echo json_encode($cargos);
?>
