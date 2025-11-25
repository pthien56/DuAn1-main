<?php 
$title = 'Chi tiết đơn hàng #' . $order['order_id'] . ' - Quản trị';
$admin = true;
require_once __DIR__ . '/header.php'; 
?>

<main>
    <div class="container">
        <h1>Chi tiết đơn hàng #<?php echo $order['order_id']; ?></h1>
        
        <div class="order-detail-page">
            <div class="order-info">
                <h3>Thông tin đơn hàng</h3>
                <p><strong>Ngày đặt:</strong> <?php echo formatDateTime($order['order_date']); ?></p>
                <p><strong>Trạng thái:</strong> <?php echo htmlspecialchars($order['status_name']); ?></p>
                <p><strong>Tổng tiền:</strong> <?php echo formatCurrency($order['total_amount']); ?></p>
                <p><strong>Phương thức thanh toán:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
                <?php if ($order['note']): ?>
                    <p><strong>Ghi chú:</strong> <?php echo htmlspecialchars($order['note']); ?></p>
                <?php endif; ?>
            </div>
            
            <div class="customer-info">
                <h3>Thông tin khách hàng</h3>
                <p><strong>Họ và tên:</strong> <?php echo htmlspecialchars($order['full_name']); ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['phone_number']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['address'] ?? ''); ?></p>
            </div>
            
            <div class="order-items">
                <h3>Chi tiết sản phẩm</h3>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Giảm giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderDetails as $detail): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($detail['product_name']); ?></strong><br>
                                    <?php echo htmlspecialchars($detail['variant_name']); ?>
                                </td>
                                <td><?php echo $detail['quantity']; ?></td>
                                <td><?php echo formatCurrency($detail['unit_price']); ?></td>
                                <td><?php echo $detail['discount']; ?>%</td>
                                <td><?php echo formatCurrency($detail['subtotal']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"><strong>Tổng cộng:</strong></td>
                            <td><strong><?php echo formatCurrency($order['total_amount']); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <a href="<?php echo baseUrl('admin/orders.php'); ?>" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>
    </div>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>

