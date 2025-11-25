<?php
namespace App\Models;

class Database {
    private static $instance = null;
    private $conn;
    
    private function __construct() {
        try {
            // Parse host và port từ DB_HOST
            $host = DB_HOST;
            $port = 3306; // Default port
            
            if (strpos(DB_HOST, ':') !== false) {
                list($host, $port) = explode(':', DB_HOST);
                $port = (int)$port;
            }
            
            $this->conn = new \mysqli(
                $host,
                DB_USER,
                DB_PASS,
                DB_NAME,
                $port
            );
            
            if ($this->conn->connect_error) {
                throw new \Exception("Connection failed: " . $this->conn->connect_error);
            }
            
            $this->conn->set_charset("utf8");
        } catch (\mysqli_sql_exception $e) {
            die("
                <div style='padding: 20px; font-family: Arial; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px;'>
                    <h2 style='color: #721c24;'>Lỗi kết nối Database</h2>
                    <p style='color: #721c24;'><strong>Nguyên nhân:</strong> Không thể kết nối đến MySQL server.</p>
                    <p style='color: #721c24;'><strong>Giải pháp:</strong></p>
                    <ol style='color: #721c24;'>
                        <li>Kiểm tra XAMPP Control Panel - đảm bảo MySQL đã được khởi động (nút Start)</li>
                        <li>Kiểm tra MySQL đang chạy trên port 3306 (mặc định)</li>
                        <li>Kiểm tra thông tin kết nối trong file <code>bootstrap.php</code>:
                            <ul>
                                <li>DB_HOST: " . DB_HOST . "</li>
                                <li>DB_USER: " . DB_USER . "</li>
                                <li>DB_NAME: " . DB_NAME . "</li>
                            </ul>
                        </li>
                        <li>Đảm bảo database <strong>" . DB_NAME . "</strong> đã được tạo (import file phone_schema.sql)</li>
                    </ol>
                    <p style='color: #721c24;'><strong>Chi tiết lỗi:</strong> " . htmlspecialchars($e->getMessage()) . "</p>
                </div>
            ");
        } catch (\Exception $e) {
            die("
                <div style='padding: 20px; font-family: Arial; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px;'>
                    <h2 style='color: #721c24;'>Lỗi kết nối Database</h2>
                    <p style='color: #721c24;'>" . htmlspecialchars($e->getMessage()) . "</p>
                    <p style='color: #721c24;'>Vui lòng kiểm tra MySQL service đã được khởi động trong XAMPP Control Panel.</p>
                </div>
            ");
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->conn;
    }
    
    public function query($sql, $params = [], $types = '') {
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt === false) {
            throw new \Exception("Prepare failed: " . $this->conn->error . " | SQL: " . $sql);
        }
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        if (!$stmt->execute()) {
            throw new \Exception("Execute failed: " . $stmt->error . " | SQL: " . $sql);
        }
        
        return $stmt->get_result();
    }
    
    public function insert($sql, $params = [], $types = '') {
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt === false) {
            throw new \Exception("Prepare failed: " . $this->conn->error . " | SQL: " . $sql);
        }
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        if (!$stmt->execute()) {
            throw new \Exception("Execute failed: " . $stmt->error . " | SQL: " . $sql);
        }
        
        return $this->conn->insert_id;
    }
    
    public function update($sql, $params = [], $types = '') {
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt === false) {
            throw new \Exception("Prepare failed: " . $this->conn->error . " | SQL: " . $sql);
        }
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        if (!$stmt->execute()) {
            throw new \Exception("Execute failed: " . $stmt->error . " | SQL: " . $sql);
        }
        
        return true;
    }
    
    public function delete($sql, $params = [], $types = '') {
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt === false) {
            throw new \Exception("Prepare failed: " . $this->conn->error . " | SQL: " . $sql);
        }
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        if (!$stmt->execute()) {
            throw new \Exception("Execute failed: " . $stmt->error . " | SQL: " . $sql);
        }
        
        return true;
    }
    
    public function fetchAll($sql, $params = [], $types = '') {
        $result = $this->query($sql, $params, $types);
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    
    public function fetchOne($sql, $params = [], $types = '') {
        $result = $this->query($sql, $params, $types);
        if ($result) {
            return $result->fetch_assoc();
        }
        return null;
    }
}