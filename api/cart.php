<?php
require_once __DIR__ . '/../bootstrap.php';

use App\Controllers\CartController;

$controller = new CartController();

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        $controller->add();
        break;
    case 'update':
        $controller->update();
        break;
    case 'remove':
        $controller->remove();
        break;
    case 'get':
        $controller->get();
        break;
    default:
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Hành động không hợp lệ']);
        break;
}