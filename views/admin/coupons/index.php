<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="bi bi-ticket-perforated me-2"></i>Quản Lý Mã Giảm Giá
        </h4>
        <a href="<?= BASE_URL ?>admin/couponCreate" class="btn btn-danger">
            <i class="bi bi-plus-lg me-1"></i> Thêm Mã Giảm Giá
        </a>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Mã</th>
                            <th>Mô tả</th>
                            <th>Loại giảm</th>
                            <th>Giá trị</th>
                            <th>Đơn tối thiểu</th>
                            <th>Đã dùng</th>
                            <th>Thời hạn</th>
                            <th>Trạng thái</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($coupons)): ?>
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Chưa có mã giảm giá nào
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($coupons as $coupon): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-primary fs-6"><?= htmlspecialchars($coupon['code']) ?></span>
                                    </td>
                                    <td>
                                        <small><?= htmlspecialchars($coupon['description'] ?: '-') ?></small>
                                    </td>
                                    <td>
                                        <?php if ($coupon['discount_type'] === 'percentage'): ?>
                                            <span class="badge bg-info">Phần trăm</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Cố định</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($coupon['discount_type'] === 'percentage'): ?>
                                            <strong><?= $coupon['discount_value'] ?>%</strong>
                                            <?php if ($coupon['max_discount_amount']): ?>
                                                <br><small class="text-muted">Tối đa: <?= number_format($coupon['max_discount_amount'], 0, ',', '.') ?>₫</small>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <strong><?= number_format($coupon['discount_value'], 0, ',', '.') ?>₫</strong>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($coupon['min_order_amount'] > 0): ?>
                                            <?= number_format($coupon['min_order_amount'], 0, ',', '.') ?>₫
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <?= $coupon['used_count'] ?><?= $coupon['usage_limit'] ? '/' . $coupon['usage_limit'] : '' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php 
                                            $now = time();
                                            $startDate = $coupon['start_date'] ? strtotime($coupon['start_date']) : null;
                                            $endDate = $coupon['end_date'] ? strtotime($coupon['end_date']) : null;
                                            
                                            if ($endDate && $endDate < $now): ?>
                                                <span class="badge bg-danger">Hết hạn</span>
                                            <?php elseif ($startDate && $startDate > $now): ?>
                                                <span class="badge bg-warning">Chưa bắt đầu</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">Đang hoạt động</span>
                                            <?php endif; ?>
                                        <br>
                                        <small class="text-muted">
                                            <?= $coupon['start_date'] ? date('d/m/Y', strtotime($coupon['start_date'])) : '∞' ?>
                                            - 
                                            <?= $coupon['end_date'] ? date('d/m/Y', strtotime($coupon['end_date'])) : '∞' ?>
                                        </small>
                                    </td>
                                    <td>
                                        <?php if ($coupon['is_active']): ?>
                                            <span class="badge bg-success">Bật</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Tắt</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= BASE_URL ?>admin/couponEdit/<?= $coupon['coupon_id'] ?>" 
                                               class="btn btn-outline-primary" title="Sửa">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?= BASE_URL ?>admin/couponToggle/<?= $coupon['coupon_id'] ?>" 
                                               class="btn btn-outline-<?= $coupon['is_active'] ? 'warning' : 'success' ?>" 
                                               title="<?= $coupon['is_active'] ? 'Tắt' : 'Bật' ?>">
                                                <i class="bi bi-<?= $coupon['is_active'] ? 'pause' : 'play' ?>"></i>
                                            </a>
                                            <a href="<?= BASE_URL ?>admin/couponDelete/<?= $coupon['coupon_id'] ?>" 
                                               class="btn btn-outline-danger" title="Xóa"
                                               onclick="return confirm('Bạn có chắc muốn xóa mã giảm giá này?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($totalPages > 1): ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                <a class="page-link" href="<?= BASE_URL ?>admin/coupons?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
