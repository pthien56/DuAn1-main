<?php require_once __DIR__ . '/header.php'; ?>

<main>
    <div class="container">
        <h2>Đơn hàng của tôi</h2>
        
        <?php if (!empty($orders)): ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Phương thức thanh toán</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?php echo $order['order_id']; ?></td>
                            <td><?php echo formatDateTime($order['order_date']); ?></td>
                            <td><?php echo formatCurrency($order['total_amount']); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $order['status_name'])); ?>">
                                    <?php echo htmlspecialchars($order['status_name']); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                            <td>
                                <a href="<?php echo baseUrl('order-detail.php?id=' . $order['order_id']); ?>" class="btn btn-primary">Xem chi tiết</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Bạn chưa có đơn hàng nào.</p>
            <a href="<?php echo baseUrl('products.php'); ?>" class="btn btn-primary">Mua sắm ngay</a>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>

