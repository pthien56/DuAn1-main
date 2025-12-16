<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white text-center">
                <h4 class="mb-0"><i class="bi bi-shield-lock me-2"></i> Đăng Nhập Admin</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= BASE_URL ?>auth/adminLogin">
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên Đăng Nhập</label>
                        <input type="text" class="form-control" id="username" name="username" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật Khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Đăng Nhập
                    </button>
                </form>
                <div class="mt-3 text-center">
                    <a href="<?= BASE_URL ?>home/index" class="text-muted small">← Về Trang Chủ</a>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <div class="alert alert-info">
                <small>
                    <strong>Thông tin đăng nhập mặc định:</strong><br>
                    Username: admin<br>
                    Password: password
                </small>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

