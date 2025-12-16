<?php
    $imgUrl = BASE_URL . "public/data/" . rawurlencode($product['product_name'] ?? 'default') . ".jpg";
    $displayPrice = $product['min_price'] ?? 0;
    $oldPrice = $product['old_price'] ?? 0;
    $discountPercent = $product['discount_percent'] ?? 0;
    $rating = 4.5 + (rand(0, 10) / 10); // Random rating 4.5-5.5
?>
<div class="product-card-home border rounded bg-white position-relative h-100 d-flex flex-column">
    <!-- Badges -->
    <div class="position-absolute top-0 start-0 p-2" style="z-index: 10;">
        <?php if ($discountPercent > 0): ?>
            <span class="badge bg-danger rounded-pill">Giảm <?= $discountPercent ?>%</span>
        <?php endif; ?>
    </div>
    <div class="position-absolute top-0 end-0 p-2" style="z-index: 10;">
        <span class="badge bg-primary rounded-pill">Trả góp 0%</span>
    </div>
    
    <!-- Product Image -->
    <div class="product-image-container p-3" style="height: 200px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
        <a href="<?= BASE_URL ?>product/detail/<?= $product['product_id'] ?? '' ?>" class="text-decoration-none">
            <img src="<?= $imgUrl ?>" 
                 alt="<?= htmlspecialchars($product['product_name'] ?? 'Product') ?>" 
                 class="img-fluid" 
                 style="max-height: 180px; max-width: 100%; object-fit: contain;"
                 onerror="this.src='https://placehold.co/200x200?text=<?= urlencode($product['product_name'] ?? 'Product') ?>'">
        </a>
    </div>
    
    <!-- Product Info -->
    <div class="product-info p-3 flex-grow-1 d-flex flex-column">
        <a href="<?= BASE_URL ?>product/detail/<?= $product['product_id'] ?? '' ?>" class="text-decoration-none text-dark">
            <h6 class="product-name fw-bold mb-2" style="font-size: 0.9rem; min-height: 40px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                <?= htmlspecialchars($product['product_name'] ?? 'Sản phẩm') ?>
            </h6>
        </a>
        
        <!-- Price -->
        <div class="price-section mb-2">
            <?php if ($displayPrice > 0): ?>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="text-danger fw-bold fs-5"><?= number_format($displayPrice, 0, ',', '.') ?>₫</span>
                    <?php if ($oldPrice > $displayPrice): ?>
                        <del class="text-muted small"><?= number_format($oldPrice, 0, ',', '.') ?>₫</del>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <span class="text-danger small fw-bold">Hết hàng</span>
            <?php endif; ?>
        </div>
        
        <!-- Smember Discount -->
        <div class="smember-info mb-2">
            <small class="text-muted">Smember giảm đến <?= rand(3, 8) ?>%</small>
        </div>
        
        <!-- Installment Info -->
        <div class="installment-info mb-2">
            <small class="text-muted d-block" style="font-size: 0.75rem;">
                Trả góp 0% - 0₫ phụ thu - 0₫ trả trước - kỳ hạn đến 12 tháng
            </small>
        </div>
        
        <!-- Rating and Favorite -->
        <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
            <div class="rating">
                <span class="text-warning">★</span>
                <span class="small"><?= number_format($rating, 1) ?></span>
            </div>
            <button class="btn btn-sm p-0 favorite-btn" data-product-id="<?= $product['product_id'] ?? '' ?>" style="border: none; background: none;">
                <i class="bi bi-heart text-muted"></i>
            </button>
        </div>
    </div>
</div>

<style>
.product-card-home {
    transition: all 0.3s ease;
    overflow: hidden;
}

.product-card-home:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
    border-color: #dc3545 !important;
}

.product-image-container {
    transition: background 0.3s;
}

.product-card-home:hover .product-image-container {
    background: #fff !important;
}

.product-name {
    color: #333;
    transition: color 0.3s;
}

.product-card-home:hover .product-name {
    color: #dc3545;
}

.favorite-btn {
    transition: all 0.3s;
}

.favorite-btn:hover i {
    color: #dc3545 !important;
}

.favorite-btn.active i {
    color: #dc3545 !important;
}

.badge {
    font-size: 0.75rem;
    padding: 4px 8px;
}
</style>

<script>
// Favorite button functionality
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.favorite-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.toggle('active');
            const icon = this.querySelector('i');
            if (this.classList.contains('active')) {
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
            } else {
                icon.classList.remove('bi-heart-fill');
                icon.classList.add('bi-heart');
            }
        });
    });
});
</script>

