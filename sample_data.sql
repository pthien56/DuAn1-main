-- Sample data for phone sales system
USE inventory_system;

-- Insert Managers
INSERT INTO Managers (username, password, full_name, phone_number, email, role, status) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nguyễn Văn Admin', '0901234567', 'admin@phone.com', 'admin', 'active'),
('manager1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Trần Thị Quản Lý', '0901234568', 'manager@phone.com', 'manager', 'active');

-- Insert Employees
INSERT INTO Employees (full_name, position, phone_number, email, address, salary, manager_id) VALUES
('Lê Văn Nhân Viên', 'Nhân viên bán hàng', '0901234569', 'nhanvien1@phone.com', '123 Đường ABC, TP.HCM', 8000000, 1),
('Phạm Thị Bán Hàng', 'Nhân viên bán hàng', '0901234570', 'nhanvien2@phone.com', '456 Đường XYZ, TP.HCM', 8000000, 1),
('Hoàng Văn Kho', 'Nhân viên kho', '0901234571', 'kho@phone.com', '789 Đường DEF, TP.HCM', 7000000, 1);

-- Insert Roles
INSERT INTO Roles (role_name, description) VALUES
('Quản lý sản phẩm', 'Quản lý thông tin sản phẩm'),
('Quản lý đơn hàng', 'Xử lý và quản lý đơn hàng'),
('Quản lý kho', 'Quản lý tồn kho'),
('Bán hàng', 'Bán hàng cho khách hàng');

-- Insert Categories
INSERT INTO Categories (category_name, description) VALUES
('Điện thoại thông minh', 'Smartphone các hãng'),
('Phụ kiện', 'Ốp lưng, tai nghe, sạc, cáp...'),
('Đồng hồ thông minh', 'Smartwatch'),
('Tablet', 'Máy tính bảng');

-- Insert Suppliers
INSERT INTO Suppliers (supplier_name, phone_number, email, address, description) VALUES
('Công ty Điện thoại ABC', '0901111111', 'abc@supplier.com', '123 Đường Nhà Cung Cấp, Hà Nội', 'Nhà cung cấp chính'),
('Công ty Phụ kiện XYZ', '0902222222', 'xyz@supplier.com', '456 Đường Phụ Kiện, TP.HCM', 'Chuyên phụ kiện'),
('Công ty Apple Việt Nam', '0903333333', 'apple@supplier.com', '789 Đường Apple, TP.HCM', 'Nhà phân phối Apple chính thức');

-- Insert Products
INSERT INTO Products (product_name, brand, description, category_id, supplier_id) VALUES
('iPhone 15 Pro Max', 'Apple', 'iPhone 15 Pro Max 256GB, màn hình 6.7 inch, chip A17 Pro', 1, 3),
('iPhone 15', 'Apple', 'iPhone 15 128GB, màn hình 6.1 inch, chip A16 Bionic', 1, 3),
('Samsung Galaxy S24 Ultra', 'Samsung', 'Galaxy S24 Ultra 256GB, màn hình 6.8 inch, chip Snapdragon 8 Gen 3', 1, 1),
('Samsung Galaxy S24', 'Samsung', 'Galaxy S24 128GB, màn hình 6.2 inch, chip Snapdragon 8 Gen 3', 1, 1),
('Xiaomi 14 Pro', 'Xiaomi', 'Xiaomi 14 Pro 256GB, màn hình 6.73 inch, chip Snapdragon 8 Gen 3', 1, 1),
('OPPO Find X7 Ultra', 'OPPO', 'OPPO Find X7 Ultra 512GB, màn hình 6.82 inch, chip Snapdragon 8 Gen 3', 1, 1),
('iPad Pro 12.9 inch', 'Apple', 'iPad Pro 12.9 inch M2, 256GB, Wi-Fi', 4, 3),
('Samsung Galaxy Tab S9', 'Samsung', 'Galaxy Tab S9 256GB, màn hình 11 inch', 4, 1),
('Apple Watch Series 9', 'Apple', 'Apple Watch Series 9 GPS 45mm', 3, 3),
('Ốp lưng iPhone 15', 'Generic', 'Ốp lưng trong suốt cho iPhone 15', 2, 2),
('Tai nghe AirPods Pro 2', 'Apple', 'Tai nghe không dây AirPods Pro 2', 2, 3),
('Sạc nhanh 20W', 'Generic', 'Củ sạc nhanh 20W USB-C', 2, 2);

-- Insert Product Variants
INSERT INTO Product_Variants (product_id, variant_name, color, storage, price, stock_quantity, warranty_months) VALUES
-- iPhone 15 Pro Max
(1, 'iPhone 15 Pro Max 256GB Titanium Xanh', 'Titanium Xanh', '256GB', 32990000, 15, 12),
(1, 'iPhone 15 Pro Max 256GB Titanium Trắng', 'Titanium Trắng', '256GB', 32990000, 12, 12),
(1, 'iPhone 15 Pro Max 512GB Titanium Xanh', 'Titanium Xanh', '512GB', 37990000, 8, 12),
-- iPhone 15
(2, 'iPhone 15 128GB Xanh', 'Xanh', '128GB', 21990000, 20, 12),
(2, 'iPhone 15 128GB Hồng', 'Hồng', '128GB', 21990000, 18, 12),
(2, 'iPhone 15 256GB Xanh', 'Xanh', '256GB', 24990000, 15, 12),
-- Samsung Galaxy S24 Ultra
(3, 'Samsung S24 Ultra 256GB Đen', 'Đen', '256GB', 26990000, 10, 12),
(3, 'Samsung S24 Ultra 256GB Tím', 'Tím', '256GB', 26990000, 8, 12),
(3, 'Samsung S24 Ultra 512GB Đen', 'Đen', '512GB', 29990000, 5, 12),
-- Samsung Galaxy S24
(4, 'Samsung S24 128GB Đen', 'Đen', '128GB', 19990000, 15, 12),
(4, 'Samsung S24 128GB Tím', 'Tím', '128GB', 19990000, 12, 12),
-- Xiaomi 14 Pro
(5, 'Xiaomi 14 Pro 256GB Đen', 'Đen', '256GB', 18990000, 10, 12),
(5, 'Xiaomi 14 Pro 256GB Xanh', 'Xanh', '256GB', 18990000, 8, 12),
-- OPPO Find X7 Ultra
(6, 'OPPO Find X7 Ultra 512GB Đen', 'Đen', '512GB', 22990000, 6, 12),
(6, 'OPPO Find X7 Ultra 512GB Xanh', 'Xanh', '512GB', 22990000, 5, 12),
-- iPad Pro
(7, 'iPad Pro 12.9 256GB Xám', 'Xám', '256GB', 29990000, 8, 12),
(7, 'iPad Pro 12.9 256GB Bạc', 'Bạc', '256GB', 29990000, 7, 12),
-- Galaxy Tab S9
(8, 'Galaxy Tab S9 256GB Đen', 'Đen', '256GB', 19990000, 6, 12),
-- Apple Watch
(9, 'Apple Watch Series 9 45mm GPS Đen', 'Đen', '45mm', 10990000, 10, 12),
(9, 'Apple Watch Series 9 45mm GPS Bạc', 'Bạc', '45mm', 10990000, 8, 12),
-- Phụ kiện
(10, 'Ốp lưng iPhone 15 Trong suốt', 'Trong suốt', '', 150000, 50, 3),
(11, 'AirPods Pro 2', 'Trắng', '', 5990000, 20, 12),
(12, 'Sạc nhanh 20W USB-C', 'Trắng', '', 200000, 30, 6);

-- Insert Warehouses
INSERT INTO Warehouses (warehouse_name, location, manager_id) VALUES
('Kho chính TP.HCM', '123 Đường Kho, Quận 1, TP.HCM', 3),
('Kho phụ Hà Nội', '456 Đường Kho, Quận Cầu Giấy, Hà Nội', 3);

-- Insert Order Status
INSERT INTO Order_Status (status_name, description) VALUES
('Chờ xác nhận', 'Đơn hàng mới, chờ xác nhận'),
('Đã xác nhận', 'Đơn hàng đã được xác nhận'),
('Đang chuẩn bị', 'Đang chuẩn bị hàng'),
('Đang giao hàng', 'Đơn hàng đang được giao'),
('Đã giao hàng', 'Đã giao hàng thành công'),
('Đã hủy', 'Đơn hàng đã bị hủy'),
('Hoàn trả', 'Khách hàng đã hoàn trả');

-- Insert Payment Status
INSERT INTO Payment_Status (status_name, description) VALUES
('Chưa thanh toán', 'Chưa thanh toán'),
('Đã thanh toán', 'Đã thanh toán thành công'),
('Thanh toán một phần', 'Đã thanh toán một phần'),
('Hoàn tiền', 'Đã hoàn tiền');

-- Insert Customers
INSERT INTO Customers (full_name, phone_number, email, address, gender, date_of_birth) VALUES
('Nguyễn Văn Khách', '0909999999', 'khach1@email.com', '123 Đường Khách, TP.HCM', 'Nam', '1990-01-15'),
('Trần Thị Mua', '0908888888', 'khach2@email.com', '456 Đường Mua, TP.HCM', 'Nữ', '1995-05-20'),
('Lê Văn Điện Thoại', '0907777777', 'khach3@email.com', '789 Đường Điện, Hà Nội', 'Nam', '1988-11-10'),
('Phạm Thị Smartphone', '0906666666', 'khach4@email.com', '321 Đường Smart, Đà Nẵng', 'Nữ', '1992-03-25');

-- Insert Promotions
INSERT INTO Promotions (promotion_name, discount_percent, start_date, end_date, description) VALUES
('Khuyến mãi tháng 11', 10.00, '2024-11-01', '2024-11-30', 'Giảm 10% cho tất cả sản phẩm'),
('Black Friday', 20.00, '2024-11-25', '2024-11-30', 'Giảm 20% trong tuần Black Friday'),
('Khuyến mãi iPhone', 5.00, '2024-11-01', '2024-12-31', 'Giảm 5% cho tất cả iPhone');

-- Insert Promotion Details
INSERT INTO Promotion_Details (promotion_id, variant_id, note) VALUES
(1, 1, 'Áp dụng cho iPhone 15 Pro Max'),
(1, 2, 'Áp dụng cho iPhone 15 Pro Max'),
(1, 4, 'Áp dụng cho iPhone 15'),
(3, 1, 'Khuyến mãi iPhone'),
(3, 2, 'Khuyến mãi iPhone'),
(3, 4, 'Khuyến mãi iPhone'),
(3, 5, 'Khuyến mãi iPhone');

-- Insert Sample Orders
INSERT INTO Orders (customer_id, employee_id, total_amount, order_status_id, payment_method, note) VALUES
(1, 1, 21990000, 5, 'Tiền mặt', 'Khách hàng mua trực tiếp tại cửa hàng'),
(2, 2, 32990000, 4, 'Chuyển khoản', 'Đơn hàng online'),
(3, 1, 18990000, 3, 'Thẻ tín dụng', 'Đơn hàng online');

-- Insert Order Details
INSERT INTO Order_Details (order_id, variant_id, quantity, unit_price, discount, subtotal) VALUES
(1, 4, 1, 21990000, 0, 21990000),
(2, 1, 1, 32990000, 0, 32990000),
(3, 11, 1, 18990000, 0, 18990000);

-- Insert Payments
INSERT INTO Payments (order_id, amount, payment_method, payment_status_id, transaction_code, note) VALUES
(1, 21990000, 'Tiền mặt', 2, 'CASH001', 'Thanh toán tại cửa hàng'),
(2, 32990000, 'Chuyển khoản', 2, 'TRANS001', 'Chuyển khoản ngân hàng'),
(3, 18990000, 'Thẻ tín dụng', 2, 'CARD001', 'Thanh toán bằng thẻ');

-- Insert Warranty Cards
INSERT INTO Warranty_Cards (order_detail_id, start_date, end_date, status, note) VALUES
(1, '2024-11-01', '2025-11-01', 'Còn hiệu lực', 'Bảo hành chính hãng'),
(2, '2024-11-05', '2025-11-05', 'Còn hiệu lực', 'Bảo hành chính hãng'),
(3, '2024-11-10', '2025-11-10', 'Còn hiệu lực', 'Bảo hành chính hãng');

-- Insert Customer Feedback
INSERT INTO Customer_Feedback (customer_id, variant_id, rating, comment, feedback_date) VALUES
(1, 4, 5, 'Sản phẩm rất tốt, giao hàng nhanh', '2024-11-02 10:00:00'),
(2, 1, 5, 'iPhone đẹp, chất lượng tốt', '2024-11-06 14:30:00'),
(3, 11, 4, 'Sản phẩm ổn, giá hợp lý', '2024-11-11 09:15:00');

