<?php
// Helper functions for backend

require_once __DIR__ . '/database.php';

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
    if (empty($date)) return '';
    return date('d/m/Y', strtotime($date));
}

// Format datetime
function formatDateTime($datetime) {
    if (empty($datetime)) return '';
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

// Base URL helper
function baseUrl($path = '') {
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $base = str_replace('\\', '/', dirname($scriptName));
    
    // Adjust for backend path
    if (strpos($base, '/backend') !== false) {
        $base = str_replace('/backend', '', $base);
    }
    
    if ($base !== '/' && $base !== '.') {
        $base = rtrim($base, '/');
    } else {
        $base = '';
    }
    
    if (strpos($path, '/') === 0) {
        return $base . $path;
    }
    
    return $base . ($path ? '/' . ltrim($path, '/') : '');
}

