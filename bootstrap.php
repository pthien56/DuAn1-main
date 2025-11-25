<?php
// Bootstrap file - Load all necessary files

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define constants
// Thử các port phổ biến: 3306 (mặc định), 3307, 3308
define('DB_HOST', 'localhost:3306'); // Nếu không được, thử 'localhost:3307' hoặc '127.0.0.1:3306'
define('DB_USER', 'root');
define('DB_PASS', ''); // Nếu MySQL có mật khẩu, điền vào đây
define('DB_NAME', 'inventory_system');

// Autoload classes
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

