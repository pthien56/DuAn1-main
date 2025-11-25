<?php
/**
 * Script tạo tài khoản test cho hệ thống
 * Chạy file này một lần để tạo tài khoản admin và customer
 */

require_once 'bootstrap.php';

use App\Models\Database;

try {
    $db = Database::getInstance();
    
    echo "Đang tạo tài khoản test...\n\n";
    
    // Tạo tài khoản Admin
    $adminPassword = password_hash('admin123', PASSWORD_BCRYPT);
    $adminSql = "INSERT INTO Managers (username, password, full_name, phone_number, email, role, status) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE 
                    password = VALUES(password),
                    full_name = VALUES(full_name),
                    phone_number = VALUES(phone_number),
                    email = VALUES(email),
                    role = VALUES(role),
                    status = VALUES(status)";
    
    $adminParams = ['testadmin', $adminPassword, 'Admin Test', '0912345678', 'testadmin@test.com', 'admin', 'active'];
    $db->query($adminSql, $adminParams, "sssssss");
    
    echo "✓ Đã tạo/cập nhật tài khoản ADMIN\n";
    echo "  Username: testadmin\n";
    echo "  Password: admin123\n\n";
    
    // Tạo tài khoản Customer
    $customerSql = "INSERT INTO Customers (full_name, phone_number, email, address, gender, date_of_birth) 
                     VALUES (?, ?, ?, ?, ?, ?)
                     ON DUPLICATE KEY UPDATE 
                        full_name = VALUES(full_name),
                        phone_number = VALUES(phone_number),
                        email = VALUES(email),
                        address = VALUES(address),
                        gender = VALUES(gender),
                        date_of_birth = VALUES(date_of_birth)";
    
    $customerParams = ['Customer Test', '0987654321', 'testcustomer@test.com', '123 Đường Test, TP.HCM', 'Nam', '1995-01-01'];
    $db->query($customerSql, $customerParams, "ssssss");
    
    echo "✓ Đã tạo/cập nhật tài khoản CUSTOMER\n";
    echo "  Email: testcustomer@test.com\n";
    echo "  Số điện thoại: 0987654321\n";
    echo "  (Đăng nhập bằng email hoặc số điện thoại, không cần password)\n\n";
    
    echo "========================================\n";
    echo "THÔNG TIN ĐĂNG NHẬP:\n";
    echo "========================================\n";
    echo "ADMIN:\n";
    echo "  Username: testadmin\n";
    echo "  Password: admin123\n\n";
    echo "CUSTOMER:\n";
    echo "  Email: testcustomer@test.com\n";
    echo "  Hoặc Số điện thoại: 0987654321\n";
    echo "  Password: (không cần, chỉ cần email/phone)\n";
    echo "========================================\n";
    
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage() . "\n";
    echo "Vui lòng kiểm tra kết nối database và thử lại.\n";
}

