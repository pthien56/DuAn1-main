<?php require_once __DIR__ . '/header.php'; ?>

<main>
    <div class="container">
        <div class="login-form">
            <h2>Đăng nhập</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label>Loại tài khoản:</label>
                    <select name="user_type" class="form-control" required>
                        <option value="customer">Khách hàng</option>
                        <option value="admin">Quản trị viên</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tên đăng nhập / Số điện thoại / Email:</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Mật khẩu:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
            </form>
            <p class="text-center">
                <a href="<?php echo baseUrl('auth/register.php'); ?>">Chưa có tài khoản? Đăng ký ngay</a>
            </p>
            <p class="text-center">
                <a href="<?php echo baseUrl('index.php'); ?>">Về trang chủ</a>
            </p>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>

