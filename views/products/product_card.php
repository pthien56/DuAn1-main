<?php
    // Hàm helper để tạo mô tả ngắn
    if (!function_exists('getShortDescription')) {
        function getShortDescription($description, $maxLength = 80) {
            if (empty($description)) {
                return 'Sản phẩm chất lượng cao, chính hãng, bảo hành đầy đủ.';
            }
            $description = strip_tags($description);
            $description = trim($description);
            if (mb_strlen($description) <= $maxLength) {
                return $description;
            }
            return mb_substr($description, 0, $maxLength) . '...';
        }
    }
    
    $imgUrl = BASE_URL . "public/data/" . rawurlencode($product['product_name'] ?? 'default') . ".jpg";
    $displayPrice = $product['min_price'] ?? $product['price'] ?? 0;
    $shortDescription = getShortDescription($product['description'] ?? '');
?>
<div class="card h-100 shadow-sm product-card border-0">
    <div class="position-relative overflow-hidden">
        <a href="<?= BASE_URL ?>product/detail/<?= $product['product_id'] ?? '' ?>" class="text-decoration-none">
            <div class="product-image-wrapper" style="height: 220px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                <img src="<?= $imgUrl ?>" 
                     alt="<?= htmlspecialchars($product['product_name'] ?? 'Product') ?>" 
                     class="img-fluid product-image" 
                     style="max-height: 100%; max-width: 100%; object-fit: contain; transition: transform 0.3s ease;"
                     onerror="this.src='https://placehold.co/300x300?text=<?= urlencode($product['product_name'] ?? 'Product') ?>'">
                
                <?php if ($displayPrice > 0 && $displayPrice < 10000000): ?>
                    <span class="badge bg-danger position-absolute top-0 start-0 m-2 rounded-pill shadow-sm">
                        <i class="bi bi-lightning-charge"></i> SALE
                    </span>
                <?php endif; ?>
                
                <?php if (!empty($product['brand'])): ?>
                    <span class="badge bg-primary position-absolute top-0 end-0 m-2 rounded-pill shadow-sm">
                        <?= htmlspecialchars($product['brand']) ?>
                    </span>
                <?php endif; ?>
            </div>
        </a>
    </div>
    
    <div class="card-body p-3">
        <a href="<?= BASE_URL ?>product/detail/<?= $product['product_id'] ?? '' ?>" class="text-decoration-none text-dark">
            <h6 class="card-title fw-bold mb-2 product-name" style="min-height: 48px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; color: #212529;">
                <?= htmlspecialchars($product['product_name'] ?? 'Sản phẩm') ?>
            </h6>
            
            <p class="text-muted small mb-2 product-description" style="min-height: 40px; font-size: 0.85rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                <?= htmlspecialchars($shortDescription) ?>
            </p>
            
            <?php if (!empty($product['brand'])): ?>
                <p class="text-muted small mb-2">
                    <i class="bi bi-tag-fill text-primary"></i> 
                    <span class="fw-semibold"><?= htmlspecialchars($product['brand']) ?></span>
                </p>
            <?php endif; ?>
            
            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                <?php if ($displayPrice > 0): ?>
                    <div>
                        <span class="text-danger fw-bold fs-5">
                            <?= number_format($displayPrice, 0, ',', '.') ?>₫
                        </span>
                        <?php if (isset($product['old_price']) && $product['old_price'] > $displayPrice): ?>
                            <div>
                                <del class="text-muted small"><?= number_format($product['old_price'], 0, ',', '.') ?>₫</del>
                                <span class="badge bg-success ms-1">
                                    -<?= round((($product['old_price'] - $displayPrice) / $product['old_price']) * 100) ?>%
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <span class="text-danger small fw-bold">Hết hàng</span>
                <?php endif; ?>
            </div>
        </a>
    </div>
    
    <div class="card-footer bg-white border-0 pt-0 pb-3">
        <div class="d-grid gap-2">
            <a href="<?= BASE_URL ?>product/detail/<?= $product['product_id'] ?? '' ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-eye me-1"></i> Xem Chi Tiết
            </a>
        </div>
    </div>
</div>