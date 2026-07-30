<?php

use App\Controllers\UserController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$userController = new UserController();

// POST /users
if ($uri === '/users' && $method === 'POST') {
    $userController->create();
    exit;
}

// GET /users
if ($uri === '/users' && $method === 'GET') {
    $userController->findAll();
    exit;
}

// GET /users/{id}
if (preg_match('#^/users/(\d+)$#', $uri, $matches) && $method === 'GET') {
    $userController->findById((int) $matches[1]);
    exit;
}

// PATCH /users/{id}/inactivate
if (preg_match('#^/users/(\d+)/inactivate$#', $uri, $matches) && $method === 'PATCH') {
    $userController->inactivate((int) $matches[1]);
    exit;
}

// 404 Route Not Found
http_response_code(404);
echo json_encode(['error' => 'Rota não encontrada.']);
