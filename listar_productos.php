<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'antojitos_bd';

$conexion = new mysqli($host, $user, $password, $dbname);
if ($conexion->connect_error) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error de conexión: ' . $conexion->connect_error
    ]);
    exit;
}

$sql = "SELECT ID_CATEGORIAPRODUCTO AS id, NOMBRE_CATEGORIA AS nombre
        FROM CATEGORIAPRODUCTO
        WHERE ACTIVO_CATEGORIAPRODUCTO = 1";

$resultado = $conexion->query($sql);

$categorias = [];
while ($fila = $resultado->fetch_assoc()) {
    $categorias[] = $fila;
}

echo json_encode($categorias);
$conexion->close();
