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

// Consulta de sucursales activas, incluyendo info de departamento, municipio y distrito
$query = "
    SELECT 
        S.ID_SUCURSAL,
        S.NOMBRE_SUCURSAL,
        S.DIRECCION_SUCURSAL,
        S.TELEFONO_SUCURSAL,
        S.HORARIO_APERTURA_SUCURSAL,
        S.HORARIO_CIERRE_SUCURSAL,
        S.ACTIVO_SUCURSAL,
        S.ID_DEPARTAMENTO,
        S.ID_MUNICIPIO,
        S.ID_DISTRITO,
        DPT.NOMBRE_DEPARTAMENTO,
        MUN.NOMBRE_MUNICIPIO,
        DIS.NOMBRE_DISTRITO
    FROM SUCURSAL S
    INNER JOIN DEPARTAMENTO DPT ON S.ID_DEPARTAMENTO = DPT.ID_DEPARTAMENTO
    INNER JOIN MUNICIPIO MUN ON S.ID_DEPARTAMENTO = MUN.ID_DEPARTAMENTO AND S.ID_MUNICIPIO = MUN.ID_MUNICIPIO
    INNER JOIN DISTRITO DIS ON S.ID_DEPARTAMENTO = DIS.ID_DEPARTAMENTO AND S.ID_MUNICIPIO = DIS.ID_MUNICIPIO AND S.ID_DISTRITO = DIS.ID_DISTRITO
    WHERE S.ACTIVO_SUCURSAL = 1
";

$result = $conexion->query($query);

$sucursales = [];
while ($row = $result->fetch_assoc()) {
    $sucursales[] = $row;
}

echo json_encode($sucursales);
$conexion->close();
?>