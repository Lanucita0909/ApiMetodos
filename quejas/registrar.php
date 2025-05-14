<?php
// Configuración CORS completa - añade estos encabezados
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Max-Age: 3600");

// Responder a las solicitudes preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->atendido_por) &&
    !empty($data->descripcion) &&
    !empty($data->categoria) &&
    !empty($data->puntuacion) &&
    !empty($data->fecha_evento)
) {
    $query = "INSERT INTO quejas_taxi (atendido_por, descripcion, categoria, puntuacion, fecha_evento) 
              VALUES (:atendido_por, :descripcion, :categoria, :puntuacion, :fecha_evento)";

    $stmt = $db->prepare($query);

    $atendido_por = htmlspecialchars(strip_tags($data->atendido_por));
    $descripcion = htmlspecialchars(strip_tags($data->descripcion));
    $categoria = htmlspecialchars(strip_tags($data->categoria));
    $puntuacion = intval($data->puntuacion);
    $fecha_evento = htmlspecialchars(strip_tags($data->fecha_evento));

    $stmt->bindParam(":atendido_por", $atendido_por);
    $stmt->bindParam(":descripcion", $descripcion);
    $stmt->bindParam(":categoria", $categoria);
    $stmt->bindParam(":puntuacion", $puntuacion);
    $stmt->bindParam(":fecha_evento", $fecha_evento);

    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(["message" => "Queja registrada exitosamente."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "No se pudo registrar la queja."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Faltan datos requeridos."]);
}
?>