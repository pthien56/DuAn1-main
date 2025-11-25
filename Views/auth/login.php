<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">Đăng nhập</h2>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Tên đăng nhập / Số điện thoại / Email <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control" placeholder="Nhập username, email hoặc số điện thoại" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
                                <small class="form-text text-muted">Admin: nhập mật khẩu chính xác | Khách hàng: nhập bất kỳ</small>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3">Đăng nhập</button>
                        </form>
                        <div class="text-center">
                            <p class="mb-2">
                                <a href="<?php echo baseUrl('auth/register.php'); ?>" class="text-decoration-none">Chưa có tài khoản? Đăng ký ngay</a>
                            </p>
                            <p class="mb-0">
                                <a href="<?php echo baseUrl('index.php'); ?>" class="text-decoration-none">Về trang chủ</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>