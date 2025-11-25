<?php
require_once 'bootstrap.php';

use App\Controllers\OrderController;

$controller = new OrderController();
$controller->checkout();
