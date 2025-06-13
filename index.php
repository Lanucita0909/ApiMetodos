<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_uri) {
    case '/quejas/listar':
        require_once 'quejas/listar.php';
        break;
    case '/quejas/registrar':
        require_once 'quejas/registrar.php';
        break;
    case '/quejas/grafico':
        require_once 'quejas/graficoC.php';
        break;
    case '/quejas/listarNombre':
        require_once 'quejas/listarNombre.php';
        break;
    default:
        echo json_encode(array("message" => "Ruta no encontrada"));
        break;
}
