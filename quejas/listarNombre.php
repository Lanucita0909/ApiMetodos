<?php
// Permitir acceso desde cualquier origen (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Incluir conexión
include_once(__DIR__ . '/../config/database.php');

// Crear conexión
$database = new Database();
$db = $database->getConnection();

// Validar que se reciba el nombre por GET
if (!isset($_GET['nombre'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Falta el parámetro 'nombre'"]);
    exit;
}

$nombre = $_GET['nombre'];

// Consulta preparada
$query = "SELECT id, atendido_por, descripcion, categoria, puntuacion, fecha_evento, costo_viaje
          FROM quejas_taxi
          WHERE atendido_por = ?
          ORDER BY fecha_evento DESC";

$stmt = $db->prepare($query);
$stmt->execute([$nombre]);

$num = $stmt->rowCount();

if ($num > 0) {
    $detalles_arr = [];
    $detalles_arr["records"] = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $detalle = [
            "id" => $id,
            "descripcion" => "El día $fecha_evento, se registró una queja contra el conductor **$atendido_por** por la razón: *$categoria*. La descripción indica: \"$descripcion\". Puntuación: **$puntuacion**. Costo del viaje: **₡" . number_format($costo_viaje, 2) . "**."
        ];

        array_push($detalles_arr["records"], $detalle);
    }

    http_response_code(200);
    echo json_encode($detalles_arr);
} else {
    http_response_code(404);
    echo json_encode(["message" => "No se encontraron quejas para el conductor."]);
}
