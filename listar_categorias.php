<?php
// Mostrar errores (solo para desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

$host     = 'localhost';
$user     = 'root';
$password = ''; // Cambiar si tienes contraseña
$dbname   = 'antojitos_bd';

try {
    $conexion = new mysqli($host, $user, $password, $dbname);

    if ($conexion->connect_errno) {
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

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Excepción capturada: ' . $e->getMessage()
    ]);
}
