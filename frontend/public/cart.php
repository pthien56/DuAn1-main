<?php
require_once __DIR__ . '/../../bootstrap.php';

use App\Controllers\CartController;

$controller = new CartController();
$controller->index();

