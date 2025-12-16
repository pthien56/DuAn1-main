<?php
require_once dirname(dirname(__DIR__)) . "/admin/layouts/header.php";
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-4">Quản Lý Đơn Hàng</h2>
    <span class="badge bg-primary fs-6">
        Tổng: <?= count($orders) ?> đơn hàng
    </span>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Mã Đơn</th>
                <th>Khách Hàng</th>
                <th>Ngày Đặt</th>
                <th>Tổng Tiền</th>
                <th>Trạng Thái</th>
                <th>Phương Thức TT</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="7" class="text-center">Chưa có đơn hàng nào</td>
                </tr>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= $order['order_id'] ?></td>
                        <td><?= htmlspecialchars($order['customer_name']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></td>
                        <td><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</td>
                        <td><span class="badge bg-info"><?= htmlspecialchars($order['status_name']) ?></span></td>
                        <td><?= htmlspecialchars($order['payment_method']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>admin/orderDetail/<?= $order['order_id'] ?>" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Chi Tiết
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once dirname(dirname(__DIR__)) . "/admin/layouts/footer.php"; ?>