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

$id_departamento = $_GET['departamentoId'] ?? '';
$id_municipio    = $_GET['municipioId'] ?? '';

if (empty($id_departamento) || empty($id_municipio)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Faltan parámetros departamentoId o municipioId']);
    exit;
}

$stmt = $conexion->prepare("SELECT ID_DISTRITO, NOMBRE_DISTRITO FROM DISTRITO WHERE ID_DEPARTAMENTO = ? AND ID_MUNICIPIO = ? ORDER BY NOMBRE_DISTRITO");
$stmt->bind_param('ii', $id_departamento, $id_municipio);
$stmt->execute();
$result = $stmt->get_result();

$distritos = [];
while ($row = $result->fetch_assoc()) {
    $distritos[] = $row;
}

echo json_encode($distritos);
$stmt->close();
$conexion->close();
?>