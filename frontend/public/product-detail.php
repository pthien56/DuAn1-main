<?php
require_once __DIR__ . '/../../bootstrap.php';

use App\Controllers\ProductController;

$controller = new ProductController();
$controller->detail();

