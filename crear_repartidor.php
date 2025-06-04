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
$idDepartamento = isset($_POST['id_departamento']) ? intval($_POST['id_departamento']) : 0;
$idMunicipio    = isset($_POST['id_municipio'])    ? intval($_POST['id_municipio'])    : 0;
$idDistrito     = isset($_POST['id_distrito'])     ? intval($_POST['id_distrito'])     : 0;
$nombre         = isset($_POST['nombre'])          ? trim($_POST['nombre'])            : '';
$apellido       = isset($_POST['apellido'])        ? trim($_POST['apellido'])          : '';
$telefono       = isset($_POST['telefono'])        ? trim($_POST['telefono'])          : '';
$tipoVehiculo   = isset($_POST['tipo_vehiculo'])   ? trim($_POST['tipo_vehiculo'])     : '';
$disponible     = isset($_POST['disponible'])      ? intval($_POST['disponible'])      : 0;
$activo         = isset($_POST['activo'])          ? intval($_POST['activo'])          : 1;

// Validación
if ($nombre === '' || $apellido === '' || $telefono === '' || $tipoVehiculo === '' ||
    $idDepartamento <= 0 || $idMunicipio <= 0 || $idDistrito <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Faltan parámetros obligatorios.'
    ]);
    exit;
}

// Preparar y ejecutar INSERT
$stmt = $conexion->prepare("
    INSERT INTO REPARTIDOR (
        ID_DEPARTAMENTO, ID_MUNICIPIO, ID_DISTRITO,
        TIPO_VEHICULO, DISPONIBLE, TELEFONO_REPARTIDOR,
        NOMBRE_REPARTIDOR, APELLIDO_REPARTIDOR, ACTIVO_REPARTIDOR
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al preparar la consulta: ' . $conexion->error
    ]);
    exit;
}

$stmt->bind_param(
    'iiisssssi',
    $idDepartamento, $idMunicipio, $idDistrito,
    $tipoVehiculo, $disponible, $telefono,
    $nombre, $apellido, $activo
);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Repartidor creado correctamente.',
        'id_repartidor' => $stmt->insert_id
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al insertar repartidor: ' . $stmt->error
    ]);
}

$stmt->close();
$conexion->close();
