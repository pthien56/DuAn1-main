<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="py-4">
    <div class="container">
        <div class="row">
            <!-- Filters Sidebar -->
            <aside class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Bộ lọc</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="<?php echo baseUrl('products.php'); ?>">
                            <div class="mb-3">
                                <label class="form-label">Tìm kiếm:</label>
                                <input type="text" name="search" class="form-control" value="<?php echo htmlspecialchars($filters['search'] ?? ''); ?>" placeholder="Tên sản phẩm, thương hiệu...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Danh mục:</label>
                                <select name="category" class="form-select">
                                    <option value="">Tất cả</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['category_id']; ?>" <?php echo ($filters['category_id'] ?? '') == $cat['category_id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['category_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Thương hiệu:</label>
                                <select name="brand" class="form-select">
                                    <option value="">Tất cả</option>
                                    <?php foreach ($brands as $b): ?>
                                        <option value="<?php echo htmlspecialchars($b['brand']); ?>" <?php echo ($filters['brand'] ?? '') == $b['brand'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($b['brand']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sắp xếp:</label>
                                <select name="sort" class="form-select">
                                    <option value="newest" <?php echo ($filters['sort'] ?? '') == 'newest' ? 'selected' : ''; ?>>Mới nhất</option>
                                    <option value="price_asc" <?php echo ($filters['sort'] ?? '') == 'price_asc' ? 'selected' : ''; ?>>Giá tăng dần</option>
                                    <option value="price_desc" <?php echo ($filters['sort'] ?? '') == 'price_desc' ? 'selected' : ''; ?>>Giá giảm dần</option>
                                    <option value="name" <?php echo ($filters['sort'] ?? '') == 'name' ? 'selected' : ''; ?>>Tên A-Z</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-2">Lọc</button>
                            <a href="<?php echo baseUrl('products.php'); ?>" class="btn btn-outline-secondary w-100">Xóa bộ lọc</a>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="col-md-9">
                <h2 class="mb-4">Sản phẩm</h2>
                <div class="row g-4">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="position-relative">
                                        <img src="<?php echo assetUrl('images/products/' . $product['variant_id'] . '.jpg'); ?>" 
                                             class="card-img-top" 
                                             alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                                             style="height: 200px; object-fit: cover;"
                                             onerror="this.src='<?php echo assetUrl('images/placeholder.jpg'); ?>'">
                                        <button class="btn btn-dark position-absolute bottom-0 end-0 m-2 rounded-circle" 
                                                style="width: 40px; height: 40px;"
                                                onclick="addToCart(<?php echo $product['variant_id']; ?>)"
                                                title="Thêm vào giỏ">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                                        <p class="card-text text-muted small mb-1"><?php echo htmlspecialchars($product['brand']); ?></p>
                                        <p class="card-text text-muted small mb-2"><?php echo htmlspecialchars($product['variant_name']); ?></p>
                                        <p class="card-text fw-bold text-warning fs-5 mb-2"><?php echo formatCurrency($product['price']); ?></p>
                                        <p class="card-text text-muted small mb-3">Còn lại: <?php echo $product['stock_quantity']; ?> sản phẩm</p>
                                        <a href="<?php echo baseUrl('product-detail.php?id=' . $product['variant_id']); ?>" class="btn btn-primary mt-auto">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-info">Không tìm thấy sản phẩm nào.</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>