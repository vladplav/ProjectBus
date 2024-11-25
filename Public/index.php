<?php
echo "Server is working!";
exit;

<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\BusController;

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$busController = new BusController();

if ($method == 'GET' && preg_match('/^\/api\/find-bus/', $uri)) {
    $params = $_GET;
    $busController->findBus($params['from'], $params['to']);
} elseif ($method == 'POST' && preg_match('/^\/api\/edit-route/', $uri)) {
    $data = json_decode(file_get_contents('php://input'), true);
    $busController->editRoute($data['routeId'], $data['newStops']);
}
