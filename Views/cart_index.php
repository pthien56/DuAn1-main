<?php require_once __DIR__ . '/header.php'; ?>

<main>
    <div class="container">
        <h2>Giỏ hàng của bạn</h2>
        
        <?php if (empty($cartItems)): ?>
            <div class="empty-cart">
                <p>Giỏ hàng của bạn đang trống.</p>
                <a href="<?php echo baseUrl('products.php'); ?>" class="btn btn-primary">Tiếp tục mua sắm</a>
            </div>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td>
                                <div class="cart-product">
                                    <img src="<?php echo assetUrl('images/products/' . $item['variant_id'] . '.jpg'); ?>" 
                                         alt="<?php echo htmlspecialchars($item['product_name']); ?>"
                                         onerror="this.src='<?php echo assetUrl('images/placeholder.jpg'); ?>'">
                                    <div>
                                        <h4><?php echo htmlspecialchars($item['product_name']); ?></h4>
                                        <p><?php echo htmlspecialchars($item['variant_name']); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo formatCurrency($item['price']); ?></td>
                            <td>
                                <input type="number" 
                                       value="<?php echo $item['cart_quantity']; ?>" 
                                       min="1" 
                                       max="<?php echo $item['stock_quantity']; ?>"
                                       onchange="updateCart(<?php echo $item['variant_id']; ?>, this.value)">
                            </td>
                            <td><?php echo formatCurrency($item['subtotal']); ?></td>
                            <td>
                                <button class="btn btn-danger" onclick="removeFromCart(<?php echo $item['variant_id']; ?>)">Xóa</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Tổng cộng:</strong></td>
                        <td colspan="2"><strong><?php echo formatCurrency($total); ?></strong></td>
                    </tr>
                </tfoot>
            </table>
            
            <div class="cart-actions">
                <a href="<?php echo baseUrl('products.php'); ?>" class="btn btn-secondary">Tiếp tục mua sắm</a>
                <a href="<?php echo baseUrl('checkout.php'); ?>" class="btn btn-primary btn-large">Thanh toán</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>

