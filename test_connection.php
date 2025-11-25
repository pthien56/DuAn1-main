<?php
// Test database connection
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Test Database Connection</h2>";

// Test 1: Check constants
echo "<h3>1. Kiểm tra constants:</h3>";
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'inventory_system');

echo "DB_HOST: " . DB_HOST . "<br>";
echo "DB_USER: " . DB_USER . "<br>";
echo "DB_PASS: " . (DB_PASS ? "***" : "(trống)") . "<br>";
echo "DB_NAME: " . DB_NAME . "<br><br>";

// Test 2: Direct mysqli connection
echo "<h3>2. Test kết nối trực tiếp với mysqli:</h3>";
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        echo "<span style='color: red;'>❌ Lỗi: " . $conn->connect_error . "</span><br>";
    } else {
        echo "<span style='color: green;'>✅ Kết nối thành công!</span><br>";
        echo "Server info: " . $conn->server_info . "<br>";
        $conn->close();
    }
} catch (Exception $e) {
    echo "<span style='color: red;'>❌ Exception: " . $e->getMessage() . "</span><br>";
}

// Test 3: Check if database exists
echo "<h3>3. Kiểm tra database có tồn tại:</h3>";
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
    
    if ($conn->connect_error) {
        echo "<span style='color: red;'>❌ Không thể kết nối MySQL: " . $conn->connect_error . "</span><br>";
    } else {
        $result = $conn->query("SHOW DATABASES LIKE '" . DB_NAME . "'");
        if ($result && $result->num_rows > 0) {
            echo "<span style='color: green;'>✅ Database '" . DB_NAME . "' đã tồn tại</span><br>";
        } else {
            echo "<span style='color: orange;'>⚠️ Database '" . DB_NAME . "' chưa tồn tại. Cần import phone_schema.sql</span><br>";
        }
        $conn->close();
    }
} catch (Exception $e) {
    echo "<span style='color: red;'>❌ Exception: " . $e->getMessage() . "</span><br>";
}

// Test 4: Check autoload
echo "<h3>4. Kiểm tra autoload:</h3>";
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    echo "Tìm class: $class<br>";
    echo "File path: $file<br>";
    echo "File exists: " . (file_exists($file) ? "✅ Có" : "❌ Không") . "<br><br>";
    
    if (file_exists($file)) {
        require $file;
    }
});

// Test 5: Test Database class
echo "<h3>5. Test Database class:</h3>";
try {
    if (class_exists('App\Models\Database')) {
        echo "<span style='color: green;'>✅ Class App\Models\Database đã được load</span><br>";
        
        $db = \App\Models\Database::getInstance();
        echo "<span style='color: green;'>✅ Database instance đã được tạo</span><br>";
    } else {
        echo "<span style='color: red;'>❌ Class App\Models\Database không tồn tại</span><br>";
    }
} catch (Exception $e) {
    echo "<span style='color: red;'>❌ Exception: " . $e->getMessage() . "</span><br>";
    echo "Stack trace:<br><pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<hr>";
echo "<p><strong>Hướng dẫn:</strong></p>";
echo "<ol>";
echo "<li>Nếu MySQL chưa chạy: Mở XAMPP Control Panel → Start MySQL</li>";
echo "<li>Nếu database chưa tồn tại: Import file phone_schema.sql trong phpMyAdmin</li>";
echo "<li>Nếu có lỗi autoload: Kiểm tra file Models/Database.php có tồn tại không</li>";
echo "</ol>";
?>

