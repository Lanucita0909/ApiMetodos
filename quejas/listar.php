<?php
// Permitir acceso desde cualquier origen (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Incluir conexión
include_once(__DIR__ . '/../config/database.php');

// Crear conexión
$database = new Database();
$db = $database->getConnection();

// Consulta para obtener todas las quejas
$query = "SELECT id, atendido_por, descripcion, categoria, puntuacion, fecha_evento, fecha_registro, costo_viaje FROM quejas_taxi ORDER BY fecha_registro DESC";

$stmt = $db->prepare($query);
$stmt->execute();

// Contar filas
$num = $stmt->rowCount();

if ($num > 0) {
    $quejas_arr = [];
    $quejas_arr["records"] = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $queja_item = [
            "id" => $id,
            "atendido_por" => $atendido_por,
            "descripcion" => $descripcion,
            "categoria" => $categoria,
            "puntuacion" => $puntuacion,
            "fecha_evento" => $fecha_evento,
            "fecha_registro" => $fecha_registro,
            "costo_viaje" => $costo_viaje
        ];

        array_push($quejas_arr["records"], $queja_item);
    }

    // Respuesta 200 OK
    http_response_code(200);
    echo json_encode($quejas_arr);

} else {
    // No hay registros
    http_response_code(404);
    echo json_encode(["message" => "No se encontraron quejas."]);
}
?>
