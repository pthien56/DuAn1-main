<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">Đăng ký tài khoản</h2>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" name="full_name" class="form-control" placeholder="Nhập họ và tên đầy đủ" required value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone_number" class="form-control" placeholder="VD: 0901234567" pattern="[0-9]{10,11}" required value="<?php echo isset($_POST['phone_number']) ? htmlspecialchars($_POST['phone_number']) : ''; ?>">
                                    <small class="form-text text-muted">10-11 chữ số</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="example@email.com" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Địa chỉ</label>
                                    <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ (tùy chọn)" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Giới tính</label>
                                    <select name="gender" class="form-select">
                                        <option value="">Chọn giới tính</option>
                                        <option value="Nam" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                                        <option value="Nữ" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                                        <option value="Khác" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Khác') ? 'selected' : ''; ?>>Khác</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ngày sinh</label>
                                    <input type="date" name="date_of_birth" class="form-control" max="<?php echo date('Y-m-d', strtotime('-13 years')); ?>" value="<?php echo isset($_POST['date_of_birth']) ? htmlspecialchars($_POST['date_of_birth']) : ''; ?>">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3">Đăng ký</button>
                        </form>
                        <div class="text-center">
                            <p class="mb-2">
                                <a href="<?php echo baseUrl('auth/login.php'); ?>" class="text-decoration-none">Đã có tài khoản? Đăng nhập ngay</a>
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