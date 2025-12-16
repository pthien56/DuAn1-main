<?php
require_once dirname(dirname(__DIR__)) . "/admin/layouts/header.php";
?>

<style>
.review-table {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 10px;
    overflow: hidden;
}
.review-table thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
.review-table thead th {
    border: none;
    padding: 15px;
    font-weight: 600;
}
.review-table tbody tr {
    transition: all 0.3s ease;
}
.review-table tbody tr:hover {
    background-color: #f8f9fa;
}
.filter-bar {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">
        <i class="bi bi-star me-2"></i> Quản Lý Đánh Giá
    </h2>
    <span class="badge bg-primary fs-6">
        Tổng: <?= count($reviews) ?> đánh giá
    </span>
</div>

<!-- Filter Bar -->
<div class="filter-bar">
    <form method="GET" action="<?= BASE_URL ?>admin/reviews" class="row g-3">
        <div class="col-md-4">
            <label class="form-label fw-bold">Lọc Theo Trạng Thái</label>
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Tất cả</option>
                <option value="pending" <?= ($statusFilter ?? '') == 'pending' ? 'selected' : '' ?>>Chờ Duyệt</option>
                <option value="approved" <?= ($statusFilter ?? '') == 'approved' ? 'selected' : '' ?>>Đã Duyệt</option>
                <option value="rejected" <?= ($statusFilter ?? '') == 'rejected' ? 'selected' : '' ?>>Đã Từ Chối</option>
            </select>
        </div>
        <?php if (!empty($statusFilter)): ?>
        <div class="col-md-2 d-flex align-items-end">
            <a href="<?= BASE_URL ?>admin/reviews" class="btn btn-outline-secondary w-100">
                <i class="bi bi-x-circle me-1"></i> Xóa Bộ Lọc
            </a>
        </div>
        <?php endif; ?>
    </form>
</div>

<div class="table-responsive review-table">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Sản Phẩm</th>
                <th>Khách Hàng</th>
                <th>Đánh Giá</th>
                <th>Bình Luận</th>
                <th>Trạng Thái</th>
                <th>Ngày Tạo</th>
                <th class="text-center">Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($reviews)): ?>
            <tr>
                <td colspan="8" class="text-center py-5">
                    <i class="bi bi-inbox fs-1 d-block text-muted mb-3"></i>
                    <p class="text-muted mb-0">Không có đánh giá nào</p>
                </td>
            </tr>
            <?php else: ?>
                <?php foreach ($reviews as $review): ?>
                <tr>
                    <td><strong>#<?= $review['review_id'] ?></strong></td>
                    <td>
                        <a href="<?= BASE_URL ?>product/detail/<?= $review['product_id'] ?>" 
                           class="text-decoration-none" target="_blank">
                            <i class="bi bi-box me-1"></i>
                            <?= htmlspecialchars($review['product_name'] ?? 'N/A') ?>
                        </a>
                    </td>
                    <td>
                        <i class="bi bi-person-circle me-1"></i>
                        <?= htmlspecialchars($review['full_name'] ?? 'Khách hàng') ?>
                        <br>
                        <small class="text-muted"><?= htmlspecialchars($review['email'] ?? '') ?></small>
                    </td>
                    <td>
                        <div class="mb-1">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="bi bi-star<?= $i <= $review['rating'] ? '-fill' : '' ?> text-warning"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="badge bg-warning text-dark"><?= $review['rating'] ?>/5</span>
                    </td>
                    <td>
                        <small><?= !empty($review['comment']) ? htmlspecialchars(mb_substr($review['comment'], 0, 100)) . (mb_strlen($review['comment']) > 100 ? '...' : '') : 'Không có bình luận' ?></small>
                    </td>
                    <td>
                        <?php 
                            $status = $review['status'] ?? 'pending';
                            $statusClass = $status == 'approved' ? 'success' : ($status == 'rejected' ? 'danger' : 'warning');
                            $statusText = $status == 'approved' ? 'Đã Duyệt' : ($status == 'rejected' ? 'Đã Từ Chối' : 'Chờ Duyệt');
                        ?>
                        <span class="badge bg-<?= $statusClass ?> rounded-pill">
                            <?= $statusText ?>
                        </span>
                    </td>
                    <td>
                        <small class="text-muted">
                            <i class="bi bi-calendar me-1"></i>
                            <?= date('d/m/Y H:i', strtotime($review['created_at'])) ?>
                        </small>
                    </td>
                    <td class="text-center">
                        <?php if ($status == 'pending'): ?>
                            <a href="<?= BASE_URL ?>admin/reviewApprove/<?= $review['review_id'] ?>" 
                               class="btn btn-sm btn-success me-1"
                               onclick="return confirm('Bạn có chắc muốn duyệt đánh giá này?')"
                               title="Duyệt">
                                <i class="bi bi-check-circle"></i>
                            </a>
                            <a href="<?= BASE_URL ?>admin/reviewReject/<?= $review['review_id'] ?>" 
                               class="btn btn-sm btn-danger me-1"
                               onclick="return confirm('Bạn có chắc muốn từ chối đánh giá này?')"
                               title="Từ Chối">
                                <i class="bi bi-x-circle"></i>
                            </a>
                        <?php endif; ?>
                        <a href="<?= BASE_URL ?>admin/reviewDelete/<?= $review['review_id'] ?>" 
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Bạn có chắc muốn xóa đánh giá này?')"
                           title="Xóa">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once dirname(dirname(__DIR__)) . "/admin/layouts/footer.php"; ?>

