<?php
require_once 'bootstrap.php';

use App\Controllers\HomeController;

$controller = new HomeController();
$controller->index();
