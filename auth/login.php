<?php
require_once '../bootstrap.php';

use App\Controllers\AuthController;

$controller = new AuthController();
$controller->login();
