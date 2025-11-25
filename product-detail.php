<?php
require_once 'bootstrap.php';

use App\Controllers\ProductController;

$controller = new ProductController();
$controller->detail();
