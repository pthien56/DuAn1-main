<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="bi bi-pencil me-2"></i>Sửa Mã Giảm Giá: <span class="text-danger"><?= htmlspecialchars($coupon['code']) ?></span>
        </h4>
        <a href="<?= BASE_URL ?>admin/coupons" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="<?= BASE_URL ?>admin/couponEdit/<?= $coupon['coupon_id'] ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Mã giảm giá <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control form-control-lg text-uppercase" 
                               value="<?= htmlspecialchars($coupon['code']) ?>" required maxlength="50"
                               style="letter-spacing: 2px; font-weight: bold;">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Mô tả</label>
                        <input type="text" name="description" class="form-control form-control-lg" 
                               value="<?= htmlspecialchars($coupon['description'] ?? '') ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Loại giảm giá <span class="text-danger">*</span></label>
                        <select name="discount_type" class="form-select form-select-lg" id="discount_type" required>
                            <option value="percentage" <?= $coupon['discount_type'] === 'percentage' ? 'selected' : '' ?>>Phần trăm (%)</option>
                            <option value="fixed" <?= $coupon['discount_type'] === 'fixed' ? 'selected' : '' ?>>Số tiền cố định (₫)</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Giá trị giảm <span class="text-danger">*</span></label>
                        <div class="input-group input-group-lg">
                            <input type="number" name="discount_value" class="form-control" 
                                   value="<?= $coupon['discount_value'] ?>" required min="0" step="0.01">
                            <span class="input-group-text" id="discount_unit"><?= $coupon['discount_type'] === 'percentage' ? '%' : '₫' ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" id="max_discount_group" style="<?= $coupon['discount_type'] === 'fixed' ? 'display:none;' : '' ?>">
                        <label class="form-label fw-bold">Giảm tối đa</label>
                        <div class="input-group input-group-lg">
                            <input type="number" name="max_discount_amount" class="form-control" 
                                   value="<?= $coupon['max_discount_amount'] ?>" min="0">
                            <span class="input-group-text">₫</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Đơn hàng tối thiểu</label>
                        <div class="input-group input-group-lg">
                            <input type="number" name="min_order_amount" class="form-control" 
                                   value="<?= $coupon['min_order_amount'] ?>" min="0">
                            <span class="input-group-text">₫</span>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Giới hạn sử dụng</label>
                        <input type="number" name="usage_limit" class="form-control form-control-lg" 
                               value="<?= $coupon['usage_limit'] ?>" min="1">
                        <small class="text-muted">Đã sử dụng: <strong><?= $coupon['used_count'] ?></strong> lần</small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Trạng thái</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                                   <?= $coupon['is_active'] ? 'checked' : '' ?> style="width: 3em; height: 1.5em;">
                            <label class="form-check-label ms-2" for="is_active">Kích hoạt</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Ngày bắt đầu</label>
                        <input type="datetime-local" name="start_date" class="form-control form-control-lg"
                               value="<?= $coupon['start_date'] ? date('Y-m-d\TH:i', strtotime($coupon['start_date'])) : '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Ngày kết thúc</label>
                        <input type="datetime-local" name="end_date" class="form-control form-control-lg"
                               value="<?= $coupon['end_date'] ? date('Y-m-d\TH:i', strtotime($coupon['end_date'])) : '' ?>">
                    </div>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-danger btn-lg">
                        <i class="bi bi-check-lg me-1"></i> Cập Nhật
                    </button>
                    <a href="<?= BASE_URL ?>admin/coupons" class="btn btn-outline-secondary btn-lg">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('discount_type').addEventListener('change', function() {
    var unit = document.getElementById('discount_unit');
    var maxGroup = document.getElementById('max_discount_group');
    
    if (this.value === 'percentage') {
        unit.textContent = '%';
        maxGroup.style.display = 'block';
    } else {
        unit.textContent = '₫';
        maxGroup.style.display = 'none';
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
