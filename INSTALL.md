# Hướng Dẫn Cài Đặt

## Yêu Cầu Hệ Thống

- PHP 7.4 trở lên
- MySQL 5.7 trở lên hoặc MariaDB 10.2 trở lên
- Apache với mod_rewrite được bật
- PDO và PDO_MySQL extension

## Các Bước Cài Đặt

### 1. Import Database

1. Mở phpMyAdmin (http://localhost/phpmyadmin)
2. Tạo database mới tên `inventory_system` (hoặc sử dụng database có sẵn)
3. Chọn database vừa tạo
4. Vào tab "Import"
5. Chọn file `inventory_system_complete.sql`
6. Click "Go" để import

**Lưu ý:** Database sẽ tự động được tạo nếu chưa tồn tại khi import file SQL.

### 2. Cấu Hình Database

Mở file `config/database.php` và cập nhật thông tin kết nối:

```php
private $host = "localhost";        // Địa chỉ MySQL server
private $db_name = "inventory_system";  // Tên database
private $username = "root";          // Username MySQL
private $password = "";              // Password MySQL (để trống nếu không có)
```

### 3. Cấu Hình BASE_URL

Mở file `config/config.php` và cập nhật BASE_URL:

```php
define('BASE_URL', 'http://localhost/DuAn1/');
```

**Lưu ý:** 
- Thay `DuAn1` bằng tên thư mục dự án của bạn
- Nếu chạy trên domain, thay bằng domain của bạn (ví dụ: `http://yourdomain.com/`)

### 4. Kiểm Tra mod_rewrite

Đảm bảo Apache đã bật mod_rewrite:

1. Mở file `httpd.conf` của Apache
2. Tìm dòng `#LoadModule rewrite_module modules/mod_rewrite.so`
3. Bỏ dấu `#` ở đầu dòng
4. Khởi động lại Apache

### 5. Phân Quyền Thư Mục

Đảm bảo Apache có quyền đọc các file:
- Không cần quyền ghi đặc biệt cho các thư mục

## Thông Tin Đăng Nhập Admin

Sau khi import database, bạn có thể đăng nhập với:

- **URL:** `http://localhost/DuAn1/auth/login`
- **Username:** `admin`
- **Password:** `password`

**Lưu ý:** Password trong database đã được hash bằng bcrypt. Nếu muốn đổi password, bạn có thể:
1. Tạo hash mới bằng PHP: `password_hash('your_password', PASSWORD_DEFAULT)`
2. Cập nhật trong database bảng `Managers`

## Kiểm Tra Cài Đặt

1. Truy cập: `http://localhost/DuAn1/home/index`
2. Nếu thấy trang chủ, cài đặt thành công!
3. Thử đăng nhập admin: `http://localhost/DuAn1/auth/login`

## Xử Lý Lỗi Thường Gặp

### Lỗi: "Connection error"
- Kiểm tra lại thông tin database trong `config/database.php`
- Đảm bảo MySQL đang chạy
- Kiểm tra username/password MySQL

### Lỗi: "404 Not Found"
- Kiểm tra mod_rewrite đã được bật
- Kiểm tra file `.htaccess` có tồn tại
- Kiểm tra BASE_URL trong `config/config.php`

### Lỗi: "Class not found"
- Kiểm tra autoload trong `config/config.php`
- Đảm bảo các file Model/Controller đã được tạo đầy đủ

### Lỗi: "Session not started"
- Kiểm tra session đã được bật trong PHP
- Kiểm tra quyền ghi của thư mục session (thường là `/tmp`)

## Cấu Trúc Thư Mục

```
DuAn1/
├── config/              # Cấu hình
│   ├── config.php       # Cấu hình chung
│   └── database.php     # Cấu hình database
├── controllers/         # Controllers (MVC)
│   ├── AdminController.php
│   ├── CartController.php
│   ├── HomeController.php
│   ├── ProductController.php
│   └── ...
├── models/              # Models (MVC)
│   ├── ProductModel.php
│   ├── CartModel.php
│   └── ...
├── views/               # Views (MVC)
│   ├── admin/           # Views cho admin
│   ├── cart/            # Views giỏ hàng
│   ├── home/            # Views trang chủ
│   └── ...
├── public/              # Tài nguyên công khai
│   ├── css/             # Stylesheet
│   └── js/              # JavaScript
├── index.php            # Entry point
├── .htaccess            # URL rewriting
└── README.md            # Tài liệu
```

## Hỗ Trợ

Nếu gặp vấn đề, vui lòng kiểm tra:
1. PHP error log
2. Apache error log
3. MySQL error log
4. Console trình duyệt (F12)

