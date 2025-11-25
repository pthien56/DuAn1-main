<?php
require_once 'database.php';

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check if user is admin/manager
function isAdmin() {
    return isset($_SESSION['user_role']) && ($_SESSION['user_role'] == 'admin' || $_SESSION['user_role'] == 'manager');
}

// Get current user ID
function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

// Format currency
function formatCurrency($amount) {
    return number_format($amount, 0, ',', '.') . ' đ';
}

// Format date
function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}

// Format datetime
function formatDateTime($datetime) {
    return date('d/m/Y H:i', strtotime($datetime));
}

// Sanitize input
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Redirect
function redirect($url) {
    header("Location: $url");
    exit();
}
?>

