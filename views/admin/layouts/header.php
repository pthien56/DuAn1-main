<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' : '' ?>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/admin.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a class="sidebar-brand" href="<?= BASE_URL ?>admin/dashboard">
                <i class="bi bi-speedometer2"></i>
                <span class="brand-text">Admin Panel</span>
            </a>
        </div>
        <ul class="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>admin/dashboard">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>admin/products">
                    <i class="bi bi-box"></i>
                    <span>Sản Phẩm</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>admin/categories">
                    <i class="bi bi-tag"></i>
                    <span>Danh Mục</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>admin/customers">
                    <i class="bi bi-people"></i>
                    <span>Khách Hàng</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>admin/orders">
                    <i class="bi bi-receipt"></i>
                    <span>Đơn Hàng</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>admin/reviews">
                    <i class="bi bi-star"></i>
                    <span>Đánh Giá</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>admin/coupons">
                    <i class="bi bi-ticket-perforated"></i>
                    <span>Mã Giảm Giá</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>admin/posts">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Bài Viết</span>
                </a>
            </li>
        </ul>
        <div class="sidebar-footer">
            <a class="nav-link" href="<?= BASE_URL ?>home/index">
                <i class="bi bi-house"></i>
                <span>Trang Chủ</span>
            </a>
            <a class="nav-link" href="<?= BASE_URL ?>auth/logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Đăng Xuất</span>
            </a>
        </div>
    </div>

    <!-- Top Bar -->
    <nav class="topbar navbar-dark bg-dark">
        <div class="topbar-left">
            <button class="btn btn-toggle" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
        </div>
        <div class="topbar-right">
            <div class="user-info-top">
                <i class="bi bi-person-circle"></i>
                <span><?= htmlspecialchars($_SESSION['admin_name']) ?></span>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

