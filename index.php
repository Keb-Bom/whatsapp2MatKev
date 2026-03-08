<?php

session_start();

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/MessageController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', trim($uri, '/'));

$method = $_SERVER['REQUEST_METHOD'];

$authController = new AuthController();
$messageController = new MessageController();


/*
--------------------------------
RUTAS DE AUTENTICACIÓN
--------------------------------
*/

if ($method === 'POST' && $uri[1] === 'register') {
    $authController->register();
    exit;
}

if ($method === 'POST' && $uri[1] === 'login') {
    $authController->login();
    exit;
}

if ($method === 'GET' && $uri[1] === 'profile') {
    $authController->profile();
    exit;
}


/*
--------------------------------
RUTAS DE MENSAJES
--------------------------------
*/

if ($method === 'POST' && $uri[1] === 'send') {
    $messageController->send();
    exit;
}

if ($method === 'GET' && $uri[1] === 'messages' && isset($uri[2])) {
    $messageController->getMessages($uri[2]);
    exit;
}

if ($method === 'GET' && $uri[1] === 'poll' && isset($uri[2])) {
    $messageController->poll($uri[2]);
    exit;
}


/*
--------------------------------
CHAT IA SIMULADO
--------------------------------
*/

if ($method === 'POST' && $uri[1] === 'ai-chat') {

    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->message)) {
        echo json_encode(["error" => "Mensaje vacío"]);
        exit;
    }

    $userMessage = strtolower($data->message);

    $response = "No entendí tu pregunta.";

    if (strpos($userMessage, "hola") !== false) {
        $response = "Hola, ¿en qué puedo ayudarte?";
    }

    if (strpos($userMessage, "hora") !== false) {
        $response = "La hora actual es: " . date("H:i:s");
    }

    if (strpos($userMessage, "fecha") !== false) {
        $response = "Hoy es: " . date("d-m-Y");
    }

    echo json_encode([
        "user_message" => $data->message,
        "ai_response" => $response
    ]);

    exit;
}


/*
--------------------------------
API FUNCIONANDO
--------------------------------
*/

echo json_encode([
    "message" => "API funcionando"
]);