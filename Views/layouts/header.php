<?php require_once __DIR__ . '/../helpers.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Cửa hàng Điện thoại'; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS (minimal) -->
    <link rel="stylesheet" href="<?php echo assetUrl('css/style.css'); ?>">
    <?php if (isset($admin) && $admin): ?>
    <link rel="stylesheet" href="<?php echo assetUrl('css/admin.css'); ?>">
    <?php endif; ?>
</head>
<body>
    <header class="bg-white shadow-sm sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <div class="container">
                <a class="navbar-brand fw-bold text-warning fs-3" href="<?php echo baseUrl('index.php'); ?>">
                    📱 Phone Store
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo baseUrl('index.php'); ?>">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo baseUrl('products.php'); ?>">Sản phẩm</a>
                        </li>
                        <?php if (isLoggedIn()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo baseUrl('orders.php'); ?>">Đơn hàng của tôi</a>
                            </li>
                            <?php if (isAdmin()): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo baseUrl('admin/dashboard.php'); ?>">Quản trị</a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="<?php echo baseUrl('cart.php'); ?>">
                                <i class="fas fa-shopping-cart"></i> Giỏ hàng
                                <?php if (getCartCount() > 0): ?>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        <?php echo getCartCount(); ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <?php if (isLoggedIn()): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['full_name'] ?? 'User'); ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="<?php echo baseUrl('auth/logout.php'); ?>">Đăng xuất</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo baseUrl('auth/login.php'); ?>">Đăng nhập</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo baseUrl('auth/register.php'); ?>">Đăng ký</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>