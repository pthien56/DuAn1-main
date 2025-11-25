# Hướng dẫn Copy Files vào Backend và Frontend

## Bước 1: Chạy script copy

Chạy file `copy_to_backend_frontend.php` để tự động copy các file:

```bash
php copy_to_backend_frontend.php
```

## Bước 2: Copy thủ công các file còn lại

### Backend - Copy các file sau:

1. **Controllers** (nếu chưa có):
   ```bash
   # Copy tất cả Controllers vào backend/Controllers/
   cp -r Controllers/* backend/Controllers/
   ```

2. **Models**:
   ```bash
   # Copy tất cả Models vào backend/Models/
   cp -r Models/* backend/Models/
   ```

3. **Admin Views**:
   ```bash
   # Copy admin views
   cp -r Views/admin/* backend/Views/admin/
   cp Views/admin_*.php backend/Views/
   ```

### Frontend - Copy các file sau:

1. **Public Entry Points** (đã tạo, chỉ cần copy nếu có thay đổi):
   - index.php
   - products.php
   - product-detail.php
   - cart.php
   - checkout.php
   - orders.php
   - order-detail.php

2. **Views**:
   ```bash
   # Copy frontend views
   cp -r Views/home frontend/Views/
   cp -r Views/product frontend/Views/
   cp -r Views/cart frontend/Views/
   cp -r Views/order frontend/Views/
   cp -r Views/auth frontend/Views/
   cp -r Views/layouts frontend/Views/
   
   # Copy old format views
   cp Views/home_*.php frontend/Views/
   cp Views/product_*.php frontend/Views/
   cp Views/cart_*.php frontend/Views/
   cp Views/order_*.php frontend/Views/
   cp Views/auth_*.php frontend/Views/
   cp Views/header.php frontend/Views/
   cp Views/footer.php frontend/Views/
   ```

3. **Assets**:
   ```bash
   # Copy assets
   cp -r assets/* frontend/assets/
   ```

4. **Auth Entry Points** (đã tạo):
   - auth/login.php
   - auth/register.php
   - auth/logout.php

## Bước 3: Cập nhật đường dẫn

Sau khi copy, cần cập nhật các đường dẫn trong:

1. **Views**: Cập nhật `require_once` và `baseUrl()` paths
2. **Controllers**: Đảm bảo view paths đúng
3. **Layouts**: Cập nhật asset paths

## Bước 4: Test

1. Test backend:
   - Truy cập: `http://localhost/[path]/backend/admin/dashboard.php`
   - Đăng nhập với admin account

2. Test frontend:
   - Truy cập: `http://localhost/[path]/frontend/public/index.php`
   - Test các chức năng: xem sản phẩm, giỏ hàng, đăng nhập

## Lưu ý

- Giữ nguyên cấu trúc gốc cho đến khi test xong
- Backup database trước khi test
- Kiểm tra các đường dẫn trong views và controllers

