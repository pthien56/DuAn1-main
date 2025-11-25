# Cấu trúc Backend và Frontend

Dự án đã được tổ chức lại thành 2 phần riêng biệt: **Backend** và **Frontend**.

## Cấu trúc thư mục

```
DuAn1-main/
├── backend/                    # Backend (Admin & API)
│   ├── Controllers/            # Controllers cho admin
│   ├── Models/                 # Models (shared với frontend)
│   ├── Views/                  # Views cho admin
│   │   └── admin/              # Admin views
│   ├── config/                 # Cấu hình backend
│   ├── admin/                  # Entry points cho admin
│   ├── api/                    # API endpoints
│   ├── bootstrap.php           # Bootstrap cho backend
│   └── phone_schema.sql        # Database schema
│
├── frontend/                   # Frontend (Public)
│   ├── public/                 # Entry points công khai
│   │   ├── index.php
│   │   ├── products.php
│   │   ├── cart.php
│   │   └── ...
│   ├── Views/                  # Views cho frontend
│   │   ├── home/
│   │   ├── product/
│   │   ├── cart/
│   │   ├── order/
│   │   ├── auth/
│   │   └── layouts/
│   ├── assets/                 # CSS, JS, Images
│   ├── auth/                   # Auth entry points
│   ├── bootstrap.php           # Bootstrap cho frontend
│   └── Views/helpers.php       # Helper functions
│
└── [các file gốc]             # Files gốc (có thể xóa sau khi test)
```

## Cách sử dụng

### Backend (Admin)

1. Truy cập admin dashboard:
   ```
   http://localhost/[project-path]/backend/admin/dashboard.php
   ```

2. Các entry points:
   - `/backend/admin/dashboard.php` - Dashboard
   - `/backend/admin/products.php` - Quản lý sản phẩm
   - `/backend/admin/orders.php` - Quản lý đơn hàng
   - `/backend/admin/order-detail.php` - Chi tiết đơn hàng

### Frontend (Public)

1. Trang chủ:
   ```
   http://localhost/[project-path]/frontend/public/index.php
   ```

2. Các entry points:
   - `/frontend/public/index.php` - Trang chủ
   - `/frontend/public/products.php` - Danh sách sản phẩm
   - `/frontend/public/product-detail.php` - Chi tiết sản phẩm
   - `/frontend/public/cart.php` - Giỏ hàng
   - `/frontend/public/checkout.php` - Thanh toán
   - `/frontend/public/orders.php` - Đơn hàng của tôi
   - `/frontend/auth/login.php` - Đăng nhập
   - `/frontend/auth/register.php` - Đăng ký

## Models và Controllers

- **Models**: Được đặt trong `backend/Models/` và được chia sẻ giữa backend và frontend
- **Controllers**: 
  - Backend controllers: `backend/Controllers/` (AdminController)
  - Frontend controllers: Có thể sử dụng từ backend hoặc tạo riêng trong `frontend/Controllers/`

## Bootstrap Files

- **Backend**: `backend/bootstrap.php` - Load models, config cho admin
- **Frontend**: `frontend/bootstrap.php` - Load models từ backend, helpers cho frontend

## Lưu ý

1. **Autoload**: Frontend bootstrap tự động load classes từ `backend/` để tái sử dụng Models và Controllers
2. **Views**: Mỗi phần có views riêng
3. **Assets**: Chỉ có trong frontend
4. **Config**: Mỗi phần có config riêng nhưng có thể chia sẻ database config

## Migration từ cấu trúc cũ

Để di chuyển các file từ cấu trúc cũ sang cấu trúc mới:

1. Chạy script `copy_to_backend_frontend.php` để copy các file
2. Cập nhật các đường dẫn trong views và controllers
3. Test các chức năng

## Cấu hình Web Server

### Apache (.htaccess)

Có thể tạo `.htaccess` để rewrite URL:

**Backend:**
```apache
RewriteEngine On
RewriteBase /backend/
RewriteRule ^admin/(.*)$ admin/$1 [L]
```

**Frontend:**
```apache
RewriteEngine On
RewriteBase /frontend/public/
RewriteRule ^$ index.php [L]
RewriteRule ^products$ products.php [L]
```

## Tài khoản test

Xem file `backend/create_test_accounts.php` để tạo tài khoản test.

