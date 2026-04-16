<?php
$conexion = new mysqli("localhost", "root", "", "gestion_biblioteca");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>