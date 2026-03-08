<?php

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($request === '/register' && $method === 'POST') {
    require_once __DIR__ . "/../controllers/AuthController.php";
    $controller = new AuthController();
    $controller->register();
    exit;
}

if ($request === '/login' && $method === 'POST') {
    require_once __DIR__ . "/../controllers/AuthController.php";
    $controller = new AuthController();
    $controller->login();
    exit;
}

echo json_encode(["message" => "API funcionando"]);