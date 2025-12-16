<?php
require_once dirname(dirname(__DIR__)) . "/admin/layouts/header.php";
?>

<style>
.customer-table {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 10px;
    overflow: hidden;
}
.customer-table thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
.customer-table thead th {
    border: none;
    padding: 15px;
    font-weight: 600;
}
.customer-table tbody tr {
    transition: all 0.3s ease;
}
.customer-table tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.01);
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
        <i class="bi bi-people me-2"></i> Quản Lý Khách Hàng
    </h2>
    <span class="badge bg-primary fs-6">
        Tổng: <?= count($customers) ?> khách hàng
    </span>
</div>

<!-- Filter Bar -->
<div class="filter-bar">
    <form method="GET" action="<?= BASE_URL ?>admin/customers" class="row g-3">
        <div class="col-md-6">
            <label class="form-label fw-bold">Tìm Kiếm</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control" 
                       placeholder="Tên, email, số điện thoại..." 
                       value="<?= htmlspecialchars($search ?? '') ?>">
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-bold">Lọc Theo Trạng Thái</label>
            <select name="status" class="form-select">
                <option value="">Tất cả</option>
                <option value="active" <?= ($statusFilter ?? '') == 'active' ? 'selected' : '' ?>>Hoạt Động</option>
                <option value="locked" <?= ($statusFilter ?? '') == 'locked' ? 'selected' : '' ?>>Đã Khóa</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-funnel me-1"></i> Lọc
            </button>
        </div>
        <?php if (!empty($search) || !empty($statusFilter)): ?>
        <div class="col-12">
            <a href="<?= BASE_URL ?>admin/customers" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-x-circle me-1"></i> Xóa Bộ Lọc
            </a>
        </div>
        <?php endif; ?>
    </form>
</div>

<div class="table-responsive customer-table">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ và Tên</th>
                <th>Điện Thoại</th>
                <th>Email</th>
                <th>Địa Chỉ</th>
                <th>Trạng Thái</th>
                <th>Ngày Tạo</th>
                <th class="text-center">Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($customers)): ?>
            <tr>
                <td colspan="8" class="text-center py-5">
                    <i class="bi bi-inbox fs-1 d-block text-muted mb-3"></i>
                    <p class="text-muted mb-0">Không tìm thấy khách hàng nào</p>
                    <?php if (!empty($search) || !empty($statusFilter)): ?>
                        <a href="<?= BASE_URL ?>admin/customers" class="btn btn-sm btn-primary mt-2">
                            <i class="bi bi-arrow-left me-1"></i> Xem Tất Cả
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php else: ?>
                <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><strong>#<?= $customer['customer_id'] ?></strong></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                <i class="bi bi-person text-primary"></i>
                            </div>
                            <strong><?= htmlspecialchars($customer['full_name']) ?></strong>
                        </div>
                    </td>
                    <td>
                        <i class="bi bi-phone me-1 text-muted"></i>
                        <?= htmlspecialchars($customer['phone_number']) ?>
                    </td>
                    <td>
                        <i class="bi bi-envelope me-1 text-muted"></i>
                        <?= htmlspecialchars($customer['email']) ?>
                    </td>
                    <td>
                        <i class="bi bi-geo-alt me-1 text-muted"></i>
                        <small><?= htmlspecialchars($customer['address'] ?: 'Chưa cập nhật') ?></small>
                    </td>
                    <td>
                        <?php 
                            $status = $customer['status'] ?? 'active';
                            $statusClass = $status == 'locked' ? 'danger' : 'success';
                            $statusText = $status == 'locked' ? 'Đã Khóa' : 'Hoạt Động';
                            $statusIcon = $status == 'locked' ? 'lock-fill' : 'check-circle-fill';
                        ?>
                        <span class="badge bg-<?= $statusClass ?> rounded-pill">
                            <i class="bi bi-<?= $statusIcon ?> me-1"></i><?= $statusText ?>
                        </span>
                    </td>
                    <td>
                        <small class="text-muted">
                            <i class="bi bi-calendar me-1"></i>
                            <?= date('d/m/Y', strtotime($customer['created_at'])) ?>
                        </small>
                    </td>
                    <td class="text-center">
                        <a href="<?= BASE_URL ?>admin/customerToggleStatus/<?= $customer['customer_id'] ?><?= !empty($search) ? '?search=' . urlencode($search) : '' ?><?= !empty($statusFilter) ? (!empty($search) ? '&' : '?') . 'status=' . urlencode($statusFilter) : '' ?>" 
                           class="btn btn-sm btn-<?= $status == 'locked' ? 'success' : 'warning' ?>"
                           onclick="return confirm('Bạn có chắc muốn <?= $status == 'locked' ? 'mở khóa' : 'khóa' ?> khách hàng <?= htmlspecialchars($customer['full_name']) ?>?')"
                           title="<?= $status == 'locked' ? 'Mở khóa' : 'Khóa' ?> khách hàng">
                            <i class="bi bi-<?= $status == 'locked' ? 'unlock' : 'lock' ?>"></i> 
                            <?= $status == 'locked' ? 'Mở Khóa' : 'Khóa' ?>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once dirname(dirname(__DIR__)) . "/admin/layouts/footer.php"; ?>

