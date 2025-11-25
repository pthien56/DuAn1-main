<?php require_once __DIR__ . '/header.php'; ?>

<main>
    <div class="container">
        <h2>Thanh toán</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <a href="<?php echo baseUrl('orders.php'); ?>" class="btn btn-primary">Xem đơn hàng</a>
        <?php else: ?>
            <div class="checkout-page">
                <div class="checkout-items">
                    <h3>Đơn hàng của bạn</h3>
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['product_name'] . ' - ' . $item['variant_name']); ?></td>
                                    <td><?php echo $item['cart_quantity']; ?></td>
                                    <td><?php echo formatCurrency($item['price']); ?></td>
                                    <td><?php echo formatCurrency($item['subtotal']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"><strong>Tổng cộng:</strong></td>
                                <td><strong><?php echo formatCurrency($total); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="checkout-form">
                    <h3>Thông tin thanh toán</h3>
                    <form method="POST">
                        <div class="form-group">
                            <label>Họ và tên:</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($customer['full_name']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại:</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($customer['phone_number']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" class="form-control" value="<?php echo htmlspecialchars($customer['email']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ giao hàng:</label>
                            <textarea name="shipping_address" class="form-control" required><?php echo htmlspecialchars($customer['address'] ?? ''); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Phương thức thanh toán:</label>
                            <select name="payment_method" class="form-control" required>
                                <option value="Tiền mặt">Tiền mặt</option>
                                <option value="Chuyển khoản">Chuyển khoản</option>
                                <option value="Thẻ tín dụng">Thẻ tín dụng</option>
                                <option value="Ví điện tử">Ví điện tử</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ghi chú:</label>
                            <textarea name="note" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-large">Đặt hàng</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>

