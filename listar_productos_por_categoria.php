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

// Validar parámetro POST
$idCategoria = isset($_POST['id_categoria']) ? intval($_POST['id_categoria']) : 0;
if ($idCategoria <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Parámetro id_categoria no válido.'
    ]);
    exit;
}

$sql = "SELECT ID_PRODUCTO AS id, NOMBRE_PRODUCTO AS nombre, DESCRIPCION_PRODUCTO AS descripcion, ACTIVO_PRODUCTO AS activo
        FROM PRODUCTO
        WHERE ID_CATEGORIAPRODUCTO = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idCategoria);
$stmt->execute();
$resultado = $stmt->get_result();

$productos = [];
while ($fila = $resultado->fetch_assoc()) {
    $productos[] = $fila;
}

echo json_encode($productos);
$stmt->close();
$conexion->close();
