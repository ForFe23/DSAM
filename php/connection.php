<?php
$servername = "45.177.125.12";
$username = "dapcompu_dsam";
$password = "Quito_2024";
$dbname = "dapcompu_dsam";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Puedes comentar o eliminar la siguiente línea si no necesitas imprimir un mensaje de conexión exitosa


// Realizar operaciones en la base de datos aquí...


?>