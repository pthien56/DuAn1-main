<?php
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<header class="header">
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <a href="index.php">
                    <h1>📱 Phone Store</h1>
                </a>
            </div>
            <nav class="main-nav">
                <a href="index.php">Trang chủ</a>
                <a href="products.php">Sản phẩm</a>
                <?php if (isLoggedIn()): ?>
                    <a href="orders.php">Đơn hàng của tôi</a>
                    <?php if (isAdmin()): ?>
                        <a href="admin/dashboard.php">Quản trị</a>
                    <?php endif; ?>
                    <a href="cart.php">Giỏ hàng (<?php echo $cart_count; ?>)</a>
                    <a href="auth/logout.php">Đăng xuất</a>
                    <span>Xin chào, <?php echo htmlspecialchars($_SESSION['full_name'] ?? 'User'); ?></span>
                <?php else: ?>
                    <a href="cart.php">Giỏ hàng (<?php echo $cart_count; ?>)</a>
                    <a href="auth/login.php">Đăng nhập</a>
                    <a href="auth/register.php">Đăng ký</a>
                <?php endif; ?>
            </nav>
        </div>
    </div>
</header>

