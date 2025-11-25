<?php require_once __DIR__ . '/helpers.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'MIVON - Cửa hàng Điện thoại'; ?></title>
    <link rel="stylesheet" href="<?php echo assetUrl('css/style.css'); ?>">
    <?php if (isset($admin) && $admin): ?>
    <link rel="stylesheet" href="<?php echo assetUrl('css/admin.css'); ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <span>Trang chủ - T</span>
        </div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="<?php echo baseUrl('index.php'); ?>">
                        <span class="logo-orange">MIVON</span>
                    </a>
                </div>
                <nav class="main-nav">
                    <a href="<?php echo baseUrl('index.php'); ?>" class="nav-link active">Trang chủ</a>
                    <a href="<?php echo baseUrl('products.php'); ?>" class="nav-link">Sản phẩm</a>
                    <a href="#" class="nav-link">Giới thiệu</a>
                    <a href="#" class="nav-link">Liên hệ</a>
                </nav>
                <div class="header-actions">
                    <div class="search-box">
                        <input type="text" placeholder="Tìm kiếm điện thoại..." class="search-input">
                        <button class="search-btn"><i class="fas fa-search"></i></button>
                    </div>
                    <a href="<?php echo baseUrl('cart.php'); ?>" class="cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <?php if (getCartCount() > 0): ?>
                            <span class="cart-badge"><?php echo getCartCount(); ?></span>
                        <?php endif; ?>
                    </a>
                    <?php if (isLoggedIn()): ?>
                        <a href="<?php echo baseUrl('orders.php'); ?>" class="user-icon">
                            <i class="fas fa-user"></i>
                        </a>
                        <a href="<?php echo baseUrl('auth/logout.php'); ?>" class="logout-link">Đăng xuất</a>
                    <?php else: ?>
                        <a href="<?php echo baseUrl('auth/login.php'); ?>" class="user-icon">
                            <i class="fas fa-user"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
