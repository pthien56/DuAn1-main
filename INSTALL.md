# Hướng dẫn cài đặt

## Yêu cầu hệ thống

- XAMPP (hoặc WAMP/LAMP) với PHP 7.4+
- MySQL 5.7+ hoặc MariaDB 10.3+
- Web browser hiện đại

## Các bước cài đặt

### Bước 1: Cài đặt XAMPP

1. Tải và cài đặt XAMPP từ https://www.apachefriends.org/
2. Khởi động Apache và MySQL từ XAMPP Control Panel

### Bước 2: Tạo Database

1. Mở phpMyAdmin: http://localhost/phpmyadmin
2. Tạo database mới tên `inventory_system` (hoặc import file `phone_schema.sql` sẽ tự tạo)
3. Import file `phone_schema.sql`:
   - Chọn database `inventory_system`
   - Click tab "Import"
   - Chọn file `phone_schema.sql`
   - Click "Go"

4. Import file `sample_data.sql`:
   - Vẫn trong database `inventory_system`
   - Click tab "Import"
   - Chọn file `sample_data.sql`
   - Click "Go"

### Bước 3: Cấu hình

1. Mở file `config/database.php`
2. Kiểm tra và cập nhật nếu cần:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');  // Mật khẩu MySQL của bạn
   define('DB_NAME', 'inventory_system');
   ```

### Bước 4: Kiểm tra

1. Truy cập: http://localhost/duann1/
2. Bạn sẽ thấy trang chủ với danh sách sản phẩm

## Đăng nhập

### Admin
- URL: http://localhost/duann1/auth/login.php
- Chọn "Quản trị viên"
- Username: `admin`
- Password: `password`

### Khách hàng
- Đăng ký tài khoản mới hoặc
- Sử dụng thông tin từ dữ liệu mẫu:
  - Số điện thoại: `0909999999`
  - Email: `khach1@email.com`
  - (Không cần mật khẩu cho đăng nhập khách hàng trong demo)

## Khắc phục sự cố

### Lỗi kết nối database
- Kiểm tra MySQL đã chạy chưa
- Kiểm tra thông tin trong `config/database.php`
- Kiểm tra database `inventory_system` đã được tạo chưa

### Lỗi 404
- Kiểm tra file `.htaccess` có tồn tại không
- Kiểm tra Apache mod_rewrite đã bật chưa

### Không hiển thị sản phẩm
- Kiểm tra đã import `sample_data.sql` chưa
- Kiểm tra bảng `Product_Variants` có dữ liệu không

## Cấu trúc thư mục sau khi cài đặt

```
duann1/
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│       └── products/     (tạo thủ công nếu cần upload ảnh)
├── config/
├── auth/
├── admin/
├── api/
└── includes/
```

## Lưu ý

- Mật khẩu mặc định là `password` - đổi ngay trong môi trường production
- File `.htaccess` giúp bảo vệ một số file nhạy cảm
- Hình ảnh sản phẩm sẽ hiển thị placeholder nếu không có file ảnh

