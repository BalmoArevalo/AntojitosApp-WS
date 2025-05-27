<?php
// Configuración de la base de datos
$host     = 'localhost';
$user     = 'root';
$password = ''; // Asume que no hay contraseña para root, ajusta si es necesario
$dbname   = 'antojitos_bd';

// Crear conexión
$conexion = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conexion->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $conexion->connect_error]);
    exit;
}

// Establecer el charset para la conexión
$conexion->set_charset("utf8mb4");

// Configurar encabezado para respuesta JSON
header('Content-Type: application/json; charset=UTF-8');

// Función para calcular la disponibilidad (similar a la lógica de Android)
function calcularDisponibilidad($horaDesdeStr, $horaHastaStr) {
    if (empty($horaDesdeStr) || empty($horaHastaStr)) {
        return "No"; // O podrías retornar un error o estado desconocido
    }

    try {
        // Usar DateTime para facilitar las comparaciones y el manejo de zonas horarias si fuera necesario
        // Asegurarse que el servidor PHP tenga la zona horaria correcta configurada (date.timezone en php.ini)
        $ahora = new DateTime('now'); // Hora actual del servidor
        
        // Crear objetos DateTime para las horas de inicio y fin, usando la fecha actual
        $formatoHora = 'H:i'; // Asume formato HH:MM de la BD
        
        $inicio = DateTime::createFromFormat($formatoHora, $horaDesdeStr);
        $fin = DateTime::createFromFormat($formatoHora, $horaHastaStr);

        if (!$inicio || !$fin) { // Error al parsear las horas
            return "Error formato";
        }
        
        // Ajustar la fecha de los objetos de tiempo a hoy para una comparación correcta
        $inicio->setDate($ahora->format('Y'), $ahora->format('m'), $ahora->format('d'));
        $fin->setDate($ahora->format('Y'), $ahora->format('m'), $ahora->format('d'));

        if ($fin < $inicio) { // El rango cruza la medianoche (ej. 22:00 - 02:00)
            // Disponible si (ahora >= inicio HOY) O (ahora < fin HOY, que conceptualmente es día siguiente)
            if ($ahora >= $inicio || $ahora < $fin) {
                return "Si";
            }
        } else { // El rango es en el mismo día (ej. 09:00 - 17:00)
            if ($ahora >= $inicio && $ahora < $fin) {
                return "Si";
            }
        }
        return "No";

    } catch (Exception $e) {
        // Loggear el error $e->getMessage() si es necesario
        return "Error"; // Error en el cálculo
    }
}

// Preparar la consulta SQL para obtener las categorías de producto activas
// Solo seleccionamos las activas (ACTIVO_CATEGORIAPRODUCTO = 1)
$stmt = $conexion->prepare("
    SELECT 
        ID_CATEGORIAPRODUCTO, 
        NOMBRE_CATEGORIA, 
        DESCRIPCION_CATEGORIA,
        HORA_DISPONIBLE_DESDE,
        HORA_DISPONIBLE_HASTA
    FROM CATEGORIAPRODUCTO 
    WHERE ACTIVO_CATEGORIAPRODUCTO = 1
    ORDER BY ID_CATEGORIAPRODUCTO ASC
");

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conexion->error]);
    exit;
}

// Ejecutar la consulta
if ($stmt->execute()) {
    $resultado = $stmt->get_result();
    $categorias = [];

    while ($fila = $resultado->fetch_assoc()) {
        $disponibleAhora = calcularDisponibilidad($fila['HORA_DISPONIBLE_DESDE'], $fila['HORA_DISPONIBLE_HASTA']);
        
        $categorias[] = [
            'id_categoriaproducto' => $fila['ID_CATEGORIAPRODUCTO'],
            'nombre_categoria' => $fila['NOMBRE_CATEGORIA'],
            'descripcion_categoria' => $fila['DESCRIPCION_CATEGORIA'],
            'hora_disponible_desde' => $fila['HORA_DISPONIBLE_DESDE'],
            'hora_disponible_hasta' => $fila['HORA_DISPONIBLE_HASTA'],
            'disponible_ahora' => $disponibleAhora // Valor calculado
        ];
    }

    echo json_encode(['success' => true, 'categorias' => $categorias]);

} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta: ' . $stmt->error]);
}

// Cerrar la sentencia y la conexión
$stmt->close();
$conexion->close();
?>