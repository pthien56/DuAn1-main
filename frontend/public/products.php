<?php
require_once __DIR__ . '/../../bootstrap.php';

use App\Controllers\ProductController;

$controller = new ProductController();

if (isset($_GET['id'])) {
    $controller->detail();
} else {
    $controller->index();
}

