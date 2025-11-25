# Khắc phục sự cố

## Lỗi: "No connection could be made because the target machine actively refused it"

### Nguyên nhân:
MySQL service chưa được khởi động hoặc không thể kết nối.

### Giải pháp:

#### 1. Khởi động MySQL trong XAMPP
- Mở **XAMPP Control Panel**
- Tìm **MySQL** trong danh sách
- Click nút **Start** (nếu chưa chạy)
- Đợi đến khi status hiển thị màu xanh (running)

#### 2. Kiểm tra Port MySQL
- Mặc định MySQL chạy trên port **3306**
- Nếu port khác, cập nhật trong `bootstrap.php`:
  ```php
  define('DB_HOST', 'localhost:3307'); // Nếu port là 3307
  ```

#### 3. Kiểm tra thông tin kết nối
Mở file `bootstrap.php` và kiểm tra:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Mật khẩu MySQL của bạn (nếu có)
define('DB_NAME', 'inventory_system');
```

#### 4. Tạo Database
- Mở phpMyAdmin: http://localhost/phpmyadmin
- Import file `phone_schema.sql` để tạo database và tables
- Import file `sample_data.sql` để thêm dữ liệu mẫu

#### 5. Kiểm tra MySQL Service
- Trong XAMPP Control Panel, kiểm tra MySQL có hiển thị lỗi không
- Nếu có lỗi, click **Logs** để xem chi tiết
- Thử restart MySQL service

### Các lỗi thường gặp khác:

#### "Access denied for user 'root'@'localhost'"
- Kiểm tra mật khẩu MySQL trong `bootstrap.php`
- Hoặc reset mật khẩu MySQL trong XAMPP

#### "Unknown database 'inventory_system'"
- Database chưa được tạo
- Import file `phone_schema.sql` trong phpMyAdmin

#### "Table doesn't exist"
- Tables chưa được tạo
- Import file `phone_schema.sql` trong phpMyAdmin

### Test kết nối:
Tạo file `test_db.php` trong root:
```php
<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'inventory_system');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Kết nối thành công!";
}
$conn->close();
?>
```
Truy cập: http://localhost/duann1/test_db.php

