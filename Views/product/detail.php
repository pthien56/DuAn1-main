<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="py-4">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-6 mb-4">
                <img src="<?php echo assetUrl('images/products/' . $product['variant_id'] . '.jpg'); ?>" 
                     class="img-fluid rounded shadow" 
                     alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                     onerror="this.src='<?php echo assetUrl('images/placeholder.jpg'); ?>'">
            </div>
            <div class="col-md-6">
                <h1 class="mb-3"><?php echo htmlspecialchars($product['product_name']); ?></h1>
                <div class="mb-3">
                    <span class="badge bg-secondary me-2"><?php echo htmlspecialchars($product['brand']); ?></span>
                    <span class="badge bg-info"><?php echo htmlspecialchars($product['category_name']); ?></span>
                </div>
                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><strong>Phiên bản:</strong> <?php echo htmlspecialchars($product['variant_name']); ?></li>
                    <li class="mb-2"><strong>Màu sắc:</strong> <?php echo htmlspecialchars($product['color']); ?></li>
                    <li class="mb-2"><strong>Bộ nhớ:</strong> <?php echo htmlspecialchars($product['storage']); ?></li>
                    <li class="mb-2"><strong>Tồn kho:</strong> <?php echo $product['stock_quantity']; ?> sản phẩm</li>
                    <li class="mb-2"><strong>Bảo hành:</strong> <?php echo $product['warranty_months']; ?> tháng</li>
                </ul>
                <div class="mb-4">
                    <h2 class="text-warning fw-bold"><?php echo formatCurrency($product['price']); ?></h2>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Số lượng:</label>
                    <div class="input-group mb-3" style="max-width: 200px;">
                        <input type="number" id="quantity" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>" class="form-control">
                        <button class="btn btn-primary" onclick="addToCart(<?php echo $product['variant_id']; ?>, document.getElementById('quantity').value)">
                            <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng
                        </button>
                    </div>
                </div>

                <?php if (!empty($otherVariants)): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Các phiên bản khác</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <?php foreach ($otherVariants as $variant): ?>
                                    <a href="<?php echo baseUrl('product-detail.php?id=' . $variant['variant_id']); ?>" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1"><?php echo htmlspecialchars($variant['variant_name']); ?></h6>
                                            <strong class="text-warning"><?php echo formatCurrency($variant['price']); ?></strong>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Description -->
        <div class="card mb-5">
            <div class="card-header">
                <h5 class="mb-0">Mô tả sản phẩm</h5>
            </div>
            <div class="card-body">
                <p><?php echo nl2br(htmlspecialchars($product['description'] ?? 'Không có mô tả')); ?></p>
            </div>
        </div>

        <!-- Feedback Section -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Đánh giá sản phẩm</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($feedbacks)): ?>
                    <?php foreach ($feedbacks as $feedback): ?>
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <strong><?php echo htmlspecialchars($feedback['full_name']); ?></strong>
                                <small class="text-muted"><?php echo formatDateTime($feedback['feedback_date']); ?></small>
                            </div>
                            <div class="mb-2">
                                <?php echo str_repeat('⭐', $feedback['rating']); ?>
                            </div>
                            <p class="mb-0"><?php echo htmlspecialchars($feedback['comment']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">Chưa có đánh giá nào.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>