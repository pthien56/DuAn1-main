<?php require_once __DIR__ . '/header.php'; ?>

<main>
    <div class="container">
        <div class="product-detail">
            <div class="product-images">
                <img src="<?php echo assetUrl('images/products/' . $product['variant_id'] . '.jpg'); ?>" 
                     alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                     onerror="this.src='<?php echo assetUrl('images/placeholder.jpg'); ?>'">
            </div>
            <div class="product-detail-info">
                <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
                <p class="product-brand">Thương hiệu: <?php echo htmlspecialchars($product['brand']); ?></p>
                <p class="product-category">Danh mục: <?php echo htmlspecialchars($product['category_name']); ?></p>
                <p class="product-variant">Phiên bản: <?php echo htmlspecialchars($product['variant_name']); ?></p>
                <p class="product-color">Màu sắc: <?php echo htmlspecialchars($product['color']); ?></p>
                <p class="product-storage">Bộ nhớ: <?php echo htmlspecialchars($product['storage']); ?></p>
                <p class="product-price-large"><?php echo formatCurrency($product['price']); ?></p>
                <p class="product-stock">Tồn kho: <?php echo $product['stock_quantity']; ?> sản phẩm</p>
                <p class="product-warranty">Bảo hành: <?php echo $product['warranty_months']; ?> tháng</p>
                
                <div class="product-description">
                    <h3>Mô tả sản phẩm</h3>
                    <p><?php echo nl2br(htmlspecialchars($product['description'] ?? 'Không có mô tả')); ?></p>
                </div>

                <div class="product-actions">
                    <input type="number" id="quantity" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>" class="form-control" style="width: 100px; display: inline-block;">
                    <button class="btn btn-primary btn-large" onclick="addToCart(<?php echo $product['variant_id']; ?>, document.getElementById('quantity').value)">Thêm vào giỏ hàng</button>
                </div>

                <?php if (!empty($otherVariants)): ?>
                    <div class="other-variants">
                        <h3>Các phiên bản khác</h3>
                        <div class="variant-list">
                            <?php foreach ($otherVariants as $variant): ?>
                                <a href="<?php echo baseUrl('product-detail.php?id=' . $variant['variant_id']); ?>" class="variant-item">
                                    <?php echo htmlspecialchars($variant['variant_name']); ?> - <?php echo formatCurrency($variant['price']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="product-feedback">
            <h2>Đánh giá sản phẩm</h2>
            <?php if (!empty($feedbacks)): ?>
                <?php foreach ($feedbacks as $feedback): ?>
                    <div class="feedback-item">
                        <p><strong><?php echo htmlspecialchars($feedback['full_name']); ?></strong> - 
                           <?php echo formatDateTime($feedback['feedback_date']); ?></p>
                        <p>Đánh giá: <?php echo str_repeat('⭐', $feedback['rating']); ?></p>
                        <p><?php echo htmlspecialchars($feedback['comment']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Chưa có đánh giá nào.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>

