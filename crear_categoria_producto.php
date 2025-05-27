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

$conexion->set_charset("utf8mb4");

header('Content-Type: application/json; charset=UTF-8');

$nombreCategoria        = $_POST['nombreCategoria'] ?? '';
$descripcionCategoria   = $_POST['descripcionCategoria'] ?? '';
$disponibleCategoria    = isset($_POST['disponibleCategoria']) ? intval($_POST['disponibleCategoria']) : null; // Será 0 o 1
$horaDesde              = $_POST['horaDesde'] ?? '';
$horaHasta              = $_POST['horaHasta'] ?? '';
$activoCategoria        = isset($_POST['activoCategoriaProducto']) ? intval($_POST['activoCategoriaProducto']) : 1; // Valor por defecto 1 (activo)

if (empty($nombreCategoria) || empty($descripcionCategoria) || $disponibleCategoria === null || empty($horaDesde) || empty($horaHasta)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Faltan parámetros requeridos. Asegúrate de enviar nombreCategoria, descripcionCategoria, disponibleCategoria, horaDesde y horaHasta.']);
    exit;
}

if ($disponibleCategoria !== 0 && $disponibleCategoria !== 1) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'El parámetro disponibleCategoria debe ser 0 o 1.']);
    exit;
}

$stmt = $conexion->prepare("
    INSERT INTO CATEGORIAPRODUCTO (
        NOMBRE_CATEGORIA, 
        DESCRIPCION_CATEGORIA, 
        DISPONIBLE_CATEGORIA, 
        HORA_DISPONIBLE_DESDE, 
        HORA_DISPONIBLE_HASTA, 
        ACTIVO_CATEGORIAPRODUCTO
    ) VALUES (?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conexion->error]);
    exit;
}

$stmt->bind_param('ssissi', 
    $nombreCategoria, 
    $descripcionCategoria, 
    $disponibleCategoria, 
    $horaDesde, 
    $horaHasta, 
    $activoCategoria
);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Categoría de producto creada correctamente.',
        'id_categoriaproducto' => $stmt->insert_id
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al crear la categoría de producto: ' . $stmt->error]);
}

$stmt->close();
$conexion->close();
?>