# Dự án Bán Hàng Điện Thoại - MVC Architecture

Dự án đã được refactor hoàn toàn theo mô hình **MVC (Model-View-Controller)** thuần túy.

## Cấu trúc MVC

```
duann1/
├── app/
│   ├── Models/              # Business Logic & Database
│   │   ├── Database.php
│   │   ├── ProductModel.php
│   │   ├── CustomerModel.php
│   │   ├── OrderModel.php
│   │   ├── CartModel.php
│   │   ├── AuthModel.php
│   │   ├── PaymentModel.php
│   │   ├── AdminModel.php
│   │   ├── FeedbackModel.php
│   │   └── EmployeeModel.php
│   │
│   ├── Controllers/          # Request Handling
│   │   ├── BaseController.php
│   │   ├── HomeController.php
│   │   ├── ProductController.php
│   │   ├── CartController.php
│   │   ├── OrderController.php
│   │   ├── AuthController.php
│   │   └── AdminController.php
│   │
│   └── Views/                # Presentation Layer
│       ├── helpers.php
│       ├── layouts/
│       │   ├── header.php
│       │   └── footer.php
│       ├── home/
│       │   └── index.php
│       ├── product/
│       │   ├── index.php
│       │   └── detail.php
│       ├── cart/
│       │   └── index.php
│       ├── order/
│       │   ├── index.php
│       │   ├── detail.php
│       │   └── checkout.php
│       ├── auth/
│       │   ├── login.php
│       │   └── register.php
│       └── admin/
│           ├── dashboard.php
│           ├── products.php
│           ├── orders.php
│           └── order-detail.php
│
├── bootstrap.php            # Autoload & Configuration
├── index.php                # Entry Points
├── products.php
├── cart.php
├── checkout.php
├── orders.php
├── auth/
│   ├── login.php
│   ├── register.php
│   └── logout.php
├── admin/
│   ├── dashboard.php
│   ├── products.php
│   └── orders.php
└── api/
    └── cart.php
```

## Kiến trúc MVC

### 1. Models (app/Models/)
- **Database.php**: Singleton pattern cho database connection
- **ProductModel.php**: Xử lý logic sản phẩm
- **OrderModel.php**: Xử lý logic đơn hàng
- **CustomerModel.php**: Xử lý logic khách hàng
- **CartModel.php**: Xử lý logic giỏ hàng
- Các Model khác...

**Trách nhiệm:**
- Tương tác với database
- Business logic
- Data validation
- Không chứa HTML/Presentation code

### 2. Controllers (app/Controllers/)
- **BaseController.php**: Controller cơ sở với các method chung
- **HomeController.php**: Xử lý trang chủ
- **ProductController.php**: Xử lý sản phẩm
- **CartController.php**: Xử lý giỏ hàng
- **OrderController.php**: Xử lý đơn hàng
- **AuthController.php**: Xử lý đăng nhập/đăng ký
- **AdminController.php**: Xử lý admin

**Trách nhiệm:**
- Nhận request từ user
- Gọi Model để lấy/xử lý dữ liệu
- Điều hướng đến View phù hợp
- Xử lý authentication/authorization

### 3. Views (app/Views/)
- **layouts/**: Header và Footer chung
- **helpers.php**: Helper functions cho views
- Các thư mục con: home, product, cart, order, auth, admin

**Trách nhiệm:**
- Hiển thị HTML
- Hiển thị dữ liệu từ Controller
- Không chứa business logic
- Không tương tác trực tiếp với database

## Luồng hoạt động

```
User Request
    ↓
Entry Point (index.php, products.php, ...)
    ↓
Controller (HomeController, ProductController, ...)
    ↓
Model (ProductModel, OrderModel, ...)
    ↓
Database
    ↓
Model trả về data
    ↓
Controller nhận data và gọi View
    ↓
View render HTML
    ↓
Response về User
```

## Ví dụ luồng xử lý

### Xem danh sách sản phẩm:

1. User truy cập: `products.php`
2. `products.php` load `bootstrap.php` và tạo `ProductController`
3. `ProductController::index()` được gọi
4. Controller gọi `ProductModel::getAll($filters)`
5. Model query database và trả về dữ liệu
6. Controller gọi `$this->view('product/index', $data)`
7. View `app/Views/product/index.php` được render với dữ liệu
8. HTML được trả về cho user

## Ưu điểm của MVC

1. **Separation of Concerns**: Logic, data, và presentation tách biệt
2. **Maintainability**: Dễ bảo trì và mở rộng
3. **Reusability**: Models và Views có thể tái sử dụng
4. **Testability**: Dễ test từng component riêng biệt
5. **Scalability**: Dễ mở rộng thêm tính năng

## Cách sử dụng

### Thêm Model mới:

```php
// app/Models/NewModel.php
namespace App\Models;

class NewModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getData() {
        return $this->db->fetchAll("SELECT * FROM table");
    }
}
```

### Thêm Controller mới:

```php
// app/Controllers/NewController.php
namespace App\Controllers;

use App\Models\NewModel;

class NewController extends BaseController {
    private $model;
    
    public function __construct() {
        $this->model = new NewModel();
    }
    
    public function index() {
        $data = $this->model->getData();
        $this->view('new/index', ['data' => $data]);
    }
}
```

### Thêm View mới:

```php
// app/Views/new/index.php
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main>
    <h1>New Page</h1>
    <?php foreach ($data as $item): ?>
        <p><?php echo htmlspecialchars($item['name']); ?></p>
    <?php endforeach; ?>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
```

## Lưu ý

- Tất cả Models sử dụng `Database::getInstance()` để đảm bảo single connection
- Controllers extend `BaseController` để có các method chung
- Views sử dụng helper functions từ `helpers.php`
- Entry points chỉ khởi tạo Controller và gọi method tương ứng
- Autoload tự động load classes khi cần

## So sánh với code cũ

**Trước (Procedural):**
- Logic và View trộn lẫn
- Khó maintain
- Khó test
- Code lặp lại nhiều

**Sau (MVC):**
- Tách biệt rõ ràng
- Dễ maintain và mở rộng
- Dễ test từng phần
- Code có tổ chức, dễ đọc

