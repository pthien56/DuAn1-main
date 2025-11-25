<?php
require_once 'bootstrap.php';

use App\Controllers\CartController;

$controller = new CartController();
$controller->index();
