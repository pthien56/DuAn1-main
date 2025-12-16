<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' : '' ?><?= SITE_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>var BASE_URL = '<?= BASE_URL ?>';</script>
    <style>
        /* Top Bar */
        .top-bar {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            padding: 8px 0;
            font-size: 0.85rem;
        }
        .top-bar a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }
        .top-bar a:hover {
            opacity: 0.8;
        }
        
        /* Main Navbar */
        .main-navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: -1px;
            transition: transform 0.3s;
        }
        .navbar-brand:hover {
            transform: scale(1.05);
        }
        .navbar-brand .text-danger {
            color: #dc3545 !important;
        }
        .navbar-brand .text-dark {
            color: #212529 !important;
        }
        
        .nav-link {
            font-weight: 500;
            color: #333 !important;
            padding: 10px 15px !important;
            transition: all 0.3s;
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 3px;
            background: #dc3545;
            transition: width 0.3s;
        }
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 80%;
        }
        .nav-link:hover {
            color: #dc3545 !important;
        }
        .nav-link.active {
            color: #dc3545 !important;
        }
        
        /* Search Bar */
        .search-container {
            position: relative;
            max-width: 500px;
            width: 100%;
        }
        .search-input-group {
            position: relative;
        }
        .search-input {
            border: 2px solid #e9ecef;
            border-radius: 50px;
            padding: 10px 50px 10px 20px;
            transition: all 0.3s;
        }
        .search-input:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
        }
        .search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        .search-btn:hover {
            background: #c82333;
            transform: translateY(-50%) scale(1.1);
        }
        
        /* Cart Icon */
        .cart-icon {
            position: relative;
            color: #333;
            font-size: 1.5rem;
            transition: all 0.3s;
            padding: 8px;
            border-radius: 50%;
        }
        .cart-icon:hover {
            color: #dc3545;
            background: #fff5f5;
        }
        .cart-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
            border: 2px solid white;
        }
        
        /* User Menu */
        .user-menu {
            position: relative;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #dc3545, #c82333);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }
        .user-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }
        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            border-radius: 10px;
            padding: 10px 0;
            margin-top: 10px;
        }
        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.3s;
        }
        .dropdown-item:hover {
            background: #fff5f5;
            color: #dc3545;
            padding-left: 25px;
        }
        .dropdown-item i {
            width: 20px;
            margin-right: 10px;
        }
        
        /* Mobile Menu */
        .navbar-toggler {
            border: none;
            padding: 5px 10px;
        }
        .navbar-toggler:focus {
            box-shadow: none;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2833, 37, 41, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        @media (max-width: 991px) {
            .search-container {
                max-width: 100%;
                margin: 15px 0;
            }
            .nav-link::after {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar d-none d-md-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-4">
                        <span><i class="bi bi-telephone me-2"></i> Hotline: <a href="tel:1900000000">1900-000-000</a></span>
                        <span><i class="bi bi-envelope me-2"></i> <a href="mailto:info@mivonstore.vn">info@mivonstore.vn</a></span>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div class="d-flex align-items-center justify-content-end gap-3">
                        <a href="#"><i class="bi bi-facebook me-1"></i> Facebook</a>
                        <a href="#"><i class="bi bi-instagram me-1"></i> Instagram</a>
                        <a href="#"><i class="bi bi-youtube me-1"></i> YouTube</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navbar -->
    <nav class="navbar navbar-expand-lg main-navbar">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>home/index">
                <span class="text-danger">MIVON</span><span class="text-dark">STORE</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'index.php' && strpos($_SERVER['REQUEST_URI'], 'home') !== false) ? 'active' : '' ?>" 
                           href="<?= BASE_URL ?>home/index">
                            <i class="bi bi-house me-1"></i> Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], 'product') !== false) ? 'active' : '' ?>" 
                           href="<?= BASE_URL ?>product/index">
                            <i class="bi bi-shop me-1"></i> Sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], 'about') !== false) ? 'active' : '' ?>" 
                           href="<?= BASE_URL ?>page/about">
                            <i class="bi bi-info-circle me-1"></i> Giới thiệu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], 'contact') !== false) ? 'active' : '' ?>" 
                           href="<?= BASE_URL ?>page/contact">
                            <i class="bi bi-envelope me-1"></i> Liên hệ
                        </a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center gap-3">
                    <!-- Search -->
                    <form class="search-container" action="<?= BASE_URL ?>product/search" method="GET">
                        <div class="search-input-group">
                            <input type="text" name="keyword" class="form-control search-input" 
                                   placeholder="Tìm kiếm sản phẩm..." 
                                   value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                            <button class="search-btn" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Cart -->
                    <a class="cart-icon text-decoration-none" href="<?= BASE_URL ?>cart/index">
                        <i class="bi bi-cart3"></i>
                        <span class="cart-badge" id="cart-count">
                            <?php
                            try {
                                require_once __DIR__ . '/../../models/CartModel.php';
                                $cartModel = new CartModel();
                                echo $cartModel->getCartCount();
                            } catch (Exception $e) {
                                echo 0;
                            }
                            ?>
                        </span>
                    </a>
                    
                    <!-- User Menu -->
                    <?php if (isset($_SESSION['customer_id'])): ?>
                        <div class="user-menu dropdown">
                            <a class="user-avatar text-decoration-none" href="#" id="customerMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= strtoupper(mb_substr($_SESSION['customer_name'] ?? 'U', 0, 1)) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="customerMenu">
                                <li>
                                    <h6 class="dropdown-header">
                                        <i class="bi bi-person-circle me-2"></i>
                                        <?= htmlspecialchars($_SESSION['customer_name'] ?? 'Khách hàng') ?>
                                    </h6>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="<?= BASE_URL ?>customer/profile">
                                        <i class="bi bi-person"></i> Tài Khoản
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= BASE_URL ?>customer/orders">
                                        <i class="bi bi-bag"></i> Đơn Hàng
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="<?= BASE_URL ?>auth/logout">
                                        <i class="bi bi-box-arrow-right"></i> Đăng Xuất
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a class="btn btn-outline-danger" href="<?= BASE_URL ?>auth/login">
                            <i class="bi bi-person me-1"></i> Đăng nhập
                        </a>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['admin_id'])): ?>
                        <a class="btn btn-danger btn-sm" href="<?= BASE_URL ?>admin/dashboard">
                            <i class="bi bi-shield-check me-1"></i> Admin
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Alert Messages -->
    <div class="container mt-3">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <?= $_SESSION['success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>
