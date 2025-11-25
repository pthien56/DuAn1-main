<?php
namespace App\Controllers;

class BaseController {
    protected function view($view, $data = []) {
        extract($data);
        
        // Hỗ trợ cả định dạng 'home/index' và 'home_index'
        $viewPath = str_replace('_', '/', $view);
        
        // Tìm view trong frontend/Views
        $viewFile = __DIR__ . "/../Views/{$viewPath}.php";
        
        if (!file_exists($viewFile)) {
            // Thử tìm với định dạng gốc
            $viewFile = __DIR__ . "/../Views/{$view}.php";
        }
        
        if (!file_exists($viewFile)) {
            die("View not found: {$view} (tried: {$viewPath}.php and {$view}.php)");
        }
        
        require_once $viewFile;
    }
    
    protected function redirect($url) {
        // Nếu URL không bắt đầu bằng http, thêm base path
        if (strpos($url, 'http') !== 0 && strpos($url, '/') !== 0) {
            require_once __DIR__ . '/../Views/helpers.php';
            $url = baseUrl($url);
        } elseif (strpos($url, '/') === 0 && strpos($url, 'http') !== 0) {
            require_once __DIR__ . '/../Views/helpers.php';
            $base = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
            // Adjust for frontend path
            if (strpos($base, '/frontend') !== false) {
                $base = str_replace('/frontend', '', $base);
            }
            if ($base !== '/' && $base !== '.') {
                $url = rtrim($base, '/') . $url;
            }
        }
        header("Location: $url");
        exit();
    }
    
    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
    
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    protected function isAdmin() {
        return isset($_SESSION['user_role']) && 
               ($_SESSION['user_role'] == 'admin' || $_SESSION['user_role'] == 'manager');
    }
    
    protected function requireAuth() {
        if (!$this->isLoggedIn()) {
            require_once __DIR__ . '/../Views/helpers.php';
            $this->redirect('auth/login.php');
        }
    }
    
    protected function requireAdmin() {
        if (!$this->isAdmin()) {
            require_once __DIR__ . '/../Views/helpers.php';
            $this->redirect('auth/login.php');
        }
    }
    
    protected function requireCustomer() {
        if (!$this->isLoggedIn() || ($_SESSION['user_type'] ?? '') != 'customer') {
            require_once __DIR__ . '/../Views/helpers.php';
            $this->redirect('auth/login.php');
        }
    }
    
    protected function sanitize($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

