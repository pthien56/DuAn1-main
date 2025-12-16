<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4 mb-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-person-circle" style="font-size: 4rem; color: #0d6efd;"></i>
                    <h5 class="mt-3"><?= htmlspecialchars($_SESSION['customer_name'] ?? 'Khách hàng') ?></h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?= BASE_URL ?>customer/profile" class="list-group-item list-group-item-action">
                        <i class="bi bi-person me-2"></i> Thông Tin Tài Khoản
                    </a>
                    <a href="<?= BASE_URL ?>customer/orders" class="list-group-item list-group-item-action active">
                        <i class="bi bi-bag me-2"></i> Đơn Hàng Của Tôi
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-bag-check me-2"></i> Đơn Hàng Của Tôi</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($orders)): ?>
                        <div class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                            <p class="text-muted mt-3">Bạn chưa có đơn hàng nào</p>
                            <a href="<?= BASE_URL ?>product/index" class="btn btn-primary">Mua Sắm Ngay</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã Đơn</th>
                                        <th>Ngày Đặt</th>
                                        <th>Tổng Tiền</th>
                                        <th>Trạng Thái</th>
                                        <th>Phương Thức</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td><strong>#<?= $order['order_id'] ?></strong></td>
                                            <td><?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></td>
                                            <td class="text-danger fw-bold"><?= number_format($order['total_amount'], 0, ',', '.') ?>₫</td>
                                            <td>
                                                <?php
                                                $statusClass = 'secondary';
                                                switch($order['status_name']) {
                                                    case 'Đã xác nhận': $statusClass = 'success'; break;
                                                    case 'Đang xử lý': $statusClass = 'info'; break;
                                                    case 'Đang giao hàng': $statusClass = 'primary'; break;
                                                    case 'Đã giao': $statusClass = 'success'; break;
                                                    case 'Đã hủy': $statusClass = 'danger'; break;
                                                }
                                                ?>
                                                <span class="badge bg-<?= $statusClass ?>"><?= htmlspecialchars($order['status_name'] ?? 'Chờ xử lý') ?></span>
                                            </td>
                                            <td><?= htmlspecialchars($order['payment_method'] ?? 'Tiền mặt') ?></td>
                                            <td>
                                                <a href="<?= BASE_URL ?>customer/orderDetail/<?= $order['order_id'] ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye me-1"></i> Chi Tiết
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

