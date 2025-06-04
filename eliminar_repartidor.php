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
$idRepartidor = isset($_POST['id_repartidor']) ? intval($_POST['id_repartidor']) : 0;

// Validar parámetro obligatorio
if ($idRepartidor <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Falta el parámetro obligatorio: id_repartidor.'
    ]);
    exit;
}

// Preparar y ejecutar DELETE
$stmt = $conexion->prepare("DELETE FROM REPARTIDOR WHERE ID_REPARTIDOR = ?");
if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al preparar la consulta: ' . $conexion->error
    ]);
    exit;
}

$stmt->bind_param('i', $idRepartidor);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Repartidor eliminado correctamente.'
        ]);
    } else {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'No se encontró ningún repartidor con ese ID.'
        ]);
    }
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al eliminar repartidor: ' . $stmt->error
    ]);
}

$stmt->close();
$conexion->close();
