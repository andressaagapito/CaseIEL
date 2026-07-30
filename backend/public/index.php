<?php

header('Content-Type: application/json');

// Autoload do Composer (será gerado após composer install)
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

echo json_encode([
    'status' => 'success',
    'message' => 'API do Case IEL está rodando!'
]);
