<?php
// Script kiểm tra và hướng dẫn khởi động MySQL
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiểm tra MySQL Connection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 { color: #333; }
        .success { color: green; padding: 10px; background: #d4edda; border-radius: 5px; margin: 10px 0; }
        .error { color: red; padding: 10px; background: #f8d7da; border-radius: 5px; margin: 10px 0; }
        .warning { color: orange; padding: 10px; background: #fff3cd; border-radius: 5px; margin: 10px 0; }
        .info { color: blue; padding: 10px; background: #d1ecf1; border-radius: 5px; margin: 10px 0; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
        ol { line-height: 1.8; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Kiểm tra kết nối MySQL</h1>
        
        <?php
        $ports = [3306, 3307, 3308];
        $connected = false;
        $workingPort = null;
        
        echo "<h2>1. Kiểm tra các port MySQL:</h2>";
        
        foreach ($ports as $port) {
            echo "<p>Đang thử kết nối port <strong>$port</strong>... ";
            
            try {
                $testConn = @new mysqli('localhost', 'root', '', '', $port);
                
                if ($testConn->connect_error) {
                    if (strpos($testConn->connect_error, 'Access denied') !== false) {
                        echo "<span class='warning'>⚠️ Port $port đang chạy nhưng cần mật khẩu hoặc quyền truy cập</span></p>";
                        $workingPort = $port;
                    } else {
                        echo "<span class='error'>❌ Lỗi: " . $testConn->connect_error . "</span></p>";
                    }
                } else {
                    echo "<span class='success'>✅ Port $port hoạt động!</span></p>";
                    $connected = true;
                    $workingPort = $port;
                    $testConn->close();
                    break;
                }
            } catch (Exception $e) {
                echo "<span class='error'>❌ Exception: " . $e->getMessage() . "</span></p>";
            }
        }
        
        if (!$connected && !$workingPort) {
            echo "<div class='error'>";
            echo "<h3>❌ MySQL không chạy trên bất kỳ port nào!</h3>";
            echo "<p><strong>Giải pháp:</strong></p>";
            echo "<ol>";
            echo "<li><strong>Mở XAMPP Control Panel</strong></li>";
            echo "<li>Tìm <strong>MySQL</strong> trong danh sách services</li>";
            echo "<li>Click nút <strong>Start</strong> (màu xanh lá)</li>";
            echo "<li>Đợi đến khi status hiển thị <strong>Running</strong> (màu xanh)</li>";
            echo "<li>Refresh lại trang này</li>";
            echo "</ol>";
            echo "</div>";
        } else {
            echo "<div class='success'>";
            echo "<h3>✅ Tìm thấy MySQL trên port $workingPort!</h3>";
            echo "</div>";
            
            // Test kết nối với database
            echo "<h2>2. Kiểm tra database 'inventory_system':</h2>";
            
            try {
                $conn = new mysqli('localhost', 'root', '', 'inventory_system', $workingPort);
                
                if ($conn->connect_error) {
                    if (strpos($conn->connect_error, 'Unknown database') !== false) {
                        echo "<div class='warning'>";
                        echo "<h3>⚠️ Database 'inventory_system' chưa tồn tại!</h3>";
                        echo "<p><strong>Cách tạo database:</strong></p>";
                        echo "<ol>";
                        echo "<li>Mở <a href='http://localhost/phpmyadmin' target='_blank'>phpMyAdmin</a></li>";
                        echo "<li>Click tab <strong>Import</strong></li>";
                        echo "<li>Chọn file <code>phone_schema.sql</code></li>";
                        echo "<li>Click <strong>Go</strong> để import</li>";
                        echo "<li>Sau đó import tiếp file <code>sample_data.sql</code></li>";
                        echo "</ol>";
                        echo "</div>";
                    } else {
                        echo "<div class='error'>";
                        echo "<p>Lỗi: " . $conn->connect_error . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='success'>";
                    echo "<h3>✅ Kết nối database thành công!</h3>";
                    echo "<p>Server version: " . $conn->server_info . "</p>";
                    
                    // Kiểm tra tables
                    $result = $conn->query("SHOW TABLES");
                    if ($result && $result->num_rows > 0) {
                        echo "<p>Số bảng: <strong>" . $result->num_rows . "</strong></p>";
                    } else {
                        echo "<div class='warning'>";
                        echo "<p>⚠️ Database trống, chưa có bảng nào. Cần import <code>phone_schema.sql</code></p>";
                        echo "</div>";
                    }
                    echo "</div>";
                    $conn->close();
                }
            } catch (Exception $e) {
                echo "<div class='error'>";
                echo "<p>Exception: " . $e->getMessage() . "</p>";
                echo "</div>";
            }
            
            // Hướng dẫn cập nhật bootstrap.php
            echo "<h2>3. Cập nhật cấu hình:</h2>";
            echo "<div class='info'>";
            echo "<p>Nếu port MySQL là <strong>$workingPort</strong> (khác 3306), cần cập nhật file <code>bootstrap.php</code>:</p>";
            echo "<pre style='background: #f4f4f4; padding: 15px; border-radius: 5px; overflow-x: auto;'>";
            echo "define('DB_HOST', 'localhost:$workingPort');\n";
            echo "define('DB_USER', 'root');\n";
            echo "define('DB_PASS', '');\n";
            echo "define('DB_NAME', 'inventory_system');";
            echo "</pre>";
            echo "</div>";
        }
        ?>
        
        <h2>4. Hướng dẫn chi tiết:</h2>
        <div class="info">
            <h3>Khởi động MySQL trong XAMPP:</h3>
            <ol>
                <li>Mở <strong>XAMPP Control Panel</strong> (tìm trong Start Menu hoặc Desktop)</li>
                <li>Tìm dòng <strong>MySQL</strong> trong danh sách</li>
                <li>Nếu nút <strong>Start</strong> có sẵn (không bị disable), click vào đó</li>
                <li>Nếu có lỗi khi start, click vào nút <strong>Logs</strong> để xem chi tiết</li>
                <li>Đợi đến khi status chuyển sang màu xanh và hiển thị <strong>Running</strong></li>
                <li>Refresh lại trang này để kiểm tra</li>
            </ol>
            
            <h3>Nếu MySQL không start được:</h3>
            <ol>
                <li>Kiểm tra port 3306 có bị ứng dụng khác chiếm không</li>
                <li>Thử stop và start lại MySQL</li>
                <li>Kiểm tra Windows Firewall có chặn MySQL không</li>
                <li>Xem log trong XAMPP Control Panel → MySQL → Logs</li>
            </ol>
        </div>
    </div>
</body>
</html>

