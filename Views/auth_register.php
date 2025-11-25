<?php require_once __DIR__ . '/header.php'; ?>

<main>
    <div class="container">
        <div class="login-form">
            <h2>Đăng ký tài khoản</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label>Họ và tên *</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Số điện thoại *</label>
                    <input type="tel" name="phone_number" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Địa chỉ</label>
                    <input type="text" name="address" class="form-control">
                </div>
                <div class="form-group">
                    <label>Giới tính</label>
                    <select name="gender" class="form-control">
                        <option value="">Chọn giới tính</option>
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                        <option value="Khác">Khác</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Ngày sinh</label>
                    <input type="date" name="date_of_birth" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Đăng ký</button>
            </form>
            <p class="text-center">
                <a href="<?php echo baseUrl('auth/login.php'); ?>">Đã có tài khoản? Đăng nhập ngay</a>
            </p>
            <p class="text-center">
                <a href="<?php echo baseUrl('index.php'); ?>">Về trang chủ</a>
            </p>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>

