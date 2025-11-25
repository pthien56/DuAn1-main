<?php
require_once 'bootstrap.php';

use App\Controllers\ProductController;

$controller = new ProductController();

if (isset($_GET['id'])) {
    $controller->detail();
} else {
    $controller->index();
}
