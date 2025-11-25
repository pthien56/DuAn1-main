<?php
require_once __DIR__ . '/../../bootstrap.php';

use App\Controllers\HomeController;

$controller = new HomeController();
$controller->index();

