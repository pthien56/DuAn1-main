# Cấu trúc dự án - MVC

Dự án được tổ chức theo mô hình MVC với 3 folder chính ở root:

## Cấu trúc thư mục

```
duann1/
├── Models/              # Business Logic & Database
│   ├── Database.php
│   ├── ProductModel.php
│   ├── OrderModel.php
│   ├── CustomerModel.php
│   ├── CartModel.php
│   ├── AuthModel.php
│   ├── PaymentModel.php
│   ├── AdminModel.php
│   ├── FeedbackModel.php
│   └── EmployeeModel.php
│
├── Controllers/         # Request Handling
│   ├── BaseController.php
│   ├── HomeController.php
│   ├── ProductController.php
│   ├── CartController.php
│   ├── OrderController.php
│   ├── AuthController.php
│   └── AdminController.php
│
├── Views/               # Presentation Layer
│   ├── header.php
│   ├── footer.php
│   ├── helpers.php
│   ├── home_index.php
│   ├── product_index.php
│   ├── product_detail.php
│   ├── cart_index.php
│   ├── order_checkout.php
│   ├── order_index.php
│   ├── order_detail.php
│   ├── auth_login.php
│   ├── auth_register.php
│   ├── admin_dashboard.php
│   ├── admin_products.php
│   ├── admin_orders.php
│   └── admin_order_detail.php
│
├── assets/              # Static files
│   ├── css/
│   ├── js/
│   └── images/
│
├── bootstrap.php        # Autoload & Configuration
├── index.php            # Entry Points
├── products.php
├── cart.php
├── checkout.php
├── orders.php
├── product-detail.php
├── order-detail.php
├── auth/
│   ├── login.php
│   ├── register.php
│   └── logout.php
├── admin/
│   ├── dashboard.php
│   ├── products.php
│   ├── orders.php
│   └── order-detail.php
└── api/
    └── cart.php
```

## Đặc điểm

- **3 folder chính**: Models, Views, Controllers ở root level
- **Không có folder app/**: Tất cả code MVC ở root
- **Views phẳng**: Tất cả views trong Views/ (không có subfolder)
- **Tên file rõ ràng**: `home_index.php`, `product_detail.php`, `admin_dashboard.php`

## Luồng hoạt động

1. User request → Entry point (index.php, products.php, ...)
2. Entry point → Load bootstrap.php → Autoload classes
3. Entry point → Tạo Controller → Gọi method
4. Controller → Gọi Model → Lấy dữ liệu
5. Controller → Gọi View → Render HTML
6. Response về User

## Namespace

- Models: `App\Models\`
- Controllers: `App\Controllers\`
- Views: Không có namespace (plain PHP files)

## Autoload

File `bootstrap.php` tự động load classes từ:
- `Models/` → `App\Models\`
- `Controllers/` → `App\Controllers\`

