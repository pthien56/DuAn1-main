<?php
require_once "layouts/header.php";

// Hàm hỗ trợ lấy màu sắc dựa trên trạng thái (Bạn có thể tùy chỉnh theo text trong DB của bạn)
function getStatusBadgeClass($statusName) {
    $statusName = mb_strtolower($statusName, 'UTF-8');
    if (strpos($statusName, 'hoàn thành') !== false || strpos($statusName, 'thành công') !== false) {
        return 'bg-success';
    } elseif (strpos($statusName, 'hủy') !== false) {
        return 'bg-danger';
    } elseif (strpos($statusName, 'vận chuyển') !== false || strpos($statusName, 'giao hàng') !== false) {
        return 'bg-info text-dark';
    } elseif (strpos($statusName, 'chờ') !== false || strpos($statusName, 'mới') !== false) {
        return 'bg-warning text-dark';
    }
    return 'bg-secondary'; // Mặc định
}
?>

<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4">Dashboard</h2>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-primary text-white h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">Tổng Sản Phẩm</div>
                            <div class="fs-2 fw-bold"><?= number_format($stats['total_products']) ?></div>
                        </div>
                        <i class="fas fa-box fa-2x text-white-50"></i> </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-success text-white h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">Tổng Đơn Hàng</div>
                            <div class="fs-2 fw-bold"><?= number_format($stats['total_orders']) ?></div>
                        </div>
                        <i class="fas fa-shopping-cart fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-info text-white h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">Tổng Khách Hàng</div>
                            <div class="fs-2 fw-bold"><?= number_format($stats['total_customers']) ?></div>
                        </div>
                        <i class="fas fa-users fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-warning text-dark h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-dark-50 small text-uppercase fw-bold">Doanh Thu Tháng</div>
                            <div class="fs-2 fw-bold"><?= number_format($stats['revenue_month'], 0, ',', '.') ?> ₫</div>
                        </div>
                        <i class="fas fa-dollar-sign fa-2x text-dark-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-table me-2"></i>Đơn Hàng Mới Nhất</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" width="100%" cellspacing="0">
                            <thead class="table-light">
                                <tr>
                                    <th>Mã Đơn</th>
                                    <th>Khách Hàng</th>
                                    <th>Ngày Đặt</th>
                                    <th>Tổng Tiền</th>
                                    <th class="text-center">Trạng Thái</th>
                                    <th class="text-center">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($recentOrders)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i><br>
                                            Chưa có đơn hàng nào
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($recentOrders as $order): ?>
                                        <tr>
                                            <td class="fw-bold text-primary">#<?= $order['order_id'] ?></td>
                                            <td>
                                                <div class="fw-bold"><?= htmlspecialchars($order['customer_name']) ?></div>
                                            </td>
                                            <td><?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></td>
                                            <td class="text-danger fw-bold">
                                                <?= number_format($order['total_amount'], 0, ',', '.') ?> ₫
                                            </td>
                                            <td class="text-center">
                                                <span class="badge rounded-pill <?= getStatusBadgeClass($order['status_name']) ?>">
                                                    <?= htmlspecialchars($order['status_name']) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= BASE_URL ?>admin/orderDetail/<?= $order['order_id'] ?>" 
                                                   class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i> Chi Tiết
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "layouts/footer.php"; ?>