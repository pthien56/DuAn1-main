<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4 mb-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-person-circle" style="font-size: 4rem; color: #0d6efd;"></i>
                    <h5 class="mt-3"><?= htmlspecialchars($customer['full_name'] ?? 'Khách hàng') ?></h5>
                    <p class="text-muted small"><?= htmlspecialchars($customer['email'] ?? '') ?></p>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?= BASE_URL ?>customer/profile" class="list-group-item list-group-item-action active">
                        <i class="bi bi-person me-2"></i> Thông Tin Tài Khoản
                    </a>
                    <a href="<?= BASE_URL ?>customer/orders" class="list-group-item list-group-item-action">
                        <i class="bi bi-bag me-2"></i> Đơn Hàng Của Tôi
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person-gear me-2"></i> Thông Tin Tài Khoản</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>customer/profile">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Họ và Tên <span class="text-danger">*</span></label>
                                <input type="text" name="full_name" class="form-control" 
                                       value="<?= htmlspecialchars($customer['full_name'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số Điện Thoại <span class="text-danger">*</span></label>
                                <input type="tel" name="phone_number" class="form-control" 
                                       value="<?= htmlspecialchars($customer['phone_number'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" 
                                       value="<?= htmlspecialchars($customer['email'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Giới Tính</label>
                                <select name="gender" class="form-select">
                                    <option value="">Chọn giới tính</option>
                                    <option value="Nam" <?= ($customer['gender'] ?? '') == 'Nam' ? 'selected' : '' ?>>Nam</option>
                                    <option value="Nữ" <?= ($customer['gender'] ?? '') == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                                    <option value="Khác" <?= ($customer['gender'] ?? '') == 'Khác' ? 'selected' : '' ?>>Khác</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Ngày Sinh</label>
                                <input type="date" name="date_of_birth" class="form-control" 
                                       value="<?= $customer['date_of_birth'] ?? '' ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Địa Chỉ <span class="text-danger">*</span></label>
                                <input type="text" name="address" class="form-control" 
                                       value="<?= htmlspecialchars($customer['address'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= BASE_URL ?>home/index" class="btn btn-secondary">Hủy</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i> Cập Nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

