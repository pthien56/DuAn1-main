<?php
// Helper functions for frontend views

function baseUrl($path = '') {
    // Tự động detect base path từ thư mục hiện tại
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $base = str_replace('\\', '/', dirname($scriptName));
    
    // Adjust for frontend path
    if (strpos($base, '/frontend') !== false) {
        $base = str_replace('/frontend', '', $base);
    }
    
    // Nếu trong subdirectory, giữ lại
    if ($base !== '/' && $base !== '.') {
        $base = rtrim($base, '/');
    } else {
        $base = '';
    }
    
    // Nếu path đã bắt đầu bằng /, bỏ qua base
    if (strpos($path, '/') === 0) {
        return $base . $path;
    }
    
    return $base . ($path ? '/' . ltrim($path, '/') : '');
}

function assetUrl($path) {
    return baseUrl('assets/' . ltrim($path, '/'));
}

function formatCurrency($amount) {
    return number_format($amount, 0, ',', '.') . ' đ';
}

function formatDate($date) {
    if (empty($date)) return '';
    return date('d/m/Y', strtotime($date));
}

function formatDateTime($datetime) {
    if (empty($datetime)) return '';
    return date('d/m/Y H:i', strtotime($datetime));
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_role']) && 
           ($_SESSION['user_role'] == 'admin' || $_SESSION['user_role'] == 'manager');
}

function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

function getCartCount() {
    return isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
}

