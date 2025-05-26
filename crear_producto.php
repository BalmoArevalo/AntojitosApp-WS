<?php
$host     = 'localhost';
$user     = 'root';
$password = '';
$dbname   = 'antojitos_bd';

$conexion = new mysqli($host, $user, $password, $dbname);
if ($conexion->connect_error) {
    header('Content-Type: application/json; charset=UTF-8');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error de conexión: ' . $conexion->connect_error
    ]);
    exit;
}

header('Content-Type: application/json; charset=UTF-8');

// Leer parámetros POST
$idCategoria = isset($_POST['id_categoria']) ? intval($_POST['id_categoria']) : 0;
$nombre      = isset($_POST['nombre'])       ? trim($_POST['nombre'])         : '';
$descripcion = isset($_POST['descripcion'])  ? trim($_POST['descripcion'])    : '';
$activo      = isset($_POST['activo'])       ? intval($_POST['activo'])       : 1;

// Validación de campos obligatorios
if ($idCategoria <= 0 || $nombre === '') {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Faltan parámetros obligatorios: id_categoria y nombre.'
    ]);
    exit;
}

// Preparar y ejecutar INSERT
$stmt = $conexion->prepare("
    INSERT INTO PRODUCTO (ID_CATEGORIAPRODUCTO, NOMBRE_PRODUCTO, DESCRIPCION_PRODUCTO, ACTIVO_PRODUCTO)
    VALUES (?, ?, ?, ?)
");

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al preparar la consulta: ' . $conexion->error
    ]);
    exit;
}

$stmt->bind_param('issi', $idCategoria, $nombre, $descripcion, $activo);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Producto creado correctamente.',
        'id_producto' => $stmt->insert_id
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al insertar producto: ' . $stmt->error
    ]);
}

$stmt->close();
$conexion->close();

