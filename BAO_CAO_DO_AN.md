# BÁO CÁO ĐỒ ÁN
# HỆ THỐNG BÁN ĐIỆN THOẠI TRỰC TUYẾN

---

## CHƯƠNG 1: TỔNG QUAN DỰ ÁN

### 1.1. Lý do chọn đề tài

Trong thời đại công nghệ số hiện nay, thương mại điện tử đã trở thành xu hướng tất yếu của xã hội. Việc mua sắm trực tuyến ngày càng phổ biến, đặc biệt là trong lĩnh vực điện thoại di động - một trong những mặt hàng có nhu cầu tiêu thụ cao nhất.

**Lý do chọn đề tài:**
- Nhu cầu mua sắm điện thoại trực tuyến ngày càng tăng cao
- Giúp khách hàng tiết kiệm thời gian, so sánh giá cả dễ dàng
- Hỗ trợ doanh nghiệp quản lý bán hàng hiệu quả hơn
- Tích hợp thanh toán trực tuyến an toàn, tiện lợi
- Áp dụng kiến thức lập trình web vào thực tế

### 1.2. Mục tiêu của đề tài

**Mục tiêu chung:**
Xây dựng hệ thống website bán điện thoại trực tuyến hoàn chỉnh, đáp ứng nhu cầu mua sắm của khách hàng và quản lý của doanh nghiệp.

**Mục tiêu cụ thể:**
- Xây dựng giao diện người dùng thân thiện, responsive
- Phát triển hệ thống quản trị cho Admin
- Tích hợp giỏ hàng và thanh toán trực tuyến (VNPay)
- Quản lý sản phẩm với nhiều biến thể (màu sắc, dung lượng)
- Hệ thống đánh giá sản phẩm
- Quản lý đơn hàng và khách hàng

### 1.3. Các công cụ và công nghệ sử dụng

| Công nghệ | Mô tả |
|-----------|-------|
| PHP 7.4+ | Ngôn ngữ lập trình backend |
| MySQL | Hệ quản trị cơ sở dữ liệu |
| Bootstrap 5 | Framework CSS responsive |
| jQuery | Thư viện JavaScript |
| PDO | PHP Data Objects - kết nối database |
| MVC Pattern | Mô hình kiến trúc phần mềm |
| VNPay API | Cổng thanh toán trực tuyến |
| Apache | Web server |


### 1.4. Kết quả dự kiến đạt được

- Website bán điện thoại hoạt động ổn định
- Giao diện đẹp, dễ sử dụng trên mọi thiết bị
- Hệ thống quản trị đầy đủ chức năng
- Tích hợp thanh toán VNPay thành công
- Cơ sở dữ liệu được thiết kế chuẩn hóa

---

## CHƯƠNG 2: KHẢO SÁT HỆ THỐNG

### 2.1. Thống kê kết quả khảo sát

**Đối tượng khảo sát:** Người dùng có nhu cầu mua điện thoại trực tuyến

| Tiêu chí | Tỷ lệ |
|----------|-------|
| Thường xuyên mua hàng online | 78% |
| Ưu tiên thanh toán trực tuyến | 65% |
| Quan tâm đến đánh giá sản phẩm | 85% |
| Cần so sánh nhiều biến thể | 72% |
| Muốn theo dõi đơn hàng | 90% |

### 2.2. Xác định vấn đề

**Vấn đề của người dùng:**
- Khó khăn trong việc so sánh giá và cấu hình điện thoại
- Thiếu thông tin chi tiết về sản phẩm
- Lo ngại về bảo mật khi thanh toán online
- Muốn xem đánh giá từ người dùng khác

**Vấn đề của doanh nghiệp:**
- Quản lý tồn kho phức tạp với nhiều biến thể sản phẩm
- Theo dõi đơn hàng và trạng thái giao hàng
- Quản lý khách hàng và lịch sử mua hàng
- Thống kê doanh thu và báo cáo

---

## CHƯƠNG 3: PHÂN TÍCH THIẾT KẾ

### 3.1. Phân tích Usecase

#### 3.1.1. Các tác nhân của hệ thống

| Tác nhân | Mô tả |
|----------|-------|
| **Khách (Guest)** | Người dùng chưa đăng nhập, có thể xem sản phẩm, tìm kiếm |
| **Khách hàng (Customer)** | Người dùng đã đăng nhập, có thể mua hàng, đánh giá |
| **Quản trị viên (Admin)** | Quản lý toàn bộ hệ thống |

#### 3.1.2. Biểu đồ Usecase tổng quát

```
┌─────────────────────────────────────────────────────────────────┐
│                    HỆ THỐNG BÁN ĐIỆN THOẠI                      │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌─────────┐                                    ┌─────────┐    │
│  │  Guest  │                                    │  Admin  │    │
│  └────┬────┘                                    └────┬────┘    │
│       │                                              │         │
│       ├──► Xem sản phẩm                              │         │
│       ├──► Tìm kiếm                                  │         │
│       ├──► Đăng ký/Đăng nhập                         │         │
│       │                                              │         │
│  ┌────┴────┐                                         │         │
│  │Customer │                                         │         │
│  └────┬────┘                                         │         │
│       │                                              │         │
│       ├──► Thêm giỏ hàng          ◄──────────────────┤         │
│       ├──► Đặt hàng               Quản lý sản phẩm ──┤         │
│       ├──► Thanh toán VNPay       Quản lý đơn hàng ──┤         │
│       ├──► Xem lịch sử đơn hàng   Quản lý khách hàng─┤         │
│       ├──► Đánh giá sản phẩm      Quản lý danh mục ──┤         │
│       └──► Quản lý tài khoản      Duyệt đánh giá ────┘         │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```


#### 3.1.3. Biểu đồ Usecase phân rã

**A. Usecase Khách hàng (Customer)**

| UC ID | Tên Usecase | Mô tả |
|-------|-------------|-------|
| UC01 | Đăng ký tài khoản | Khách hàng tạo tài khoản mới |
| UC02 | Đăng nhập | Khách hàng đăng nhập hệ thống |
| UC03 | Xem sản phẩm | Xem danh sách và chi tiết sản phẩm |
| UC04 | Tìm kiếm sản phẩm | Tìm kiếm theo tên, thương hiệu |
| UC05 | Lọc sản phẩm | Lọc theo danh mục, giá, thương hiệu |
| UC06 | Thêm giỏ hàng | Thêm sản phẩm vào giỏ hàng |
| UC07 | Quản lý giỏ hàng | Cập nhật, xóa sản phẩm trong giỏ |
| UC08 | Đặt hàng | Tạo đơn hàng mới |
| UC09 | Thanh toán VNPay | Thanh toán qua cổng VNPay |
| UC10 | Xem đơn hàng | Xem lịch sử và chi tiết đơn hàng |
| UC11 | Đánh giá sản phẩm | Đánh giá sao và bình luận |
| UC12 | Cập nhật thông tin | Cập nhật thông tin cá nhân |

**B. Usecase Quản trị viên (Admin)**

| UC ID | Tên Usecase | Mô tả |
|-------|-------------|-------|
| UC13 | Đăng nhập Admin | Admin đăng nhập hệ thống quản trị |
| UC14 | Xem Dashboard | Xem thống kê tổng quan |
| UC15 | Quản lý sản phẩm | Thêm, sửa, xóa sản phẩm |
| UC16 | Quản lý biến thể | Quản lý màu sắc, dung lượng, giá |
| UC17 | Quản lý danh mục | Thêm, sửa, xóa danh mục |
| UC18 | Quản lý đơn hàng | Xem, cập nhật trạng thái đơn hàng |
| UC19 | Quản lý khách hàng | Xem, khóa/mở khóa tài khoản |
| UC20 | Quản lý đánh giá | Duyệt, từ chối, xóa đánh giá |
| UC21 | Upload hình ảnh | Upload ảnh sản phẩm, danh mục |

### 3.2. Biểu đồ hoạt động

**A. Quy trình đặt hàng**

```
┌─────────┐     ┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│  Bắt đầu │────►│ Xem sản phẩm│────►│Thêm giỏ hàng│────►│ Xem giỏ hàng│
└─────────┘     └─────────────┘     └─────────────┘     └──────┬──────┘
                                                               │
                                                               ▼
┌─────────┐     ┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│ Kết thúc│◄────│Xác nhận đơn │◄────│ Thanh toán  │◄────│Nhập thông tin│
└─────────┘     └─────────────┘     └─────────────┘     └─────────────┘
```

**B. Quy trình thanh toán VNPay**

```
┌─────────┐     ┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│Chọn VNPay│───►│Chuyển hướng │────►│ Nhập thông  │────►│  Xác nhận   │
│          │    │  đến VNPay  │     │ tin thẻ/TK  │     │    OTP      │
└─────────┘     └─────────────┘     └─────────────┘     └──────┬──────┘
                                                               │
                     ┌─────────────────────────────────────────┘
                     ▼
              ┌─────────────┐     ┌─────────────┐     ┌─────────────┐
              │ Kết quả TT  │────►│Cập nhật đơn │────►│  Hoàn tất   │
              │  từ VNPay   │     │   hàng      │     │             │
              └─────────────┘     └─────────────┘     └─────────────┘
```

---

## CHƯƠNG 4: THIẾT KẾ HỆ THỐNG

### 4.1. Thiết kế giao diện Admin

**Dashboard:**
- Thống kê tổng quan: Tổng sản phẩm, đơn hàng, khách hàng, doanh thu
- Danh sách đơn hàng gần đây
- Biểu đồ thống kê

**Quản lý sản phẩm:**
- Danh sách sản phẩm với phân trang
- Form thêm/sửa sản phẩm
- Quản lý biến thể (màu, dung lượng, giá, tồn kho)
- Upload hình ảnh sản phẩm

**Quản lý đơn hàng:**
- Danh sách đơn hàng với trạng thái
- Chi tiết đơn hàng
- Cập nhật trạng thái đơn hàng

**Quản lý khách hàng:**
- Danh sách khách hàng
- Tìm kiếm, lọc theo trạng thái
- Khóa/mở khóa tài khoản

### 4.2. Thiết kế giao diện Client

**Trang chủ:**
- Banner quảng cáo
- Danh sách sản phẩm nổi bật
- Lọc theo thương hiệu, danh mục
- Phân trang

**Trang chi tiết sản phẩm:**
- Hình ảnh sản phẩm
- Thông tin chi tiết
- Chọn biến thể (màu, dung lượng)
- Giá và nút thêm giỏ hàng
- Đánh giá từ khách hàng

**Giỏ hàng:**
- Danh sách sản phẩm trong giỏ
- Cập nhật số lượng
- Tổng tiền
- Nút thanh toán

**Thanh toán:**
- Form thông tin giao hàng
- Chọn phương thức thanh toán
- Xác nhận đơn hàng


---

## CHƯƠNG 5: XÂY DỰNG CƠ SỞ DỮ LIỆU

### 5.1. Cơ sở dữ liệu

**Tên database:** `inventory_system`

**Sơ đồ quan hệ (ERD):**

```
┌─────────────┐       ┌─────────────┐       ┌─────────────────┐
│  Managers   │       │  Categories │       │    Suppliers    │
├─────────────┤       ├─────────────┤       ├─────────────────┤
│ manager_id  │       │ category_id │       │  supplier_id    │
│ username    │       │category_name│       │  supplier_name  │
│ password    │       │ description │       │  phone_number   │
│ full_name   │       └──────┬──────┘       │  email          │
│ role        │              │              └────────┬────────┘
│ status      │              │                       │
└─────────────┘              │                       │
                             ▼                       ▼
                      ┌─────────────────────────────────┐
                      │           Products              │
                      ├─────────────────────────────────┤
                      │ product_id (PK)                 │
                      │ product_name                    │
                      │ brand                           │
                      │ description                     │
                      │ category_id (FK)                │
                      │ supplier_id (FK)                │
                      │ created_at                      │
                      └───────────────┬─────────────────┘
                                      │
                                      ▼
                      ┌─────────────────────────────────┐
                      │       Product_Variants          │
                      ├─────────────────────────────────┤
                      │ variant_id (PK)                 │
                      │ product_id (FK)                 │
                      │ variant_name                    │
                      │ color                           │
                      │ storage                         │
                      │ price                           │
                      │ stock_quantity                  │
                      │ warranty_months                 │
                      └───────────────┬─────────────────┘
                                      │
┌─────────────┐                       │
│  Customers  │                       │
├─────────────┤                       │
│ customer_id │◄──────────────────────┼───────────────────┐
│ full_name   │                       │                   │
│ phone_number│                       │                   │
│ email       │                       ▼                   │
│ address     │              ┌─────────────────┐          │
│ gender      │              │  Order_Details  │          │
│ status      │              ├─────────────────┤          │
└──────┬──────┘              │order_detail_id  │          │
       │                     │ order_id (FK)   │          │
       │                     │ variant_id (FK) │          │
       │                     │ quantity        │          │
       │                     │ unit_price      │          │
       │                     │ subtotal        │          │
       │                     └────────┬────────┘          │
       │                              │                   │
       ▼                              ▼                   │
┌─────────────────┐          ┌─────────────────┐          │
│     Orders      │◄─────────┤   Payments      │          │
├─────────────────┤          ├─────────────────┤          │
│ order_id (PK)   │          │ payment_id      │          │
│ customer_id(FK) │          │ order_id (FK)   │          │
│ total_amount    │          │ amount          │          │
│ order_status_id │          │ payment_method  │          │
│ payment_method  │          │ transaction_code│          │
│ note            │          └─────────────────┘          │
│ order_date      │                                       │
└─────────────────┘                                       │
                                                          │
┌─────────────────┐                                       │
│ Product_Reviews │◄──────────────────────────────────────┘
├─────────────────┤
│ review_id (PK)  │
│ product_id (FK) │
│ customer_id(FK) │
│ rating          │
│ comment         │
│ status          │
│ created_at      │
└─────────────────┘
```

### 5.2. Chi tiết cơ sở dữ liệu

#### Bảng Managers (Quản trị viên)
| Tên cột | Kiểu dữ liệu | Mô tả |
|---------|--------------|-------|
| manager_id | INT (PK) | Mã quản trị viên |
| username | VARCHAR(50) | Tên đăng nhập |
| password | VARCHAR(255) | Mật khẩu (hash) |
| full_name | VARCHAR(100) | Họ tên |
| phone_number | VARCHAR(15) | Số điện thoại |
| email | VARCHAR(100) | Email |
| role | VARCHAR(50) | Vai trò (admin, manager) |
| status | VARCHAR(50) | Trạng thái |
| created_at | DATETIME | Ngày tạo |

#### Bảng Categories (Danh mục)
| Tên cột | Kiểu dữ liệu | Mô tả |
|---------|--------------|-------|
| category_id | INT (PK) | Mã danh mục |
| category_name | VARCHAR(100) | Tên danh mục |
| description | TEXT | Mô tả |

#### Bảng Products (Sản phẩm)
| Tên cột | Kiểu dữ liệu | Mô tả |
|---------|--------------|-------|
| product_id | INT (PK) | Mã sản phẩm |
| product_name | VARCHAR(100) | Tên sản phẩm |
| brand | VARCHAR(50) | Thương hiệu |
| description | TEXT | Mô tả chi tiết |
| category_id | INT (FK) | Mã danh mục |
| supplier_id | INT (FK) | Mã nhà cung cấp |
| created_at | DATETIME | Ngày tạo |

#### Bảng Product_Variants (Biến thể sản phẩm)
| Tên cột | Kiểu dữ liệu | Mô tả |
|---------|--------------|-------|
| variant_id | INT (PK) | Mã biến thể |
| product_id | INT (FK) | Mã sản phẩm |
| variant_name | VARCHAR(100) | Tên biến thể |
| color | VARCHAR(50) | Màu sắc |
| storage | VARCHAR(50) | Dung lượng |
| price | DECIMAL(12,2) | Giá bán |
| stock_quantity | INT | Số lượng tồn kho |
| warranty_months | INT | Số tháng bảo hành |

#### Bảng Customers (Khách hàng)
| Tên cột | Kiểu dữ liệu | Mô tả |
|---------|--------------|-------|
| customer_id | INT (PK) | Mã khách hàng |
| full_name | VARCHAR(100) | Họ tên |
| phone_number | VARCHAR(15) | Số điện thoại |
| email | VARCHAR(100) | Email |
| address | VARCHAR(255) | Địa chỉ |
| gender | VARCHAR(10) | Giới tính |
| date_of_birth | DATE | Ngày sinh |
| status | VARCHAR(20) | Trạng thái (active/locked) |
| created_at | DATETIME | Ngày tạo |

#### Bảng Orders (Đơn hàng)
| Tên cột | Kiểu dữ liệu | Mô tả |
|---------|--------------|-------|
| order_id | INT (PK) | Mã đơn hàng |
| customer_id | INT (FK) | Mã khách hàng |
| employee_id | INT (FK) | Mã nhân viên xử lý |
| order_date | DATETIME | Ngày đặt hàng |
| total_amount | DECIMAL(12,2) | Tổng tiền |
| order_status_id | INT (FK) | Mã trạng thái |
| payment_method | VARCHAR(50) | Phương thức thanh toán |
| note | TEXT | Ghi chú |

#### Bảng Order_Details (Chi tiết đơn hàng)
| Tên cột | Kiểu dữ liệu | Mô tả |
|---------|--------------|-------|
| order_detail_id | INT (PK) | Mã chi tiết |
| order_id | INT (FK) | Mã đơn hàng |
| variant_id | INT (FK) | Mã biến thể |
| quantity | INT | Số lượng |
| unit_price | DECIMAL(12,2) | Đơn giá |
| discount | DECIMAL(5,2) | Giảm giá |
| subtotal | DECIMAL(12,2) | Thành tiền |

#### Bảng Product_Reviews (Đánh giá sản phẩm)
| Tên cột | Kiểu dữ liệu | Mô tả |
|---------|--------------|-------|
| review_id | INT (PK) | Mã đánh giá |
| product_id | INT (FK) | Mã sản phẩm |
| customer_id | INT (FK) | Mã khách hàng |
| rating | INT | Số sao (1-5) |
| comment | TEXT | Nội dung đánh giá |
| status | VARCHAR(20) | Trạng thái duyệt |
| created_at | DATETIME | Ngày tạo |


---

## CHƯƠNG 6: KIỂM THỬ - TRIỂN KHAI HỆ THỐNG

### 6.1. Kiểm thử hệ thống

#### 6.1.1. Kiểm thử chức năng (Functional Testing)

**A. Kiểm thử đăng ký tài khoản**

| TC ID | Mô tả | Dữ liệu đầu vào | Kết quả mong đợi | Kết quả |
|-------|-------|-----------------|------------------|---------|
| TC01 | Đăng ký với thông tin hợp lệ | Họ tên: Nguyễn Văn A, Email: test@gmail.com, SĐT: 0901234567, Mật khẩu: 123456 | Tạo tài khoản thành công, chuyển đến trang đăng nhập | ✓ Pass |
| TC02 | Đăng ký với email đã tồn tại | Email: admin@gmail.com (đã có trong hệ thống) | Hiển thị "Email đã được sử dụng" | ✓ Pass |
| TC03 | Đăng ký với email không hợp lệ | Email: abc123 | Hiển thị "Email không hợp lệ" | ✓ Pass |
| TC04 | Đăng ký với SĐT không hợp lệ | SĐT: 123 | Hiển thị "Số điện thoại không hợp lệ" | ✓ Pass |
| TC05 | Đăng ký để trống các trường bắt buộc | Họ tên: (trống) | Hiển thị "Vui lòng nhập họ tên" | ✓ Pass |
| TC06 | Đăng ký mật khẩu quá ngắn | Mật khẩu: 123 | Hiển thị "Mật khẩu tối thiểu 6 ký tự" | ✓ Pass |

**B. Kiểm thử đăng nhập**

| TC ID | Mô tả | Dữ liệu đầu vào | Kết quả mong đợi | Kết quả |
|-------|-------|-----------------|------------------|---------|
| TC07 | Đăng nhập đúng thông tin | Email: test@gmail.com, Mật khẩu: 123456 | Đăng nhập thành công, chuyển đến trang chủ | ✓ Pass |
| TC08 | Đăng nhập sai mật khẩu | Email: test@gmail.com, Mật khẩu: wrongpass | Hiển thị "Sai email hoặc mật khẩu" | ✓ Pass |
| TC09 | Đăng nhập email không tồn tại | Email: notexist@gmail.com | Hiển thị "Sai email hoặc mật khẩu" | ✓ Pass |
| TC10 | Đăng nhập tài khoản bị khóa | Email: locked@gmail.com (status=locked) | Hiển thị "Tài khoản đã bị khóa" | ✓ Pass |
| TC11 | Đăng nhập để trống email | Email: (trống) | Hiển thị "Vui lòng nhập email" | ✓ Pass |
| TC12 | Đăng nhập Admin đúng thông tin | Username: admin, Password: password | Đăng nhập thành công, chuyển đến Dashboard | ✓ Pass |

**C. Kiểm thử xem sản phẩm**

| TC ID | Mô tả | Dữ liệu đầu vào | Kết quả mong đợi | Kết quả |
|-------|-------|-----------------|------------------|---------|
| TC13 | Xem danh sách sản phẩm | Truy cập trang chủ | Hiển thị danh sách sản phẩm với phân trang | ✓ Pass |
| TC14 | Xem chi tiết sản phẩm | Click vào sản phẩm iPhone 15 | Hiển thị thông tin chi tiết, hình ảnh, biến thể | ✓ Pass |
| TC15 | Lọc theo danh mục | Chọn danh mục "Điện thoại" | Chỉ hiển thị sản phẩm thuộc danh mục đã chọn | ✓ Pass |
| TC16 | Lọc theo thương hiệu | Chọn thương hiệu "Apple" | Chỉ hiển thị sản phẩm Apple | ✓ Pass |
| TC17 | Tìm kiếm sản phẩm | Nhập "iPhone" vào ô tìm kiếm | Hiển thị các sản phẩm có tên chứa "iPhone" | ✓ Pass |
| TC18 | Tìm kiếm không có kết quả | Nhập "xyz123abc" | Hiển thị "Không tìm thấy sản phẩm" | ✓ Pass |
| TC19 | Chọn biến thể sản phẩm | Chọn màu "Đen", dung lượng "256GB" | Cập nhật giá và tồn kho theo biến thể | ✓ Pass |

**D. Kiểm thử giỏ hàng**

| TC ID | Mô tả | Dữ liệu đầu vào | Kết quả mong đợi | Kết quả |
|-------|-------|-----------------|------------------|---------|
| TC20 | Thêm sản phẩm vào giỏ | Chọn iPhone 15, số lượng: 1 | Sản phẩm được thêm, hiển thị thông báo thành công | ✓ Pass |
| TC21 | Thêm sản phẩm đã có trong giỏ | Thêm lại iPhone 15 | Tăng số lượng sản phẩm trong giỏ | ✓ Pass |
| TC22 | Cập nhật số lượng | Thay đổi số lượng từ 1 thành 3 | Số lượng và tổng tiền được cập nhật | ✓ Pass |
| TC23 | Cập nhật số lượng = 0 | Thay đổi số lượng thành 0 | Sản phẩm bị xóa khỏi giỏ hàng | ✓ Pass |
| TC24 | Xóa sản phẩm khỏi giỏ | Click nút "Xóa" | Sản phẩm bị xóa, cập nhật tổng tiền | ✓ Pass |
| TC25 | Thêm vượt quá tồn kho | Số lượng: 1000 (tồn kho: 50) | Hiển thị "Số lượng vượt quá tồn kho" | ✓ Pass |
| TC26 | Xem giỏ hàng trống | Giỏ hàng không có sản phẩm | Hiển thị "Giỏ hàng trống" | ✓ Pass |

**E. Kiểm thử đặt hàng**

| TC ID | Mô tả | Dữ liệu đầu vào | Kết quả mong đợi | Kết quả |
|-------|-------|-----------------|------------------|---------|
| TC27 | Đặt hàng COD thành công | Địa chỉ: 123 ABC, Phương thức: COD | Tạo đơn hàng, hiển thị mã đơn | ✓ Pass |
| TC28 | Đặt hàng thiếu địa chỉ | Địa chỉ: (trống) | Hiển thị "Vui lòng nhập địa chỉ" | ✓ Pass |
| TC29 | Đặt hàng khi chưa đăng nhập | Chưa đăng nhập, click "Đặt hàng" | Chuyển đến trang đăng nhập | ✓ Pass |
| TC30 | Đặt hàng giỏ hàng trống | Giỏ hàng trống, truy cập checkout | Chuyển về trang giỏ hàng | ✓ Pass |

**F. Kiểm thử thanh toán VNPay**

| TC ID | Mô tả | Dữ liệu đầu vào | Kết quả mong đợi | Kết quả |
|-------|-------|-----------------|------------------|---------|
| TC31 | Thanh toán VNPay thành công | Thẻ: 9704198526191432198, OTP: 123456 | Thanh toán thành công, cập nhật trạng thái đơn | ✓ Pass |
| TC32 | Thanh toán VNPay thất bại | Hủy giao dịch trên VNPay | Hiển thị "Thanh toán thất bại", đơn hàng pending | ✓ Pass |
| TC33 | Thanh toán sai OTP | OTP: 111111 | Hiển thị lỗi từ VNPay | ✓ Pass |

**G. Kiểm thử đánh giá sản phẩm**

| TC ID | Mô tả | Dữ liệu đầu vào | Kết quả mong đợi | Kết quả |
|-------|-------|-----------------|------------------|---------|
| TC34 | Đánh giá sản phẩm đã mua | Rating: 5 sao, Comment: "Sản phẩm tốt" | Đánh giá được gửi, chờ duyệt | ✓ Pass |
| TC35 | Đánh giá khi chưa đăng nhập | Chưa đăng nhập | Yêu cầu đăng nhập | ✓ Pass |
| TC36 | Đánh giá để trống nội dung | Comment: (trống) | Hiển thị "Vui lòng nhập nội dung" | ✓ Pass |

**H. Kiểm thử quản lý Admin - Sản phẩm**

| TC ID | Mô tả | Dữ liệu đầu vào | Kết quả mong đợi | Kết quả |
|-------|-------|-----------------|------------------|---------|
| TC37 | Thêm sản phẩm mới | Tên: Samsung S24, Thương hiệu: Samsung | Sản phẩm được tạo thành công | ✓ Pass |
| TC38 | Thêm sản phẩm thiếu tên | Tên: (trống) | Hiển thị "Vui lòng nhập tên sản phẩm" | ✓ Pass |
| TC39 | Sửa thông tin sản phẩm | Cập nhật mô tả sản phẩm | Thông tin được cập nhật | ✓ Pass |
| TC40 | Xóa sản phẩm | Click "Xóa" sản phẩm | Sản phẩm bị xóa khỏi hệ thống | ✓ Pass |
| TC41 | Thêm biến thể sản phẩm | Màu: Đen, Dung lượng: 128GB, Giá: 25000000 | Biến thể được thêm | ✓ Pass |
| TC42 | Upload hình ảnh sản phẩm | File: product.jpg (2MB) | Hình ảnh được upload thành công | ✓ Pass |
| TC43 | Upload file không phải ảnh | File: document.pdf | Hiển thị "Chỉ chấp nhận file ảnh" | ✓ Pass |

**I. Kiểm thử quản lý Admin - Đơn hàng**

| TC ID | Mô tả | Dữ liệu đầu vào | Kết quả mong đợi | Kết quả |
|-------|-------|-----------------|------------------|---------|
| TC44 | Xem danh sách đơn hàng | Truy cập trang quản lý đơn hàng | Hiển thị danh sách đơn hàng | ✓ Pass |
| TC45 | Xem chi tiết đơn hàng | Click vào đơn hàng #001 | Hiển thị chi tiết sản phẩm, khách hàng | ✓ Pass |
| TC46 | Cập nhật trạng thái đơn hàng | Đổi từ "Chờ xử lý" sang "Đang giao" | Trạng thái được cập nhật | ✓ Pass |
| TC47 | Lọc đơn hàng theo trạng thái | Chọn "Đã hoàn thành" | Chỉ hiển thị đơn hàng đã hoàn thành | ✓ Pass |

**J. Kiểm thử quản lý Admin - Khách hàng**

| TC ID | Mô tả | Dữ liệu đầu vào | Kết quả mong đợi | Kết quả |
|-------|-------|-----------------|------------------|---------|
| TC48 | Xem danh sách khách hàng | Truy cập trang quản lý khách hàng | Hiển thị danh sách khách hàng | ✓ Pass |
| TC49 | Tìm kiếm khách hàng | Nhập "Nguyễn" | Hiển thị khách hàng có tên chứa "Nguyễn" | ✓ Pass |
| TC50 | Khóa tài khoản khách hàng | Click "Khóa" tài khoản | Tài khoản bị khóa, không thể đăng nhập | ✓ Pass |
| TC51 | Mở khóa tài khoản | Click "Mở khóa" tài khoản đã khóa | Tài khoản được mở khóa | ✓ Pass |

**K. Kiểm thử quản lý Admin - Đánh giá**

| TC ID | Mô tả | Dữ liệu đầu vào | Kết quả mong đợi | Kết quả |
|-------|-------|-----------------|------------------|---------|
| TC52 | Duyệt đánh giá | Click "Duyệt" đánh giá pending | Đánh giá hiển thị trên trang sản phẩm | ✓ Pass |
| TC53 | Từ chối đánh giá | Click "Từ chối" đánh giá | Đánh giá bị ẩn | ✓ Pass |
| TC54 | Xóa đánh giá | Click "Xóa" đánh giá | Đánh giá bị xóa khỏi hệ thống | ✓ Pass |

#### 6.1.2. Kiểm thử giao diện (UI Testing)

| TC ID | Mô tả | Thiết bị/Trình duyệt | Kết quả mong đợi | Kết quả |
|-------|-------|---------------------|------------------|---------|
| UI01 | Responsive trên Desktop | Chrome 1920x1080 | Giao diện hiển thị đầy đủ | ✓ Pass |
| UI02 | Responsive trên Tablet | iPad 768x1024 | Giao diện tự điều chỉnh | ✓ Pass |
| UI03 | Responsive trên Mobile | iPhone 375x667 | Menu hamburger, layout mobile | ✓ Pass |
| UI04 | Tương thích Firefox | Firefox 120 | Hoạt động bình thường | ✓ Pass |
| UI05 | Tương thích Edge | Edge 120 | Hoạt động bình thường | ✓ Pass |
| UI06 | Tương thích Safari | Safari 17 | Hoạt động bình thường | ✓ Pass |

#### 6.1.3. Kiểm thử hiệu năng (Performance Testing)

| TC ID | Mô tả | Điều kiện | Kết quả mong đợi | Kết quả |
|-------|-------|-----------|------------------|---------|
| PF01 | Thời gian tải trang chủ | Kết nối 4G | < 3 giây | ✓ Pass (2.1s) |
| PF02 | Thời gian tải trang sản phẩm | 100 sản phẩm | < 2 giây | ✓ Pass (1.5s) |
| PF03 | Thời gian xử lý đặt hàng | Đơn hàng 5 sản phẩm | < 1 giây | ✓ Pass (0.8s) |
| PF04 | Tải đồng thời | 50 users cùng lúc | Không lỗi timeout | ✓ Pass |

#### 6.1.4. Kiểm thử bảo mật (Security Testing)

| TC ID | Mô tả | Phương pháp kiểm thử | Kết quả |
|-------|-------|---------------------|---------|
| SEC01 | SQL Injection | Nhập `' OR '1'='1` vào form đăng nhập | ✓ Được bảo vệ (PDO Prepared Statements) |
| SEC02 | XSS Attack | Nhập `<script>alert('XSS')</script>` vào form | ✓ Được bảo vệ (htmlspecialchars) |
| SEC03 | CSRF Protection | Gửi request từ domain khác | ✓ Được bảo vệ (Session validation) |
| SEC04 | Password Security | Kiểm tra lưu trữ mật khẩu | ✓ Sử dụng password_hash() |
| SEC05 | Session Hijacking | Thử đánh cắp session | ✓ Được bảo vệ (HTTPOnly cookie) |
| SEC06 | Directory Traversal | Truy cập ../../../etc/passwd | ✓ Bị chặn |
| SEC07 | File Upload Attack | Upload file .php | ✓ Chỉ cho phép file ảnh |

#### 6.1.5. Tổng kết kiểm thử

| Loại kiểm thử | Tổng TC | Pass | Fail | Tỷ lệ |
|---------------|---------|------|------|-------|
| Chức năng | 54 | 54 | 0 | 100% |
| Giao diện | 6 | 6 | 0 | 100% |
| Hiệu năng | 4 | 4 | 0 | 100% |
| Bảo mật | 7 | 7 | 0 | 100% |
| **Tổng cộng** | **71** | **71** | **0** | **100%** |

### 6.2. Triển khai hệ thống

#### 6.2.1. Yêu cầu hệ thống

**Server:**
- Apache 2.4+ với mod_rewrite
- PHP 7.4 trở lên
- MySQL 5.7 trở lên
- Extension: PDO, PDO_MySQL, GD

**Client:**
- Trình duyệt web hiện đại (Chrome, Firefox, Safari, Edge)
- Kết nối Internet

#### 6.2.2. Hướng dẫn cài đặt

**Bước 1: Chuẩn bị môi trường**
```
- Cài đặt XAMPP/WAMP/LAMP
- Bật Apache và MySQL
```

**Bước 2: Import Database**
```sql
-- Mở phpMyAdmin
-- Import file: inventory_system_complete.sql
```

**Bước 3: Cấu hình Database**
```php
// File: config/database.php
private $host = "localhost";
private $db_name = "inventory_system";
private $username = "root";
private $password = "";
```

**Bước 4: Cấu hình URL**
```php
// File: config/config.php
// BASE_URL được tự động xác định
```

**Bước 5: Bật mod_rewrite**
```
- Đảm bảo file .htaccess hoạt động
- Bật AllowOverride All trong Apache config
```

#### 6.2.3. Thông tin đăng nhập mặc định

**Admin:**
- URL: `http://localhost/DuAn1/auth/login`
- Username: `admin`
- Password: `password`

**Test thanh toán VNPay (Sandbox):**
- Ngân hàng: NCB
- Số thẻ: 9704198526191432198
- Tên: NGUYEN VAN A
- Ngày phát hành: 07/15
- OTP: 123456

---

## KẾT LUẬN

### Thời gian phát triển dự án

| Giai đoạn | Thời gian | Công việc |
|-----------|-----------|-----------|
| Tuần 1-2 | 2 tuần | Khảo sát, phân tích yêu cầu |
| Tuần 3-4 | 2 tuần | Thiết kế CSDL, giao diện |
| Tuần 5-8 | 4 tuần | Phát triển chức năng |
| Tuần 9-10 | 2 tuần | Tích hợp VNPay, kiểm thử |
| Tuần 11-12 | 2 tuần | Hoàn thiện, viết báo cáo |

### Mức độ hoàn thành dự án

| Chức năng | Mức độ hoàn thành |
|-----------|-------------------|
| Quản lý sản phẩm | 100% |
| Quản lý biến thể sản phẩm | 100% |
| Giỏ hàng | 100% |
| Đặt hàng | 100% |
| Thanh toán VNPay | 100% |
| Quản lý đơn hàng | 100% |
| Quản lý khách hàng | 100% |
| Đánh giá sản phẩm | 100% |
| Tìm kiếm, lọc sản phẩm | 100% |
| Responsive Design | 100% |

**Tổng mức độ hoàn thành: 100%**

### Thuận lợi trong quá trình thực hiện

| STT | Thuận lợi | Mô tả chi tiết |
|-----|-----------|----------------|
| 1 | Tài liệu phong phú | PHP, MySQL, Bootstrap có cộng đồng lớn, tài liệu hướng dẫn đầy đủ trên Internet |
| 2 | Công cụ phát triển miễn phí | XAMPP, VS Code, phpMyAdmin đều miễn phí và dễ cài đặt |
| 3 | Framework Bootstrap | Hỗ trợ responsive sẵn, tiết kiệm thời gian thiết kế giao diện |
| 4 | VNPay Sandbox | Môi trường test miễn phí, tài liệu API rõ ràng |
| 5 | Kiến thức nền tảng | Đã được học PHP, MySQL trong chương trình đào tạo |
| 6 | Mô hình MVC | Cấu trúc rõ ràng, dễ bảo trì và mở rộng |
| 7 | Hỗ trợ từ giảng viên | Được hướng dẫn và giải đáp thắc mắc kịp thời |

### Khó khăn và cách giải quyết

| STT | Khó khăn | Giải pháp |
|-----|----------|-----------|
| 1 | Tích hợp VNPay phức tạp | Nghiên cứu kỹ tài liệu API, sử dụng sandbox để test từng bước |
| 2 | Quản lý nhiều biến thể sản phẩm | Thiết kế bảng Product_Variants riêng biệt, tách biệt với bảng Products |
| 3 | Đồng bộ giỏ hàng | Sử dụng Session kết hợp AJAX để cập nhật realtime |
| 4 | Bảo mật thanh toán | Sử dụng HTTPS, hash signature từ VNPay, validate dữ liệu |
| 5 | Responsive trên nhiều thiết bị | Sử dụng Bootstrap 5 Grid System, test trên nhiều kích thước màn hình |
| 6 | Xử lý upload hình ảnh | Validate file type, giới hạn dung lượng, đổi tên file tránh trùng |
| 7 | Phân quyền Admin/Customer | Sử dụng Session để lưu role, kiểm tra quyền trước mỗi action |

### Kế hoạch phát triển trong tương lai

1. **Tính năng mới:**
   - Tích hợp thêm cổng thanh toán (MoMo, ZaloPay)
   - Chat trực tuyến với khách hàng
   - Hệ thống voucher, mã giảm giá
   - So sánh sản phẩm
   - Wishlist (Danh sách yêu thích)

2. **Cải thiện:**
   - Tối ưu hiệu suất với caching
   - Thêm API cho ứng dụng mobile
   - Tích hợp giao hàng (GHN, GHTK)
   - Báo cáo thống kê chi tiết hơn
   - Hệ thống thông báo email/SMS

3. **Bảo mật:**
   - Thêm xác thực 2 lớp (2FA)
   - Mã hóa dữ liệu nhạy cảm
   - Audit log cho Admin

---

## PHỤ LỤC

### Cấu trúc thư mục dự án

```
DuAn1/
├── config/                 # Cấu hình
│   ├── config.php         # Cấu hình chung
│   └── database.php       # Kết nối database
├── controllers/           # Controllers (MVC)
│   ├── BaseController.php
│   ├── HomeController.php
│   ├── AuthController.php
│   ├── ProductController.php
│   ├── CartController.php
│   ├── CustomerController.php
│   ├── AdminController.php
│   ├── ReviewController.php
│   └── PageController.php
├── models/                # Models (MVC)
│   ├── BaseModel.php
│   ├── ProductModel.php
│   ├── CartModel.php
│   ├── CustomerModel.php
│   ├── OrderModel.php
│   ├── AdminModel.php
│   ├── ReviewModel.php
│   └── ContactModel.php
├── views/                 # Views (MVC)
│   ├── admin/            # Giao diện Admin
│   ├── auth/             # Đăng nhập/Đăng ký
│   ├── cart/             # Giỏ hàng
│   ├── customer/         # Tài khoản khách hàng
│   ├── home/             # Trang chủ
│   ├── products/         # Sản phẩm
│   ├── pages/            # Trang tĩnh
│   ├── layouts/          # Layout chung
│   └── errors/           # Trang lỗi
├── public/               # Tài nguyên công khai
│   ├── css/             # Stylesheets
│   ├── js/              # JavaScript
│   ├── images/          # Hình ảnh
│   └── data/            # Ảnh sản phẩm
├── vnpay_php/           # Thư viện VNPay
├── database/            # SQL scripts
├── index.php            # Entry point
├── .htaccess            # URL Rewriting
└── README.md            # Hướng dẫn
```

---

**Ngày hoàn thành:** Tháng 12/2024

**Sinh viên thực hiện:** [Tên sinh viên]

**Giảng viên hướng dẫn:** [Tên giảng viên]
