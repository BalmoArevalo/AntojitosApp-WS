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

// Parámetros esperados
$nombre      = $_POST['nombreSucursal']     ?? '';
$direccion   = $_POST['direccionSucursal']  ?? '';
$telefono    = $_POST['telefonoSucursal']   ?? '';
$horario_ap  = $_POST['horarioApertura']    ?? '';
$horario_cie = $_POST['horarioCierre']      ?? '';
$id_departamento = $_POST['departamentoId'] ?? '';
$id_municipio    = $_POST['municipioId']    ?? '';
$id_distrito     = $_POST['distritoId']     ?? '';
$activo      = isset($_POST['activoSucursal']) ? intval($_POST['activoSucursal']) : 1;

// Validación básica
if (
    empty($nombre) || empty($direccion) || empty($telefono) ||
    empty($horario_ap) || empty($horario_cie) ||
    empty($id_departamento) || empty($id_municipio) || empty($id_distrito)
) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Faltan parámetros requeridos']);
    exit;
}

$stmt = $conexion->prepare("
    INSERT INTO SUCURSAL (
        ID_DEPARTAMENTO,
        ID_MUNICIPIO,
        ID_DISTRITO,
        NOMBRE_SUCURSAL,
        DIRECCION_SUCURSAL,
        TELEFONO_SUCURSAL,
        HORARIO_APERTURA_SUCURSAL,
        HORARIO_CIERRE_SUCURSAL,
        ACTIVO_SUCURSAL
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error en prepare: ' . $conexion->error]);
    exit;
}

$stmt->bind_param(
    'iiisssssi', 
    $id_departamento, $id_municipio, $id_distrito,
    $nombre, $direccion, $telefono, $horario_ap, $horario_cie, $activo
);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Sucursal creada correctamente.',
        'id_sucursal' => $stmt->insert_id
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al insertar: ' . $stmt->error]);
}

$stmt->close();
$conexion->close();
?>