-- Database schema và dữ liệu mẫu cho hệ thống quản lý bán điện thoại
-- Date: 2024-12-13

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;
SET collation_connection = 'utf8mb4_unicode_ci';

-- ============================================
-- PHẦN 1: TẠO CẤU TRÚC BẢNG
-- ============================================

-- 1. Managers
CREATE TABLE Managers (
  manager_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  full_name VARCHAR(100),
  phone_number VARCHAR(15),
  email VARCHAR(100),
  role VARCHAR(50),
  status VARCHAR(50),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Manager_Logs (
  log_id INT AUTO_INCREMENT PRIMARY KEY,
  manager_id INT NOT NULL,
  action_type VARCHAR(50),
  description TEXT,
  action_time DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (manager_id) REFERENCES Managers(manager_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Employees & Roles
CREATE TABLE Employees (
  employee_id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100),
  position VARCHAR(50),
  phone_number VARCHAR(15),
  email VARCHAR(100),
  address VARCHAR(255),
  hire_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  salary DECIMAL(12,2),
  manager_id INT,
  FOREIGN KEY (manager_id) REFERENCES Managers(manager_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Roles (
  role_id INT AUTO_INCREMENT PRIMARY KEY,
  role_name VARCHAR(50) UNIQUE,
  description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Employee_Roles (
  employee_id INT NOT NULL,
  role_id INT NOT NULL,
  assigned_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (employee_id, role_id),
  FOREIGN KEY (employee_id) REFERENCES Employees(employee_id) ON DELETE CASCADE,
  FOREIGN KEY (role_id) REFERENCES Roles(role_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Categories, Suppliers, Products, Product_Variants
CREATE TABLE Categories (
  category_id INT AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(100),
  description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Suppliers (
  supplier_id INT AUTO_INCREMENT PRIMARY KEY,
  supplier_name VARCHAR(100),
  phone_number VARCHAR(15),
  email VARCHAR(100),
  address VARCHAR(255),
  description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Products (
  product_id INT AUTO_INCREMENT PRIMARY KEY,
  product_name VARCHAR(100) NOT NULL,
  brand VARCHAR(50),
  description TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  category_id INT,
  supplier_id INT,
  FOREIGN KEY (category_id) REFERENCES Categories(category_id) ON DELETE SET NULL,
  FOREIGN KEY (supplier_id) REFERENCES Suppliers(supplier_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Product_Variants (
  variant_id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  variant_name VARCHAR(100),
  color VARCHAR(50),
  storage VARCHAR(50),
  price DECIMAL(12,2),
  stock_quantity INT DEFAULT 0,
  warranty_months INT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 4. Warehouses, Inventory Receipts, Receipt Details, Stock Logs
CREATE TABLE Warehouses (
  warehouse_id INT AUTO_INCREMENT PRIMARY KEY,
  warehouse_name VARCHAR(100),
  location VARCHAR(255),
  manager_id INT,
  FOREIGN KEY (manager_id) REFERENCES Employees(employee_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Inventory_Receipts (
  receipt_id INT AUTO_INCREMENT PRIMARY KEY,
  supplier_id INT,
  employee_id INT,
  receipt_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  total_value DECIMAL(12,2),
  FOREIGN KEY (supplier_id) REFERENCES Suppliers(supplier_id) ON DELETE SET NULL,
  FOREIGN KEY (employee_id) REFERENCES Employees(employee_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Receipt_Details (
  receipt_detail_id INT AUTO_INCREMENT PRIMARY KEY,
  receipt_id INT NOT NULL,
  variant_id INT NOT NULL,
  quantity INT,
  unit_cost DECIMAL(12,2),
  total_cost DECIMAL(12,2),
  FOREIGN KEY (receipt_id) REFERENCES Inventory_Receipts(receipt_id) ON DELETE CASCADE,
  FOREIGN KEY (variant_id) REFERENCES Product_Variants(variant_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Stock_Logs (
  log_id INT AUTO_INCREMENT PRIMARY KEY,
  variant_id INT NOT NULL,
  warehouse_id INT,
  change_type VARCHAR(50),
  quantity INT,
  log_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  reference_id INT,
  FOREIGN KEY (variant_id) REFERENCES Product_Variants(variant_id) ON DELETE CASCADE,
  FOREIGN KEY (warehouse_id) REFERENCES Warehouses(warehouse_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Customers & Orders
CREATE TABLE Customers (
  customer_id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100),
  phone_number VARCHAR(15),
  email VARCHAR(100),
  password VARCHAR(255),
  address VARCHAR(255),
  gender VARCHAR(10),
  date_of_birth DATE,
  status VARCHAR(20) DEFAULT 'active',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Order_Status (
  order_status_id INT AUTO_INCREMENT PRIMARY KEY,
  status_name VARCHAR(50),
  description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Orders (
  order_id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT,
  employee_id INT,
  order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  total_amount DECIMAL(12,2),
  order_status_id INT,
  payment_method VARCHAR(50),
  note TEXT,
  FOREIGN KEY (customer_id) REFERENCES Customers(customer_id) ON DELETE SET NULL,
  FOREIGN KEY (employee_id) REFERENCES Employees(employee_id) ON DELETE SET NULL,
  FOREIGN KEY (order_status_id) REFERENCES Order_Status(order_status_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Order_Details (
  order_detail_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  variant_id INT NOT NULL,
  quantity INT,
  unit_price DECIMAL(12,2),
  discount DECIMAL(5,2),
  subtotal DECIMAL(12,2),
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE,
  FOREIGN KEY (variant_id) REFERENCES Product_Variants(variant_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Warranty_Cards (
  warranty_id INT AUTO_INCREMENT PRIMARY KEY,
  order_detail_id INT,
  start_date DATE,
  end_date DATE,
  status VARCHAR(50),
  note TEXT,
  FOREIGN KEY (order_detail_id) REFERENCES Order_Details(order_detail_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Payments
CREATE TABLE Payment_Status (
  payment_status_id INT AUTO_INCREMENT PRIMARY KEY,
  status_name VARCHAR(50),
  description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Payments (
  payment_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  payment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  amount DECIMAL(12,2),
  payment_method VARCHAR(50),
  payment_status_id INT,
  transaction_code VARCHAR(50),
  note TEXT,
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE,
  FOREIGN KEY (payment_status_id) REFERENCES Payment_Status(payment_status_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Promotions & Feedback
CREATE TABLE Promotions (
  promotion_id INT AUTO_INCREMENT PRIMARY KEY,
  promotion_name VARCHAR(100),
  discount_percent DECIMAL(5,2),
  start_date DATE,
  end_date DATE,
  description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Promotion_Details (
  promotion_detail_id INT AUTO_INCREMENT PRIMARY KEY,
  promotion_id INT,
  variant_id INT,
  note TEXT,
  FOREIGN KEY (promotion_id) REFERENCES Promotions(promotion_id) ON DELETE CASCADE,
  FOREIGN KEY (variant_id) REFERENCES Product_Variants(variant_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Customer_Feedback (
  feedback_id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT,
  variant_id INT,
  rating INT,
  comment TEXT,
  feedback_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES Customers(customer_id) ON DELETE SET NULL,
  FOREIGN KEY (variant_id) REFERENCES Product_Variants(variant_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Product Logs
CREATE TABLE Product_Logs (
  log_id INT AUTO_INCREMENT PRIMARY KEY,
  variant_id INT,
  employee_id INT,
  action_type VARCHAR(20),
  old_data TEXT,
  new_data TEXT,
  action_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  note TEXT,
  FOREIGN KEY (variant_id) REFERENCES Product_Variants(variant_id) ON DELETE SET NULL,
  FOREIGN KEY (employee_id) REFERENCES Employees(employee_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- PHẦN 2: THÊM DỮ LIỆU MẪU
-- ============================================

-- 1. Managers
INSERT INTO Managers (username, password, full_name, phone_number, email, role, status) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', N'Nguyễn Văn Admin', '0901234567', 'admin@phone.com', 'admin', 'active'),
('manager1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', N'Trần Thị Quản Lý', '0901234568', 'manager1@phone.com', 'manager', 'active'),
('manager2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', N'Lê Văn Quản Lý', '0901234569', 'manager2@phone.com', 'manager', 'active');

-- 2. Employees
INSERT INTO Employees (full_name, position, phone_number, email, address, salary, manager_id) VALUES
(N'Lê Văn Nhân Viên', N'Nhân viên bán hàng', '0902234569', 'nhanvien1@phone.com', N'123 Đường ABC, TP.HCM', 8000000, 1),
(N'Phạm Thị Bán Hàng', N'Nhân viên bán hàng', '0902234570', 'nhanvien2@phone.com', N'456 Đường XYZ, TP.HCM', 8000000, 1),
(N'Hoàng Văn Kho', N'Nhân viên kho', '0902234571', 'kho@phone.com', N'789 Đường DEF, TP.HCM', 7000000, 1);

-- 3. Roles
INSERT INTO Roles (role_name, description) VALUES
(N'Quản lý sản phẩm', N'Quản lý thông tin sản phẩm'),
(N'Quản lý đơn hàng', N'Xử lý và quản lý đơn hàng'),
(N'Quản lý kho', N'Quản lý tồn kho'),
(N'Bán hàng', N'Bán hàng cho khách hàng'),
(N'Kế toán', N'Quản lý tài chính');

-- 4. Categories
INSERT INTO Categories (category_name, description) VALUES
(N'Điện thoại thông minh', N'Smartphone các hãng'),
(N'Phụ kiện', N'Ốp lưng, tai nghe, sạc, cáp...'),
(N'Đồng hồ thông minh', N'Smartwatch'),
(N'Tablet', N'Máy tính bảng'),
(N'Laptop', N'Máy tính xách tay'),
(N'Tai nghe', N'Tai nghe có dây và không dây'),
(N'Sạc và cáp', N'Củ sạc, cáp sạc các loại'),
(N'Pin dự phòng', N'Pin sạc dự phòng'),
(N'Ốp lưng', N'Ốp lưng điện thoại các loại'),
(N'Camera và phụ kiện', N'Camera, ống kính và phụ kiện');

-- 5. Suppliers
INSERT INTO Suppliers (supplier_name, phone_number, email, address, description) VALUES
(N'Công ty Apple Việt Nam', '0903333333', 'apple@supplier.com', N'789 Đường Apple, TP.HCM', N'Nhà phân phối Apple chính thức'),
(N'Công ty Samsung Việt Nam', '0904444444', 'samsung@supplier.com', N'321 Đường Samsung, TP.HCM', N'Nhà phân phối Samsung chính thức'),
(N'Công ty Xiaomi Việt Nam', '0905555555', 'xiaomi@supplier.com', N'654 Đường Xiaomi, Hà Nội', N'Nhà phân phối Xiaomi'),
(N'Công ty OPPO Việt Nam', '0906666666', 'oppo@supplier.com', N'987 Đường OPPO, TP.HCM', N'Nhà phân phối OPPO'),
(N'Công ty Phụ kiện XYZ', '0902222222', 'xyz@supplier.com', N'456 Đường Phụ Kiện, TP.HCM', N'Chuyên phụ kiện');


-- 6. Products - Điện thoại
INSERT INTO Products (product_name, brand, description, category_id, supplier_id) VALUES
(N'iPhone 15 Pro Max', 'Apple', N'iPhone 15 Pro Max, màn hình 6.7 inch, chip A17 Pro', 1, 1),
(N'iPhone 15 Pro', 'Apple', N'iPhone 15 Pro, màn hình 6.1 inch, chip A17 Pro', 1, 1),
(N'iPhone 15', 'Apple', N'iPhone 15, màn hình 6.1 inch, chip A16 Bionic', 1, 1),
(N'iPhone 14 Pro', 'Apple', N'iPhone 14 Pro, màn hình 6.1 inch, chip A16 Bionic', 1, 1),
(N'Samsung Galaxy S24 Ultra', 'Samsung', N'Galaxy S24 Ultra, màn hình 6.8 inch, chip Snapdragon 8 Gen 3', 1, 2),
(N'Samsung Galaxy S24', 'Samsung', N'Galaxy S24, màn hình 6.2 inch, chip Snapdragon 8 Gen 3', 1, 2),
(N'Samsung Galaxy S25', 'Samsung', N'Galaxy S25, màn hình 6.2 inch, chip Snapdragon 8 Gen 3', 1, 2),
(N'Samsung Galaxy S23 FE', 'Samsung', N'Galaxy S23 FE, màn hình 6.4 inch', 1, 2),
(N'Samsung Galaxy Z Fold 5', 'Samsung', N'Galaxy Z Fold 5, màn hình gập 7.6 inch', 1, 2),
(N'Xiaomi 14 Pro', 'Xiaomi', N'Xiaomi 14 Pro, màn hình 6.73 inch, chip Snapdragon 8 Gen 3', 1, 3),
(N'Xiaomi 13 Ultra', 'Xiaomi', N'Xiaomi 13 Ultra, camera Leica', 1, 3),
(N'Xiaomi 13T Pro', 'Xiaomi', N'Xiaomi 13T Pro, màn hình 6.67 inch', 1, 3),
(N'OPPO Find X7 Ultra', 'OPPO', N'OPPO Find X7 Ultra, màn hình 6.82 inch', 1, 4),
(N'OPPO Reno 11 Pro', 'OPPO', N'OPPO Reno 11 Pro, màn hình 6.7 inch', 1, 4),
(N'Google Pixel 8 Pro', 'Google', N'Pixel 8 Pro, màn hình 6.7 inch, chip Tensor G3', 1, 5),
(N'OnePlus 12', 'OnePlus', N'OnePlus 12, màn hình 6.82 inch', 1, 5),
(N'Vivo X100 Pro', 'Vivo', N'Vivo X100 Pro, camera Zeiss', 1, 5),
(N'HONOR Magic 6 Pro', 'HONOR', N'HONOR Magic 6 Pro, màn hình 6.8 inch', 1, 5),
(N'Realme GT 5 Pro', 'Realme', N'Realme GT 5 Pro, màn hình 6.78 inch', 1, 5),
(N'TECNO Phantom V Fold', 'TECNO', N'TECNO Phantom V Fold, màn hình gập', 1, 5);

-- Products - Tablet
INSERT INTO Products (product_name, brand, description, category_id, supplier_id) VALUES
(N'iPad Pro 12.9 inch', 'Apple', N'iPad Pro 12.9 inch M2, Wi-Fi', 4, 1),
(N'iPad Air M2', 'Apple', N'iPad Air M2, màn hình 10.9 inch', 4, 1),
(N'Samsung Galaxy Tab S9', 'Samsung', N'Galaxy Tab S9, màn hình 11 inch', 4, 2),
(N'Samsung Galaxy Tab S9 FE', 'Samsung', N'Galaxy Tab S9 FE, màn hình 10.9 inch', 4, 2),
(N'Xiaomi Pad 6 Pro', 'Xiaomi', N'Xiaomi Pad 6 Pro, màn hình 11 inch', 4, 3),
(N'OPPO Pad 2', 'OPPO', N'OPPO Pad 2, màn hình 11.61 inch', 4, 4),
(N'OnePlus Pad', 'OnePlus', N'OnePlus Pad, màn hình 11.61 inch', 4, 5),
(N'Lenovo Tab P12 Pro', 'Lenovo', N'Lenovo Tab P12 Pro, màn hình 12.6 inch', 4, 5),
(N'Huawei MatePad Pro 13.2', 'Huawei', N'Huawei MatePad Pro, màn hình 13.2 inch', 4, 5),
(N'Microsoft Surface Pro 9', 'Microsoft', N'Surface Pro 9, màn hình 13 inch', 4, 5),
(N'Realme Pad 2', 'Realme', N'Realme Pad 2, màn hình 11.5 inch', 4, 5),
(N'Amazon Fire Max 11', 'Amazon', N'Fire Max 11, màn hình 11 inch', 4, 5);

-- Products - Đồng hồ thông minh
INSERT INTO Products (product_name, brand, description, category_id, supplier_id) VALUES
(N'Apple Watch Series 9', 'Apple', N'Apple Watch Series 9 GPS 45mm', 3, 1),
(N'Apple Watch Ultra 2', 'Apple', N'Apple Watch Ultra 2, màn hình 49mm', 3, 1),
(N'Samsung Galaxy Watch 6 Classic', 'Samsung', N'Galaxy Watch 6 Classic 47mm', 3, 2),
(N'Xiaomi Watch S3', 'Xiaomi', N'Xiaomi Watch S3, màn hình AMOLED', 3, 3),
(N'Huawei Watch GT 4', 'Huawei', N'Huawei Watch GT 4, màn hình AMOLED', 3, 5),
(N'OnePlus Watch 2', 'OnePlus', N'OnePlus Watch 2, Wear OS', 3, 5),
(N'Garmin Forerunner 265', 'Garmin', N'Garmin Forerunner 265, GPS', 3, 5),
(N'Amazfit GTR 4', 'Amazfit', N'Amazfit GTR 4, màn hình AMOLED', 3, 5),
(N'TicWatch Pro 5', 'TicWatch', N'TicWatch Pro 5, Wear OS', 3, 5),
(N'Fitbit Charge 6', 'Fitbit', N'Fitbit Charge 6, theo dõi sức khỏe', 3, 5),
(N'Fossil Gen 6', 'Fossil', N'Fossil Gen 6, Wear OS', 3, 5);

-- Products - Laptop
INSERT INTO Products (product_name, brand, description, category_id, supplier_id) VALUES
(N'MacBook Pro 14 inch M3', 'Apple', N'MacBook Pro 14 inch chip M3', 5, 1),
(N'Dell XPS 13 Plus', 'Dell', N'Dell XPS 13 Plus, màn hình OLED', 5, 5),
(N'HP Spectre x360 14', 'HP', N'HP Spectre x360 14, màn hình cảm ứng', 5, 5),
(N'Lenovo ThinkPad X1 Carbon', 'Lenovo', N'ThinkPad X1 Carbon Gen 11', 5, 5),
(N'ASUS ROG Zephyrus G14', 'ASUS', N'ROG Zephyrus G14, gaming laptop', 5, 5),
(N'Acer Swift X 14', 'Acer', N'Acer Swift X 14, OLED display', 5, 5),
(N'Microsoft Surface Laptop 5', 'Microsoft', N'Surface Laptop 5, màn hình 13.5 inch', 5, 5),
(N'Samsung Galaxy Book3 Pro', 'Samsung', N'Galaxy Book3 Pro, AMOLED display', 5, 2),
(N'LG Gram 17', 'LG', N'LG Gram 17, siêu nhẹ', 5, 5),
(N'Razer Blade 14', 'Razer', N'Razer Blade 14, gaming laptop', 5, 5);


-- Products - Tai nghe
INSERT INTO Products (product_name, brand, description, category_id, supplier_id) VALUES
(N'Tai nghe AirPods Pro 2', 'Apple', N'AirPods Pro 2, chống ồn chủ động', 6, 1),
(N'AirPods Max', 'Apple', N'AirPods Max, tai nghe over-ear cao cấp', 6, 1),
(N'Samsung Galaxy Buds2 Pro', 'Samsung', N'Galaxy Buds2 Pro, chống ồn ANC', 6, 2),
(N'Sony WF-1000XM5', 'Sony', N'Sony WF-1000XM5, chống ồn hàng đầu', 6, 5),
(N'Tai nghe Bluetooth Sony WH-1000XM5', 'Sony', N'Sony WH-1000XM5, over-ear chống ồn', 6, 5),
(N'Bose QuietComfort Earbuds II', 'Bose', N'Bose QC Earbuds II, chống ồn cao cấp', 6, 5),
(N'Jabra Elite 10', 'Jabra', N'Jabra Elite 10, Dolby Atmos', 6, 5),
(N'Nothing Ear (2)', 'Nothing', N'Nothing Ear 2, thiết kế trong suốt', 6, 5),
(N'OnePlus Buds Pro 2', 'OnePlus', N'OnePlus Buds Pro 2, ANC', 6, 5),
(N'Xiaomi Buds 4 Pro', 'Xiaomi', N'Xiaomi Buds 4 Pro, chống ồn 48dB', 6, 3),
(N'Beats Fit Pro', 'Beats', N'Beats Fit Pro, thiết kế thể thao', 6, 1),
(N'Anker Soundcore Liberty 4', 'Anker', N'Soundcore Liberty 4, LDAC', 6, 5);

-- Products - Sạc và cáp
INSERT INTO Products (product_name, brand, description, category_id, supplier_id) VALUES
(N'Sạc nhanh 20W', 'Generic', N'Củ sạc nhanh 20W USB-C', 7, 5),
(N'Sạc nhanh Apple 20W USB-C', 'Apple', N'Sạc nhanh Apple 20W chính hãng', 7, 1),
(N'Sạc nhanh Samsung 25W', 'Samsung', N'Sạc nhanh Samsung 25W Super Fast', 7, 2),
(N'Sạc không dây MagSafe Baseus', 'Baseus', N'Sạc không dây MagSafe 15W', 7, 5),
(N'Sạc không dây Samsung 15W', 'Samsung', N'Sạc không dây Samsung Wireless Charger', 7, 2),
(N'Sạc đa cổng Anker 65W', 'Anker', N'Anker 65W GaN, 3 cổng', 7, 5),
(N'Sạc đứng Baseus 20W', 'Baseus', N'Sạc đứng Baseus 20W cho iPhone', 7, 5),
(N'Cáp Lightning Baseus 1m', 'Baseus', N'Cáp Lightning Baseus 1m, MFi', 7, 5),
(N'Cáp sạc nhanh Xiaomi 67W', 'Xiaomi', N'Cáp sạc nhanh Xiaomi 67W Type-C', 7, 3);

-- Products - Pin dự phòng
INSERT INTO Products (product_name, brand, description, category_id, supplier_id) VALUES
(N'Pin dự phòng Anker PowerCore 20000', 'Anker', N'Anker PowerCore 20000mAh, PD 20W', 8, 5),
(N'Pin dự phòng Xiaomi 20000 Pro', 'Xiaomi', N'Xiaomi 20000mAh, sạc nhanh 50W', 8, 3),
(N'Pin dự phòng Samsung 10000', 'Samsung', N'Samsung 10000mAh, Wireless', 8, 2),
(N'Pin dự phòng Baseus 20000', 'Baseus', N'Baseus 20000mAh, 65W PD', 8, 5),
(N'Pin dự phòng Romoss 30000', 'Romoss', N'Romoss 30000mAh, 3 cổng output', 8, 5),
(N'Pin dự phòng UGREEN 20000', 'UGREEN', N'UGREEN 20000mAh, 100W PD', 8, 5),
(N'Pin dự phòng Belkin 10000', 'Belkin', N'Belkin 10000mAh, MagSafe', 8, 5),
(N'Pin dự phòng RavPower 20000', 'RavPower', N'RavPower 20000mAh, 60W PD', 8, 5),
(N'Pin dự phòng Mophie Powerstation', 'Mophie', N'Mophie Powerstation 10000mAh', 8, 5),
(N'Pin dự phòng Zendure SuperTank', 'Zendure', N'Zendure SuperTank 27000mAh, 100W', 8, 5);

-- Products - Ốp lưng
INSERT INTO Products (product_name, brand, description, category_id, supplier_id) VALUES
(N'Ốp lưng iPhone 15', 'Generic', N'Ốp lưng trong suốt cho iPhone 15', 9, 5),
(N'Ốp lưng iPhone 15 Pro Spigen', 'Spigen', N'Ốp lưng Spigen Ultra Hybrid', 9, 5),
(N'Ốp lưng Samsung S24 Ultra Otterbox', 'Otterbox', N'Ốp lưng Otterbox Defender', 9, 5),
(N'Ốp lưng MagSafe Spigen', 'Spigen', N'Ốp lưng MagSafe Spigen Mag Armor', 9, 5),
(N'Ốp lưng da Apple Leather', 'Apple', N'Ốp lưng da Apple chính hãng', 9, 1),
(N'Ốp lưng trong suốt Ringke', 'Ringke', N'Ốp lưng Ringke Fusion', 9, 5),
(N'Ốp lưng silicon Caseology', 'Caseology', N'Ốp lưng Caseology Nano Pop', 9, 5),
(N'Ốp lưng chống nước Lifeproof', 'Lifeproof', N'Ốp lưng Lifeproof FRE', 9, 5),
(N'Ốp lưng kim loại Rhinoshield', 'Rhinoshield', N'Ốp lưng Rhinoshield SolidSuit', 9, 5),
(N'Ốp lưng gỗ Pela', 'Pela', N'Ốp lưng Pela Case thân thiện môi trường', 9, 5);

-- Products - Camera và phụ kiện
INSERT INTO Products (product_name, brand, description, category_id, supplier_id) VALUES
(N'Camera GoPro Hero 12', 'GoPro', N'GoPro Hero 12 Black, 5.3K', 10, 5),
(N'Camera DJI Osmo Action 4', 'DJI', N'DJI Osmo Action 4, 4K 120fps', 10, 5),
(N'Camera 360 Insta360 X3', 'Insta360', N'Insta360 X3, quay 360 độ', 10, 5),
(N'Gimbal DJI OM 6', 'DJI', N'DJI OM 6, gimbal cho điện thoại', 10, 5),
(N'Stabilizer Zhiyun Smooth 5', 'Zhiyun', N'Zhiyun Smooth 5, gimbal 3 trục', 10, 5),
(N'Tripod Manfrotto Compact', 'Manfrotto', N'Manfrotto Compact Action, chân máy', 10, 5),
(N'Đèn LED Ring Light Neewer', 'Neewer', N'Neewer Ring Light 18 inch', 10, 5),
(N'Micro Rode VideoMic Me-C', 'Rode', N'Rode VideoMic Me-C, micro USB-C', 10, 5),
(N'Ống kính Moment cho iPhone', 'Moment', N'Moment Wide Lens cho iPhone', 10, 5),
(N'Bộ lọc ND Variable', 'Generic', N'Bộ lọc ND Variable cho camera', 10, 5),
(N'Webcam Logitech C920', 'Logitech', N'Logitech C920 HD Pro', 10, 5);

-- Products - Phụ kiện khác
INSERT INTO Products (product_name, brand, description, category_id, supplier_id) VALUES
(N'Loa Bluetooth JBL Flip 6', 'JBL', N'JBL Flip 6, chống nước IP67', 2, 5),
(N'Bàn phím cơ Logitech MX Keys', 'Logitech', N'Logitech MX Keys, backlit', 2, 5),
(N'Chuột không dây Logitech MX Master 3S', 'Logitech', N'Logitech MX Master 3S, 8K DPI', 2, 5),
(N'Hub USB-C Baseus 7 trong 1', 'Baseus', N'Hub USB-C 7 in 1, HDMI 4K', 2, 5),
(N'Giá đỡ điện thoại Baseus', 'Baseus', N'Giá đỡ điện thoại Baseus cho xe hơi', 2, 5),
(N'Giá đỡ laptop Nulaxy', 'Nulaxy', N'Giá đỡ laptop Nulaxy nhôm', 2, 5),
(N'Bàn di chuột gaming Razer', 'Razer', N'Razer Gigantus V2, XXL', 2, 5),
(N'Đèn bàn LED Baseus', 'Baseus', N'Đèn bàn LED Baseus, điều chỉnh độ sáng', 2, 5);


-- 7. Product_Variants - Điện thoại
INSERT INTO Product_Variants (product_id, variant_name, color, storage, price, stock_quantity, warranty_months) VALUES
-- iPhone 15 Pro Max
(1, N'iPhone 15 Pro Max 256GB Titan Xanh', N'Titan Xanh', '256GB', 32990000, 15, 12),
(1, N'iPhone 15 Pro Max 256GB Titan Trắng', N'Titan Trắng', '256GB', 32990000, 12, 12),
(1, N'iPhone 15 Pro Max 512GB Titan Đen', N'Titan Đen', '512GB', 37990000, 8, 12),
-- iPhone 15 Pro
(2, N'iPhone 15 Pro 256GB Titan Xanh', N'Titan Xanh', '256GB', 28990000, 10, 12),
(2, N'iPhone 15 Pro 128GB Titan Trắng', N'Titan Trắng', '128GB', 26990000, 15, 12),
-- iPhone 15
(3, N'iPhone 15 128GB Xanh', N'Xanh', '128GB', 21990000, 20, 12),
(3, N'iPhone 15 128GB Hồng', N'Hồng', '128GB', 21990000, 18, 12),
(3, N'iPhone 15 256GB Đen', N'Đen', '256GB', 24990000, 15, 12),
-- iPhone 14 Pro
(4, N'iPhone 14 Pro 128GB Tím', N'Tím', '128GB', 24990000, 10, 12),
(4, N'iPhone 14 Pro 256GB Vàng', N'Vàng', '256GB', 27990000, 8, 12),
-- Samsung Galaxy S24 Ultra
(5, N'Samsung S24 Ultra 256GB Đen', N'Đen', '256GB', 26990000, 10, 12),
(5, N'Samsung S24 Ultra 256GB Tím', N'Tím', '256GB', 26990000, 8, 12),
(5, N'Samsung S24 Ultra 512GB Xám', N'Xám', '512GB', 29990000, 5, 12),
-- Samsung Galaxy S24
(6, N'Samsung S24 128GB Đen', N'Đen', '128GB', 19990000, 15, 12),
(6, N'Samsung S24 256GB Tím', N'Tím', '256GB', 21990000, 12, 12),
-- Samsung Galaxy S25
(7, N'Samsung S25 128GB Xanh Navy', N'Xanh Navy', '128GB', 22990000, 20, 12),
(7, N'Samsung S25 256GB Bạc', N'Bạc', '256GB', 24990000, 15, 12),
-- Samsung Galaxy S23 FE
(8, N'Samsung S23 FE 128GB Xanh Mint', N'Xanh Mint', '128GB', 14990000, 25, 12),
-- Samsung Galaxy Z Fold 5
(9, N'Samsung Z Fold 5 256GB Đen', N'Đen', '256GB', 44990000, 4, 12),
(9, N'Samsung Z Fold 5 512GB Kem', N'Kem', '512GB', 48990000, 3, 12),
-- Xiaomi 14 Pro
(10, N'Xiaomi 14 Pro 256GB Đen', N'Đen', '256GB', 18990000, 10, 12),
(10, N'Xiaomi 14 Pro 512GB Trắng', N'Trắng', '512GB', 21990000, 8, 12),
-- Xiaomi 13 Ultra
(11, N'Xiaomi 13 Ultra 256GB Đen', N'Đen', '256GB', 20990000, 7, 12),
(11, N'Xiaomi 13 Ultra 512GB Xanh', N'Xanh', '512GB', 23990000, 5, 12),
-- Xiaomi 13T Pro
(12, N'Xiaomi 13T Pro 256GB Đen', N'Đen', '256GB', 13990000, 15, 12),
-- OPPO Find X7 Ultra
(13, N'OPPO Find X7 Ultra 256GB Đen', N'Đen', '256GB', 22990000, 6, 12),
-- OPPO Reno 11 Pro
(14, N'OPPO Reno 11 Pro 256GB Xanh', N'Xanh', '256GB', 12990000, 12, 12),
-- Google Pixel 8 Pro
(15, N'Google Pixel 8 Pro 128GB Đen', N'Đen', '128GB', 24990000, 8, 12),
-- OnePlus 12
(16, N'OnePlus 12 256GB Đen', N'Đen', '256GB', 19990000, 10, 12),
-- Vivo X100 Pro
(17, N'Vivo X100 Pro 256GB Xanh', N'Xanh', '256GB', 21990000, 7, 12),
-- HONOR Magic 6 Pro
(18, N'HONOR Magic 6 Pro 512GB Đen', N'Đen', '512GB', 23990000, 5, 12),
-- Realme GT 5 Pro
(19, N'Realme GT 5 Pro 256GB Trắng', N'Trắng', '256GB', 14990000, 12, 12),
-- TECNO Phantom V Fold
(20, N'TECNO Phantom V Fold 256GB Đen', N'Đen', '256GB', 25990000, 4, 12);

-- Product_Variants - Tablet
INSERT INTO Product_Variants (product_id, variant_name, color, storage, price, stock_quantity, warranty_months) VALUES
(21, N'iPad Pro 12.9 256GB Xám', N'Xám', '256GB', 29990000, 8, 12),
(21, N'iPad Pro 12.9 512GB Bạc', N'Bạc', '512GB', 34990000, 5, 12),
(22, N'iPad Air M2 256GB Xanh', N'Xanh', '256GB', 18990000, 12, 12),
(23, N'Galaxy Tab S9 256GB Đen', N'Đen', '256GB', 19990000, 10, 12),
(24, N'Galaxy Tab S9 FE 128GB Xám', N'Xám', '128GB', 11990000, 15, 12),
(25, N'Xiaomi Pad 6 Pro 256GB Đen', N'Đen', '256GB', 10990000, 12, 12),
(26, N'OPPO Pad 2 256GB Xám', N'Xám', '256GB', 12990000, 8, 12),
(27, N'OnePlus Pad 128GB Xanh', N'Xanh', '128GB', 11990000, 10, 12),
(28, N'Lenovo Tab P12 Pro 256GB Xám', N'Xám', '256GB', 15990000, 6, 12),
(29, N'Huawei MatePad Pro 13.2 256GB Đen', N'Đen', '256GB', 22990000, 5, 12),
(30, N'Surface Pro 9 256GB Bạc', N'Bạc', '256GB', 27990000, 4, 12),
(31, N'Realme Pad 2 128GB Xám', N'Xám', '128GB', 6990000, 20, 12),
(32, N'Amazon Fire Max 11 64GB Xám', N'Xám', '64GB', 5990000, 15, 12);

-- Product_Variants - Đồng hồ thông minh
INSERT INTO Product_Variants (product_id, variant_name, color, storage, price, stock_quantity, warranty_months) VALUES
(33, N'Apple Watch Series 9 45mm Đen', N'Đen', '45mm', 10990000, 15, 12),
(33, N'Apple Watch Series 9 41mm Bạc', N'Bạc', '41mm', 9990000, 12, 12),
(34, N'Apple Watch Ultra 2 49mm Titan', N'Titan', '49mm', 21990000, 5, 12),
(35, N'Galaxy Watch 6 Classic 47mm Đen', N'Đen', '47mm', 9990000, 10, 12),
(36, N'Xiaomi Watch S3 46mm Đen', N'Đen', '46mm', 3990000, 20, 12),
(37, N'Huawei Watch GT 4 46mm Nâu', N'Nâu', '46mm', 5990000, 15, 12),
(38, N'OnePlus Watch 2 46mm Đen', N'Đen', '46mm', 7990000, 8, 12),
(39, N'Garmin Forerunner 265 Đen', N'Đen', '', 10990000, 6, 12),
(40, N'Amazfit GTR 4 46mm Đen', N'Đen', '46mm', 4990000, 18, 12),
(41, N'TicWatch Pro 5 Đen', N'Đen', '', 8990000, 7, 12),
(42, N'Fitbit Charge 6 Đen', N'Đen', '', 3990000, 25, 12),
(43, N'Fossil Gen 6 44mm Nâu', N'Nâu', '44mm', 6990000, 10, 12);


-- Product_Variants - Laptop
INSERT INTO Product_Variants (product_id, variant_name, color, storage, price, stock_quantity, warranty_months) VALUES
(44, N'MacBook Pro 14 M3 512GB Xám', N'Xám', '512GB', 49990000, 5, 24),
(44, N'MacBook Pro 14 M3 1TB Bạc', N'Bạc', '1TB', 59990000, 3, 24),
(45, N'Dell XPS 13 Plus i7 512GB Bạc', N'Bạc', '512GB', 39990000, 4, 24),
(46, N'HP Spectre x360 14 i7 512GB Đen', N'Đen', '512GB', 35990000, 5, 24),
(47, N'ThinkPad X1 Carbon i7 512GB Đen', N'Đen', '512GB', 42990000, 4, 24),
(48, N'ROG Zephyrus G14 RTX4060 Trắng', N'Trắng', '512GB', 38990000, 6, 24),
(49, N'Acer Swift X 14 RTX4050 Xám', N'Xám', '512GB', 28990000, 8, 24),
(50, N'Surface Laptop 5 i7 512GB Bạc', N'Bạc', '512GB', 32990000, 5, 24),
(51, N'Galaxy Book3 Pro i7 512GB Xám', N'Xám', '512GB', 34990000, 4, 24),
(52, N'LG Gram 17 i7 512GB Trắng', N'Trắng', '512GB', 36990000, 3, 24),
(53, N'Razer Blade 14 RTX4070 Đen', N'Đen', '1TB', 55990000, 2, 24);

-- Product_Variants - Tai nghe
INSERT INTO Product_Variants (product_id, variant_name, color, storage, price, stock_quantity, warranty_months) VALUES
(54, N'AirPods Pro 2 Trắng', N'Trắng', '', 5990000, 30, 12),
(55, N'AirPods Max Xám', N'Xám', '', 12990000, 8, 12),
(55, N'AirPods Max Xanh', N'Xanh', '', 12990000, 6, 12),
(56, N'Galaxy Buds2 Pro Đen', N'Đen', '', 3990000, 20, 12),
(57, N'Sony WF-1000XM5 Đen', N'Đen', '', 6990000, 12, 12),
(58, N'Sony WH-1000XM5 Đen', N'Đen', '', 7990000, 10, 12),
(59, N'Bose QC Earbuds II Đen', N'Đen', '', 6490000, 8, 12),
(60, N'Jabra Elite 10 Đen', N'Đen', '', 5490000, 10, 12),
(61, N'Nothing Ear 2 Trắng', N'Trắng', '', 3490000, 15, 12),
(62, N'OnePlus Buds Pro 2 Đen', N'Đen', '', 2990000, 18, 12),
(63, N'Xiaomi Buds 4 Pro Đen', N'Đen', '', 2490000, 25, 12),
(64, N'Beats Fit Pro Đen', N'Đen', '', 4990000, 12, 12),
(65, N'Anker Soundcore Liberty 4 Đen', N'Đen', '', 2290000, 20, 12);

-- Product_Variants - Sạc và cáp
INSERT INTO Product_Variants (product_id, variant_name, color, storage, price, stock_quantity, warranty_months) VALUES
(66, N'Sạc nhanh 20W USB-C Trắng', N'Trắng', '', 200000, 100, 6),
(67, N'Sạc Apple 20W USB-C Trắng', N'Trắng', '', 490000, 50, 12),
(68, N'Sạc Samsung 25W Trắng', N'Trắng', '', 390000, 60, 12),
(69, N'Sạc MagSafe Baseus Trắng', N'Trắng', '', 350000, 40, 6),
(70, N'Sạc không dây Samsung 15W Đen', N'Đen', '', 590000, 35, 12),
(71, N'Sạc Anker 65W GaN Trắng', N'Trắng', '', 890000, 25, 12),
(72, N'Sạc đứng Baseus 20W Trắng', N'Trắng', '', 290000, 45, 6),
(73, N'Cáp Lightning Baseus 1m Trắng', N'Trắng', '', 150000, 80, 6),
(74, N'Cáp Xiaomi 67W 1m Trắng', N'Trắng', '', 190000, 60, 6);

-- Product_Variants - Pin dự phòng
INSERT INTO Product_Variants (product_id, variant_name, color, storage, price, stock_quantity, warranty_months) VALUES
(75, N'Anker PowerCore 20000 Đen', N'Đen', '20000mAh', 890000, 30, 18),
(76, N'Xiaomi 20000 Pro Trắng', N'Trắng', '20000mAh', 590000, 40, 12),
(77, N'Samsung 10000 Wireless Hồng', N'Hồng', '10000mAh', 790000, 25, 12),
(78, N'Baseus 20000 65W Đen', N'Đen', '20000mAh', 990000, 20, 12),
(79, N'Romoss 30000 Trắng', N'Trắng', '30000mAh', 490000, 35, 12),
(80, N'UGREEN 20000 100W Xám', N'Xám', '20000mAh', 1290000, 15, 18),
(81, N'Belkin 10000 MagSafe Trắng', N'Trắng', '10000mAh', 1490000, 10, 12),
(82, N'RavPower 20000 60W Đen', N'Đen', '20000mAh', 790000, 20, 12),
(83, N'Mophie Powerstation Đen', N'Đen', '10000mAh', 1190000, 12, 12),
(84, N'Zendure SuperTank 27000 Đen', N'Đen', '27000mAh', 2490000, 5, 24);

-- Product_Variants - Ốp lưng
INSERT INTO Product_Variants (product_id, variant_name, color, storage, price, stock_quantity, warranty_months) VALUES
(85, N'Ốp lưng iPhone 15 Trong suốt', N'Trong suốt', '', 150000, 100, 3),
(86, N'Ốp Spigen iPhone 15 Pro Đen', N'Đen', '', 450000, 40, 6),
(87, N'Ốp Otterbox S24 Ultra Đen', N'Đen', '', 890000, 20, 12),
(88, N'Ốp MagSafe Spigen Đen', N'Đen', '', 550000, 30, 6),
(89, N'Ốp da Apple Nâu', N'Nâu', '', 1490000, 15, 12),
(90, N'Ốp Ringke Fusion Trong suốt', N'Trong suốt', '', 350000, 50, 6),
(91, N'Ốp Caseology Nano Pop Xanh', N'Xanh', '', 390000, 35, 6),
(92, N'Ốp Lifeproof FRE Đen', N'Đen', '', 1890000, 10, 12),
(93, N'Ốp Rhinoshield SolidSuit Đen', N'Đen', '', 690000, 25, 12),
(94, N'Ốp Pela Case Xanh lá', N'Xanh lá', '', 590000, 20, 6);

-- Product_Variants - Camera và phụ kiện
INSERT INTO Product_Variants (product_id, variant_name, color, storage, price, stock_quantity, warranty_months) VALUES
(95, N'GoPro Hero 12 Black Đen', N'Đen', '', 11990000, 8, 12),
(96, N'DJI Osmo Action 4 Đen', N'Đen', '', 9990000, 10, 12),
(97, N'Insta360 X3 Đen', N'Đen', '', 12990000, 6, 12),
(98, N'DJI OM 6 Xám', N'Xám', '', 3490000, 15, 12),
(99, N'Zhiyun Smooth 5 Đen', N'Đen', '', 3990000, 12, 12),
(100, N'Manfrotto Compact Đen', N'Đen', '', 1990000, 20, 12),
(101, N'Neewer Ring Light 18 inch Đen', N'Đen', '', 1490000, 15, 6),
(102, N'Rode VideoMic Me-C Đen', N'Đen', '', 1790000, 10, 12),
(103, N'Moment Wide Lens Đen', N'Đen', '', 2990000, 8, 12),
(104, N'Bộ lọc ND Variable Đen', N'Đen', '', 890000, 12, 6),
(105, N'Logitech C920 Đen', N'Đen', '', 1890000, 18, 24);

-- Product_Variants - Phụ kiện khác
INSERT INTO Product_Variants (product_id, variant_name, color, storage, price, stock_quantity, warranty_months) VALUES
(106, N'JBL Flip 6 Đen', N'Đen', '', 2490000, 20, 12),
(106, N'JBL Flip 6 Đỏ', N'Đỏ', '', 2490000, 15, 12),
(107, N'Logitech MX Keys Đen', N'Đen', '', 2490000, 12, 24),
(108, N'Logitech MX Master 3S Xám', N'Xám', '', 2290000, 15, 24),
(109, N'Hub Baseus 7in1 Xám', N'Xám', '', 890000, 25, 12),
(110, N'Giá đỡ Baseus Đen', N'Đen', '', 290000, 40, 6),
(111, N'Giá đỡ laptop Nulaxy Bạc', N'Bạc', '', 590000, 20, 12),
(112, N'Razer Gigantus V2 XXL Đen', N'Đen', '', 890000, 15, 12),
(113, N'Đèn bàn Baseus Trắng', N'Trắng', '', 490000, 25, 12);


-- 8. Warehouses
INSERT INTO Warehouses (warehouse_name, location, manager_id) VALUES
(N'Kho chính TP.HCM', N'123 Đường Kho, Quận 1, TP.HCM', 1),
(N'Kho phụ Hà Nội', N'456 Đường Kho, Quận Cầu Giấy, Hà Nội', 2),
(N'Kho phụ Đà Nẵng', N'789 Đường Kho, Quận Hải Châu, Đà Nẵng', 3);

-- 9. Order_Status
INSERT INTO Order_Status (status_name, description) VALUES
(N'Chờ xác nhận', N'Đơn hàng mới, chờ xác nhận'),
(N'Đã xác nhận', N'Đơn hàng đã được xác nhận'),
(N'Đang chuẩn bị', N'Đang chuẩn bị hàng'),
(N'Đang giao hàng', N'Đơn hàng đang được giao'),
(N'Đã giao hàng', N'Đã giao hàng thành công'),
(N'Đã hủy', N'Đơn hàng đã bị hủy'),
(N'Hoàn trả', N'Khách hàng đã hoàn trả');

-- 10. Payment_Status
INSERT INTO Payment_Status (status_name, description) VALUES
(N'Chưa thanh toán', N'Chưa thanh toán'),
(N'Đã thanh toán', N'Đã thanh toán thành công'),
(N'Thanh toán một phần', N'Đã thanh toán một phần'),
(N'Hoàn tiền', N'Đã hoàn tiền'),
(N'Thanh toán thất bại', N'Thanh toán không thành công'),
(N'Chờ xác nhận', N'Chờ xác nhận từ ngân hàng');

-- 11. Customers
INSERT INTO Customers (full_name, phone_number, email, address, gender, date_of_birth) VALUES
(N'Nguyễn Văn Khách', '0909999999', 'khach1@email.com', N'123 Đường Khách, TP.HCM', 'Nam', '1990-01-15'),
(N'Trần Thị Mua', '0908888888', 'khach2@email.com', N'456 Đường Mua, TP.HCM', N'Nữ', '1995-05-20'),
(N'Lê Văn Điện Thoại', '0907777777', 'khach3@email.com', N'789 Đường Điện, Hà Nội', 'Nam', '1988-11-10'),
(N'Phạm Thị Smartphone', '0906666666', 'khach4@email.com', N'321 Đường Smart, Đà Nẵng', N'Nữ', '1992-03-25'),
(N'Hoàng Văn Mua Hàng', '0905555555', 'khach5@email.com', N'654 Đường Mua, Hải Phòng', 'Nam', '1985-07-12');

-- 12. Promotions
INSERT INTO Promotions (promotion_name, discount_percent, start_date, end_date, description) VALUES
(N'Khuyến mãi tháng 12', 10.00, '2024-12-01', '2024-12-31', N'Giảm 10% cho tất cả sản phẩm'),
(N'Giáng sinh vui vẻ', 15.00, '2024-12-20', '2024-12-26', N'Giảm 15% mừng Giáng sinh'),
(N'Năm mới 2025', 20.00, '2024-12-28', '2025-01-05', N'Giảm 20% chào năm mới'),
(N'Khuyến mãi iPhone', 5.00, '2024-12-01', '2025-01-31', N'Giảm 5% cho tất cả iPhone'),
(N'Khuyến mãi Samsung', 8.00, '2024-12-01', '2025-01-31', N'Giảm 8% cho sản phẩm Samsung');

-- 13. Orders
INSERT INTO Orders (customer_id, employee_id, total_amount, order_status_id, payment_method, note) VALUES
(1, 1, 32990000, 5, N'Tiền mặt', N'Khách hàng mua trực tiếp tại cửa hàng'),
(2, 2, 21990000, 4, N'Chuyển khoản', N'Đơn hàng online'),
(3, 1, 26990000, 5, N'Thẻ tín dụng', N'Đơn hàng online'),
(4, 3, 5990000, 3, N'Tiền mặt', N'Khách hàng mua trực tiếp'),
(5, 2, 44990000, 2, N'Chuyển khoản', N'Đơn hàng online');

-- 14. Order_Details
INSERT INTO Order_Details (order_id, variant_id, quantity, unit_price, discount, subtotal) VALUES
(1, 1, 1, 32990000, 0, 32990000),
(2, 6, 1, 21990000, 0, 21990000),
(3, 11, 1, 26990000, 0, 26990000),
(4, 54, 1, 5990000, 0, 5990000),
(5, 19, 1, 44990000, 0, 44990000);

-- 15. Payments
INSERT INTO Payments (order_id, amount, payment_method, payment_status_id, transaction_code, note) VALUES
(1, 32990000, N'Tiền mặt', 2, 'CASH001', N'Thanh toán tại cửa hàng'),
(2, 21990000, N'Chuyển khoản', 2, 'TRANS001', N'Chuyển khoản ngân hàng'),
(3, 26990000, N'Thẻ tín dụng', 2, 'CARD001', N'Thanh toán bằng thẻ'),
(4, 5990000, N'Tiền mặt', 2, 'CASH002', N'Thanh toán tại cửa hàng'),
(5, 44990000, N'Chuyển khoản', 6, 'TRANS002', N'Chờ xác nhận từ ngân hàng');

-- 16. Warranty_Cards
INSERT INTO Warranty_Cards (order_detail_id, start_date, end_date, status, note) VALUES
(1, '2024-12-01', '2025-12-01', N'Còn hiệu lực', N'Bảo hành chính hãng'),
(2, '2024-12-05', '2025-12-05', N'Còn hiệu lực', N'Bảo hành chính hãng'),
(3, '2024-12-10', '2025-12-10', N'Còn hiệu lực', N'Bảo hành chính hãng');

-- 17. Customer_Feedback
INSERT INTO Customer_Feedback (customer_id, variant_id, rating, comment, feedback_date) VALUES
(1, 1, 5, N'Sản phẩm rất tốt, giao hàng nhanh', '2024-12-02 10:00:00'),
(2, 6, 5, N'iPhone đẹp, chất lượng tốt', '2024-12-06 14:30:00'),
(3, 11, 4, N'Samsung S24 Ultra tuyệt vời, camera đẹp', '2024-12-11 09:15:00'),
(4, 54, 5, N'AirPods Pro 2 âm thanh tuyệt vời', '2024-12-13 16:45:00');

-- 18. Manager_Logs
INSERT INTO Manager_Logs (manager_id, action_type, description, action_time) VALUES
(1, 'LOGIN', N'Đăng nhập hệ thống', '2024-12-01 08:00:00'),
(1, 'CREATE_PRODUCT', N'Tạo sản phẩm mới iPhone 15 Pro Max', '2024-12-01 09:00:00'),
(2, 'LOGIN', N'Đăng nhập hệ thống', '2024-12-01 08:15:00'),
(2, 'UPDATE_ORDER', N'Cập nhật đơn hàng #2', '2024-12-01 10:00:00');

-- 19. Inventory_Receipts
INSERT INTO Inventory_Receipts (supplier_id, employee_id, receipt_date, total_value) VALUES
(1, 1, '2024-11-01 09:00:00', 1000000000),
(2, 2, '2024-11-05 09:00:00', 800000000),
(3, 3, '2024-11-10 09:00:00', 600000000);

-- 20. Receipt_Details
INSERT INTO Receipt_Details (receipt_id, variant_id, quantity, unit_cost, total_cost) VALUES
(1, 1, 10, 30000000, 300000000),
(1, 2, 8, 30000000, 240000000),
(2, 11, 15, 24000000, 360000000),
(3, 21, 20, 17000000, 340000000);

-- 21. Stock_Logs
INSERT INTO Stock_Logs (variant_id, warehouse_id, change_type, quantity, log_date, reference_id) VALUES
(1, 1, 'NHAP_KHO', 10, '2024-11-01 10:00:00', 1),
(2, 1, 'NHAP_KHO', 8, '2024-11-01 10:00:00', 1),
(11, 1, 'NHAP_KHO', 15, '2024-11-05 10:00:00', 2),
(21, 2, 'NHAP_KHO', 20, '2024-11-10 10:00:00', 3),
(1, 1, 'XUAT_KHO', -1, '2024-12-02 14:00:00', 1);

-- 22. Product_Logs
INSERT INTO Product_Logs (variant_id, employee_id, action_type, old_data, new_data, action_date, note) VALUES
(1, 1, 'UPDATE_PRICE', '32000000', '32990000', '2024-12-01 09:00:00', N'Cập nhật giá bán'),
(2, 1, 'UPDATE_STOCK', '10', '12', '2024-12-01 09:30:00', N'Nhập thêm hàng'),
(11, 2, 'UPDATE_PRICE', '26500000', '26990000', '2024-12-02 10:00:00', N'Cập nhật giá bán');

-- 23. Promotion_Details
INSERT INTO Promotion_Details (promotion_id, variant_id, note) VALUES
(1, 1, N'Áp dụng cho iPhone 15 Pro Max'),
(1, 6, N'Áp dụng cho iPhone 15'),
(4, 1, N'Khuyến mãi iPhone'),
(4, 4, N'Khuyến mãi iPhone'),
(5, 11, N'Khuyến mãi Samsung'),
(5, 14, N'Khuyến mãi Samsung');

-- 24. Employee_Roles
INSERT INTO Employee_Roles (employee_id, role_id, assigned_at) VALUES
(1, 4, '2024-01-01 08:00:00'),
(2, 4, '2024-01-01 08:00:00'),
(3, 3, '2024-01-01 08:00:00');


-- 25. Product_Reviews (bảng đánh giá sản phẩm cho ReviewModel)
CREATE TABLE IF NOT EXISTS Product_Reviews (
  review_id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  customer_id INT NOT NULL,
  rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
  comment TEXT,
  status VARCHAR(20) DEFAULT 'pending',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE,
  FOREIGN KEY (customer_id) REFERENCES Customers(customer_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm một số đánh giá mẫu
INSERT INTO Product_Reviews (product_id, customer_id, rating, comment, status, created_at) VALUES
(1, 1, 5, N'Sản phẩm rất tốt, giao hàng nhanh, đóng gói cẩn thận', 'approved', '2024-12-02 10:00:00'),
(1, 2, 5, N'iPhone 15 Pro Max quá đẹp, camera chụp ảnh rất đẹp', 'approved', '2024-12-03 14:30:00'),
(1, 3, 4, N'Sản phẩm chất lượng, giá hơi cao', 'approved', '2024-12-04 09:15:00'),
(3, 4, 5, N'iPhone 15 rất đáng mua, pin trâu', 'approved', '2024-12-05 16:45:00'),
(5, 5, 5, N'Samsung S24 Ultra camera zoom 100x quá đỉnh', 'approved', '2024-12-06 11:20:00'),
(5, 1, 4, N'Màn hình đẹp, hiệu năng mạnh', 'approved', '2024-12-07 13:30:00'),
(10, 2, 5, N'Xiaomi 14 Pro giá tốt, cấu hình cao', 'approved', '2024-12-08 15:00:00'),
(33, 3, 5, N'Apple Watch Series 9 theo dõi sức khỏe rất tốt', 'approved', '2024-12-09 10:45:00'),
(54, 4, 5, N'AirPods Pro 2 chống ồn tuyệt vời', 'approved', '2024-12-10 14:15:00'),
(44, 5, 4, N'MacBook Pro M3 hiệu năng khủng, pin lâu', 'approved', '2024-12-11 16:30:00');

-- 27. BẢNG COUPONS (Mã giảm giá)
CREATE TABLE IF NOT EXISTS coupons (
    coupon_id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    description VARCHAR(255),
    discount_type ENUM('percentage', 'fixed') NOT NULL DEFAULT 'percentage',
    discount_value DECIMAL(15, 2) NOT NULL,
    min_order_amount DECIMAL(15, 2) DEFAULT 0,
    max_discount_amount DECIMAL(15, 2) DEFAULT NULL,
    usage_limit INT DEFAULT NULL,
    used_count INT DEFAULT 0,
    start_date DATETIME DEFAULT NULL,
    end_date DATETIME DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS coupon_usage (
    usage_id INT AUTO_INCREMENT PRIMARY KEY,
    coupon_id INT NOT NULL,
    customer_id INT NOT NULL,
    order_id INT NOT NULL,
    discount_amount DECIMAL(15, 2) NOT NULL,
    used_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (coupon_id) REFERENCES coupons(coupon_id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm cột coupon vào bảng orders (bỏ qua nếu đã tồn tại)
-- Chạy từng lệnh riêng, bỏ qua lỗi nếu cột đã tồn tại
ALTER TABLE Orders ADD COLUMN coupon_id INT DEFAULT NULL;
ALTER TABLE Orders ADD COLUMN discount_amount DECIMAL(15, 2) DEFAULT 0;

-- Mã giảm giá mẫu
INSERT INTO coupons (code, description, discount_type, discount_value, min_order_amount, max_discount_amount, usage_limit, start_date, end_date) VALUES
('WELCOME10', 'Giảm 10% cho khách hàng mới', 'percentage', 10, 500000, 200000, 100, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY)),
('SALE50K', 'Giảm 50.000đ cho đơn từ 1 triệu', 'fixed', 50000, 1000000, NULL, 50, NOW(), DATE_ADD(NOW(), INTERVAL 15 DAY)),
('FREESHIP', 'Giảm 30.000đ phí ship', 'fixed', 30000, 300000, NULL, NULL, NOW(), DATE_ADD(NOW(), INTERVAL 60 DAY)),
('VIP20', 'Giảm 20% cho khách VIP', 'percentage', 20, 2000000, 500000, 20, NOW(), DATE_ADD(NOW(), INTERVAL 90 DAY));