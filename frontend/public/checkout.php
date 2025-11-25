<?php
require_once __DIR__ . '/../../bootstrap.php';

use App\Controllers\OrderController;

$controller = new OrderController();
$controller->checkout();

