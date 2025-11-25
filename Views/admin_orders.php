<?php 
$title = 'Quản lý đơn hàng - Quản trị';
$admin = true;
require_once __DIR__ . '/header.php'; 
?>

<main>
    <div class="container">
        <h1>Quản lý đơn hàng</h1>
        
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Khách hàng</th>
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
                        <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                        <td><?php echo formatDateTime($order['order_date']); ?></td>
                        <td><?php echo formatCurrency($order['total_amount']); ?></td>
                        <td>
                            <form method="POST" style="display: inline-block;">
                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                <select name="status_id" class="form-control" onchange="this.form.submit()">
                                    <?php foreach ($statuses as $status): ?>
                                        <option value="<?php echo $status['order_status_id']; ?>" 
                                                <?php echo $order['order_status_id'] == $status['order_status_id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($status['status_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="hidden" name="update_status" value="1">
                            </form>
                        </td>
                        <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                        <td>
                            <a href="<?php echo baseUrl('admin/order-detail.php?id=' . $order['order_id']); ?>" class="btn btn-primary btn-small">Xem chi tiết</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <a href="<?php echo baseUrl('admin/dashboard.php'); ?>" class="btn btn-secondary">Quay lại Dashboard</a>
    </div>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>

