<div class="row">
    <div class="col-md-3">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-list-ul"></i> Danh Mục</h5>
            </div>
            <div class="list-group list-group-flush">
                <a href="<?= BASE_URL ?>product/index" class="list-group-item list-group-item-action">Tất Cả</a>
                <?php foreach ($categories as $category): ?>
                <a href="<?= BASE_URL ?>product/category/<?= $category['category_id'] ?>" 
                   class="list-group-item list-group-item-action <?= $category['category_id'] == $categoryId ? 'active' : '' ?>">
                    <i class="bi bi-phone"></i> <?= htmlspecialchars($category['category_name']) ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-0">Sản Phẩm Theo Danh Mục</h2>
            <div class="text-muted small">
                Tìm thấy <strong><?= count($products) ?></strong> sản phẩm
            </div>
        </div>
        
        <div class="row g-4">
            <?php if (empty($products)): ?>
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                    <h4>Không có sản phẩm nào trong danh mục này</h4>
                    <p class="text-muted">Vui lòng chọn danh mục khác hoặc <a href="<?= BASE_URL ?>product/index">xem tất cả sản phẩm</a>.</p>
                </div>
            </div>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                <?php
                require_once __DIR__ . '/../../models/ProductModel.php';
                $productModel = new ProductModel();
                $variants = $productModel->getProductVariants($product['product_id']);
                $firstVariant = $variants ? $variants[0] : null;
                $minPrice = $variants ? min(array_column($variants, 'price')) : 0;
                $maxPrice = $variants ? max(array_column($variants, 'price')) : 0;
                ?>
                <div class="col-lg-4 col-md-6 col-6">
                    <div class="product-card h-100 border rounded overflow-hidden position-relative shadow-sm">
                        <a href="<?= BASE_URL ?>product/detail/<?= $product['product_id'] ?>" class="text-decoration-none">
                            <div class="product-image-wrapper position-relative" style="height: 220px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                <?php 
                                    $imgUrl = BASE_URL . "public/data/" . rawurlencode($product['product_name'] ?? 'default') . ".jpg";
                                ?>
                                <img src="<?= $imgUrl ?>" 
                                     alt="<?= htmlspecialchars($product['product_name'] ?? 'Product') ?>" 
                                     class="img-fluid product-image" 
                                     style="max-height: 100%; max-width: 100%; object-fit: contain; transition: transform 0.3s ease;"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="position-absolute w-100 h-100 d-none align-items-center justify-content-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                    <i class="bi bi-phone" style="font-size: 80px; color: #6c757d;"></i>
                                </div>
                                
                                <?php if ($minPrice > 0 && $minPrice < 10000000): ?>
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
                        <div class="product-info p-3">
                            <a href="<?= BASE_URL ?>product/detail/<?= $product['product_id'] ?>" class="text-decoration-none text-dark">
                                <h6 class="product-name fw-bold mb-2" style="min-height: 48px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?= htmlspecialchars($product['product_name']) ?>
                                </h6>
                            </a>
                            
                            <?php 
                                // Tạo mô tả ngắn
                                $shortDesc = '';
                                if (!empty($product['description'])) {
                                    $desc = strip_tags($product['description']);
                                    $shortDesc = mb_strlen($desc) > 60 ? mb_substr($desc, 0, 60) . '...' : $desc;
                                } else {
                                    $shortDesc = 'Sản phẩm chất lượng cao, chính hãng.';
                                }
                            ?>
                            <p class="text-muted small mb-2 product-short-desc" style="min-height: 36px; font-size: 0.8rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <?= htmlspecialchars($shortDesc) ?>
                            </p>
                            
                            <p class="text-muted small mb-2">
                                <i class="bi bi-tag-fill text-primary"></i> 
                                <span class="fw-semibold"><?= htmlspecialchars($product['brand'] ?? 'N/A') ?></span>
                            </p>
                            
                            <?php if ($firstVariant): ?>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-hdd text-info"></i> <?= htmlspecialchars($firstVariant['storage']) ?> | 
                                <i class="bi bi-palette text-warning"></i> <?= htmlspecialchars($firstVariant['color']) ?>
                            </p>
                            <?php endif; ?>
                            <div class="mb-2">
                                <?php if ($minPrice > 0): ?>
                                    <?php if ($minPrice == $maxPrice): ?>
                                    <p class="product-price text-danger fw-bold fs-5 mb-0">
                                        <?= number_format($minPrice, 0, ',', '.') ?>₫
                                    </p>
                                    <?php else: ?>
                                    <p class="product-price text-danger fw-bold fs-6 mb-0">
                                        Từ <?= number_format($minPrice, 0, ',', '.') ?>₫
                                    </p>
                                    <p class="text-muted small mb-0">
                                        Đến <?= number_format($maxPrice, 0, ',', '.') ?>₫
                                    </p>
                                    <?php endif; ?>
                                <?php else: ?>
                                <p class="text-danger small mb-0 fw-bold">
                                    <i class="bi bi-x-circle"></i> Hết hàng
                                </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="product-actions p-3 border-top bg-light">
                            <div class="d-flex gap-2">
                                <a href="<?= BASE_URL ?>product/detail/<?= $product['product_id'] ?>" class="btn btn-sm btn-outline-primary flex-grow-1">
                                    <i class="bi bi-eye"></i> Chi tiết
                                </a>
                                <?php if ($firstVariant && $firstVariant['stock_quantity'] > 0): ?>
                                <form method="POST" action="<?= BASE_URL ?>cart/add" class="d-inline">
                                    <input type="hidden" name="variant_id" value="<?= $firstVariant['variant_id'] ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-sm btn-primary" title="Thêm vào giỏ hàng">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                </form>
                                <?php else: ?>
                                <button class="btn btn-sm btn-secondary" disabled title="Hết hàng">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.product-card {
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.15) !important;
}

.product-image-wrapper {
    position: relative;
    overflow: hidden;
}

.product-image {
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.product-card:hover .product-image {
    transform: scale(1.08);
}

.product-card:hover {
    border-color: #0d6efd;
}

.product-name {
    min-height: 40px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
