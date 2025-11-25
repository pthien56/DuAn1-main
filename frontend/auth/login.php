<?php
require_once __DIR__ . '/../../backend/bootstrap.php';

use App\Controllers\AuthController;

$controller = new AuthController();
$controller->login();

