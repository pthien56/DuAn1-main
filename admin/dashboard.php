<?php
require_once '../bootstrap.php';

use App\Controllers\AdminController;

$controller = new AdminController();
$controller->dashboard();
