<?php
/**
 * Script để tổ chức lại dự án thành backend và frontend
 */

$baseDir = __DIR__;

// Tạo thư mục backend
$backendDirs = [
    'backend/Controllers',
    'backend/Models',
    'backend/config',
    'backend/admin',
    'backend/api',
    'backend/Views/admin'
];

// Tạo thư mục frontend
$frontendDirs = [
    'frontend/public',
    'frontend/Views/home',
    'frontend/Views/product',
    'frontend/Views/cart',
    'frontend/Views/order',
    'frontend/Views/auth',
    'frontend/Views/layouts',
    'frontend/assets/css',
    'frontend/assets/js',
    'frontend/assets/images',
    'frontend/auth'
];

// Tạo các thư mục
foreach (array_merge($backendDirs, $frontendDirs) as $dir) {
    $fullPath = $baseDir . '/' . $dir;
    if (!is_dir($fullPath)) {
        mkdir($fullPath, 0755, true);
        echo "Created: $dir\n";
    }
}

echo "Thư mục đã được tạo!\n";
echo "Bây giờ bạn cần di chuyển các file thủ công hoặc chạy script tiếp theo.\n";

