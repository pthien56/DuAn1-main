<?php
/**
 * Script để copy các file vào cấu trúc backend và frontend
 */

$baseDir = __DIR__;

// Mapping các file cần copy
$backendFiles = [
    // Controllers
    'Controllers' => 'backend/Controllers',
    // Models
    'Models' => 'backend/Models',
    // Config (đã tạo, chỉ copy nếu cần override)
    // Admin entry points
    'admin' => 'backend/admin',
    // API
    'api' => 'backend/api',
    // Admin Views
    'Views/admin' => 'backend/Views/admin',
    // Old admin views
    'Views/admin_dashboard.php' => 'backend/Views/admin_dashboard.php',
    'Views/admin_products.php' => 'backend/Views/admin_products.php',
    'Views/admin_orders.php' => 'backend/Views/admin_orders.php',
    'Views/admin_order_detail.php' => 'backend/Views/admin_order_detail.php',
];

$frontendFiles = [
    // Public entry points
    'index.php' => 'frontend/public/index.php',
    'products.php' => 'frontend/public/products.php',
    'product-detail.php' => 'frontend/public/product-detail.php',
    'cart.php' => 'frontend/public/cart.php',
    'checkout.php' => 'frontend/public/checkout.php',
    'orders.php' => 'frontend/public/orders.php',
    'order-detail.php' => 'frontend/public/order-detail.php',
    // Auth entry points
    'auth' => 'frontend/auth',
    // Frontend Views
    'Views/home' => 'frontend/Views/home',
    'Views/product' => 'frontend/Views/product',
    'Views/cart' => 'frontend/Views/cart',
    'Views/order' => 'frontend/Views/order',
    'Views/auth' => 'frontend/Views/auth',
    'Views/layouts' => 'frontend/Views/layouts',
    // Old frontend views
    'Views/home_index.php' => 'frontend/Views/home_index.php',
    'Views/product_index.php' => 'frontend/Views/product_index.php',
    'Views/product_detail.php' => 'frontend/Views/product_detail.php',
    'Views/cart_index.php' => 'frontend/Views/cart_index.php',
    'Views/order_index.php' => 'frontend/Views/order_index.php',
    'Views/order_detail.php' => 'frontend/Views/order_detail.php',
    'Views/order_checkout.php' => 'frontend/Views/order_checkout.php',
    'Views/auth_login.php' => 'frontend/Views/auth_login.php',
    'Views/auth_register.php' => 'frontend/Views/auth_register.php',
    'Views/header.php' => 'frontend/Views/header.php',
    'Views/footer.php' => 'frontend/Views/footer.php',
    // Assets
    'assets' => 'frontend/assets',
];

function copyRecursive($src, $dst) {
    if (is_file($src)) {
        $dir = dirname($dst);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        copy($src, $dst);
        return true;
    } elseif (is_dir($src)) {
        if (!is_dir($dst)) {
            mkdir($dst, 0755, true);
        }
        $files = scandir($src);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                copyRecursive($src . '/' . $file, $dst . '/' . $file);
            }
        }
        return true;
    }
    return false;
}

echo "Bắt đầu copy files...\n\n";

// Copy backend files
echo "=== Copying Backend Files ===\n";
foreach ($backendFiles as $src => $dst) {
    $srcPath = $baseDir . '/' . $src;
    $dstPath = $baseDir . '/' . $dst;
    
    if (file_exists($srcPath)) {
        if (copyRecursive($srcPath, $dstPath)) {
            echo "✓ Copied: $src -> $dst\n";
        } else {
            echo "✗ Failed: $src\n";
        }
    } else {
        echo "⚠ Not found: $src\n";
    }
}

echo "\n=== Copying Frontend Files ===\n";
foreach ($frontendFiles as $src => $dst) {
    $srcPath = $baseDir . '/' . $src;
    $dstPath = $baseDir . '/' . $dst;
    
    if (file_exists($srcPath)) {
        if (copyRecursive($srcPath, $dstPath)) {
            echo "✓ Copied: $src -> $dst\n";
        } else {
            echo "✗ Failed: $src\n";
        }
    } else {
        echo "⚠ Not found: $src\n";
    }
}

echo "\n=== Copying Shared Files ===\n";
// Copy shared files (database schema, etc.)
$sharedFiles = [
    'phone_schema.sql' => 'backend/phone_schema.sql',
    'sample_data.sql' => 'backend/sample_data.sql',
    'create_test_accounts.php' => 'backend/create_test_accounts.php',
    'create_test_accounts.sql' => 'backend/create_test_accounts.sql',
];

foreach ($sharedFiles as $src => $dst) {
    $srcPath = $baseDir . '/' . $src;
    $dstPath = $baseDir . '/' . $dst;
    
    if (file_exists($srcPath)) {
        if (copy($srcPath, $dstPath)) {
            echo "✓ Copied: $src -> $dst\n";
        } else {
            echo "✗ Failed: $src\n";
        }
    }
}

echo "\nHoàn thành!\n";
echo "Lưu ý: Bạn cần cập nhật các đường dẫn trong các file đã copy.\n";

