-- Script tạo tài khoản test cho hệ thống
-- Chạy file này trong MySQL để tạo tài khoản admin và customer

USE inventory_system;

-- Tạo tài khoản Admin để test
-- Username: testadmin
-- Password: admin123
INSERT INTO Managers (username, password, full_name, phone_number, email, role, status) 
VALUES (
    'testadmin', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    'Admin Test', 
    '0912345678', 
    'testadmin@test.com', 
    'admin', 
    'active'
)
ON DUPLICATE KEY UPDATE 
    password = VALUES(password),
    full_name = VALUES(full_name),
    phone_number = VALUES(phone_number),
    email = VALUES(email),
    role = VALUES(role),
    status = VALUES(status);

-- Tạo tài khoản Customer để test
-- Đăng nhập bằng: testcustomer@test.com hoặc 0987654321
INSERT INTO Customers (full_name, phone_number, email, address, gender, date_of_birth) 
VALUES (
    'Customer Test', 
    '0987654321', 
    'testcustomer@test.com', 
    '123 Đường Test, TP.HCM', 
    'Nam', 
    '1995-01-01'
)
ON DUPLICATE KEY UPDATE 
    full_name = VALUES(full_name),
    phone_number = VALUES(phone_number),
    email = VALUES(email),
    address = VALUES(address),
    gender = VALUES(gender),
    date_of_birth = VALUES(date_of_birth);

-- Thông tin đăng nhập:
-- ====================
-- ADMIN:
--   Username: testadmin
--   Password: admin123
-- 
-- CUSTOMER:
--   Email: testcustomer@test.com
--   Hoặc Số điện thoại: 0987654321
--   Password: (không cần, chỉ cần email/phone)
-- ====================

