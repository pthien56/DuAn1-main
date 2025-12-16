<?php
// Cấu hình chung
// Tự động xác định BASE_URL dựa trên host và đường dẫn tới file index.php
$protocol = 'http://';
if ((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === '1')) || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) {
    $protocol = 'https://';
}
$baseUrl = $protocol . ($_SERVER['HTTP_HOST'] ?? 'localhost') . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
define('BASE_URL', $baseUrl);
define('SITE_NAME', 'Cửa Hàng Điện Thoại');

// Cấu hình session
ini_set('session.cookie_httponly', 1);
session_start();

// Timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Autoload classes
spl_autoload_register(function ($class) {
    $baseDir = dirname(__DIR__) . '/';
    $paths = [
        $baseDir . 'models/' . $class . '.php',
        $baseDir . 'controllers/' . $class . '.php',
        $baseDir . 'config/' . $class . '.php'
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});
?>

