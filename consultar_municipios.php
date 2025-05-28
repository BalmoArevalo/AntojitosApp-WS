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

if (empty($id_departamento)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Falta el parámetro departamentoId']);
    exit;
}

$stmt = $conexion->prepare("SELECT ID_MUNICIPIO, NOMBRE_MUNICIPIO FROM MUNICIPIO WHERE ID_DEPARTAMENTO = ? ORDER BY NOMBRE_MUNICIPIO");
$stmt->bind_param('i', $id_departamento);
$stmt->execute();
$result = $stmt->get_result();

$municipios = [];
while ($row = $result->fetch_assoc()) {
    $municipios[] = $row;
}

echo json_encode($municipios);
$stmt->close();
$conexion->close();
?>