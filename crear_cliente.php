<?php
$host     = 'localhost';
$user     = 'root';
$password = '';
$dbname   = 'antojitos_bd';

$conexion = new mysqli($host, $user, $password, $dbname);
if ($conexion->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $conexion->connect_error]);
    exit;
}

header('Content-Type: application/json; charset=UTF-8');

// Parametros
$telefono = $_POST['telefonoCliente'] ?? '';
$nombre = $_POST['nombreCliente'] ?? '';
$apellido = $_POST['apellidoCliente'] ?? '';
$activo = isset($_POST['activoCliente']) ? intval($_POST['activoCliente']) : 1;

if (empty($telefono) || empty($nombre) || empty($apellido)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Faltan parámetros requeridos']);
    exit;
}

$stmt = $conexion->prepare("
    INSERT INTO CLIENTE (TELEFONO_CLIENTE, NOMBRE_CLIENTE, APELLIDO_CLIENTE, ACTIVO_CLIENTE)
    VALUES (?, ?, ?, ?)
");

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error en prepare: ' . $conexion->error]);
    exit;
}

$stmt->bind_param('sssi', $telefono, $nombre, $apellido, $activo);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Cliente creado correctamente.',
        'id_cliente' => $stmt->insert_id
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al insertar: ' . $stmt->error]);
}

$stmt->close();
$conexion->close();
