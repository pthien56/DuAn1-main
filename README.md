# Dự án Bán Hàng Điện Thoại

Dự án website bán hàng điện thoại với đầy đủ các chức năng quản lý sản phẩm, đơn hàng, khách hàng và kho.

## Cấu trúc dự án

```
duann1/
├── config/
│   ├── database.php      # Kết nối database
│   └── functions.php     # Các hàm tiện ích
├── auth/
│   ├── login.php         # Đăng nhập
│   ├── register.php      # Đăng ký
│   └── logout.php        # Đăng xuất
├── admin/
│   ├── dashboard.php     # Trang quản trị chính
│   ├── products.php      # Quản lý sản phẩm
│   ├── orders.php        # Quản lý đơn hàng
│   └── order-detail.php  # Chi tiết đơn hàng
├── api/
│   └── cart.php          # API quản lý giỏ hàng
├── includes/
│   ├── header.php        # Header chung
│   └── footer.php        # Footer chung
├── assets/
│   ├── css/
│   │   ├── style.css     # CSS chính
│   │   └── admin.css     # CSS admin
│   ├── js/
│   │   └── main.js       # JavaScript chính
│   └── images/
│       └── placeholder.jpg
├── index.php             # Trang chủ
├── products.php          # Danh sách sản phẩm
├── product-detail.php    # Chi tiết sản phẩm
├── cart.php              # Giỏ hàng
├── checkout.php          # Thanh toán
├── orders.php            # Đơn hàng của khách hàng
├── order-detail.php      # Chi tiết đơn hàng
├── phone_schema.sql      # Schema database
└── sample_data.sql       # Dữ liệu mẫu
```

## Cài đặt

### 1. Cài đặt Database

1. Mở phpMyAdmin hoặc MySQL command line
2. Import file `phone_schema.sql` để tạo database và các bảng
3. Import file `sample_data.sql` để thêm dữ liệu mẫu

Hoặc chạy lệnh:
```bash
mysql -u root -p < phone_schema.sql
mysql -u root -p < sample_data.sql
```

### 2. Cấu hình Database

Mở file `config/database.php` và cập nhật thông tin kết nối:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'inventory_system');
```

### 3. Tạo thư mục images

Tạo thư mục `assets/images/products/` để lưu hình ảnh sản phẩm (tùy chọn).

### 4. Chạy dự án

1. Đặt dự án trong thư mục `htdocs` của XAMPP
2. Khởi động Apache và MySQL trong XAMPP
3. Truy cập: `http://localhost/duann1/`

## Tài khoản mẫu

### Admin/Manager
- Username: `admin`
- Password: `password`

### Khách hàng
- Sử dụng số điện thoại hoặc email từ dữ liệu mẫu để đăng nhập
- Hoặc đăng ký tài khoản mới

## Chức năng

### Frontend (Khách hàng)
- ✅ Xem danh sách sản phẩm
- ✅ Tìm kiếm và lọc sản phẩm
- ✅ Xem chi tiết sản phẩm
- ✅ Thêm vào giỏ hàng
- ✅ Quản lý giỏ hàng
- ✅ Đặt hàng và thanh toán
- ✅ Xem lịch sử đơn hàng
- ✅ Đăng ký/Đăng nhập

### Backend (Admin)
- ✅ Dashboard với thống kê
- ✅ Quản lý sản phẩm
- ✅ Quản lý đơn hàng
- ✅ Cập nhật trạng thái đơn hàng
- ✅ Xem thông tin khách hàng
- ✅ Xem sản phẩm sắp hết hàng

## Database Schema

Database bao gồm các bảng chính:
- **Managers**: Quản lý tài khoản admin
- **Employees**: Nhân viên
- **Customers**: Khách hàng
- **Products**: Sản phẩm
- **Product_Variants**: Phiên bản sản phẩm (màu sắc, bộ nhớ)
- **Categories**: Danh mục sản phẩm
- **Suppliers**: Nhà cung cấp
- **Orders**: Đơn hàng
- **Order_Details**: Chi tiết đơn hàng
- **Payments**: Thanh toán
- **Warehouses**: Kho hàng
- **Inventory_Receipts**: Phiếu nhập kho
- **Promotions**: Khuyến mãi
- **Customer_Feedback**: Đánh giá khách hàng
- Và các bảng khác...

## Lưu ý

- Mật khẩu mặc định trong dữ liệu mẫu là `password` (đã được hash)
- Trong môi trường production, cần:
  - Hash mật khẩu đúng cách
  - Bảo mật tốt hơn
  - Validate input kỹ hơn
  - Xử lý lỗi tốt hơn
  - Thêm CSRF protection

## Công nghệ sử dụng

- PHP 7.4+
- MySQL
- HTML5/CSS3
- JavaScript (Vanilla)
- Bootstrap (có thể thêm)

## Phát triển thêm

Có thể mở rộng thêm:
- Quản lý kho (nhập/xuất kho)
- Quản lý khuyến mãi
- Quản lý nhà cung cấp
- Báo cáo và thống kê chi tiết
- Upload hình ảnh sản phẩm
- Email thông báo
- Tích hợp thanh toán online
