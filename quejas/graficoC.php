<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once(__DIR__ . '/../config/database.php');

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->fecha_inicio) && !empty($data->fecha_fin)) {

    $query = "SELECT fecha_evento, COUNT(*) as cantidad
              FROM quejas_taxi
              WHERE fecha_evento BETWEEN :inicio AND :fin
              GROUP BY fecha_evento
              ORDER BY fecha_evento ASC";

    $stmt = $db->prepare($query);

    $fecha_inicio = htmlspecialchars(strip_tags($data->fecha_inicio));
    $fecha_fin = htmlspecialchars(strip_tags($data->fecha_fin));

    $stmt->bindParam(":inicio", $fecha_inicio);
    $stmt->bindParam(":fin", $fecha_fin);

    if ($stmt->execute()) {
        $quejas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($quejas) > 0) {
            $quejas_por_dia = array_map(function($q) {
                return (int)$q['cantidad'];
            }, $quejas);

            http_response_code(200);
            echo json_encode(["quejas_por_dia" => $quejas_por_dia]);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No hay quejas en ese rango de fechas."]);
        }
    } else {
        http_response_code(503);
        echo json_encode(["message" => "Error al obtener los datos."]);
    }

} else {
    http_response_code(400);
    echo json_encode(["message" => "Faltan fechas requeridas."]);
}
?>
