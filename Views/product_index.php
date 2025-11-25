<?php require_once __DIR__ . '/header.php'; ?>

<main>
    <div class="container">
        <div class="products-page">
            <aside class="filters">
                <h3>Bộ lọc</h3>
                <form method="GET" action="<?php echo baseUrl('products.php'); ?>">
                    <div class="filter-group">
                        <label>Tìm kiếm:</label>
                        <input type="text" name="search" class="form-control" value="<?php echo htmlspecialchars($filters['search']); ?>" placeholder="Tên sản phẩm, thương hiệu...">
                    </div>
                    <div class="filter-group">
                        <label>Danh mục:</label>
                        <select name="category" class="form-control">
                            <option value="">Tất cả</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['category_id']; ?>" <?php echo $filters['category_id'] == $cat['category_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['category_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Thương hiệu:</label>
                        <select name="brand" class="form-control">
                            <option value="">Tất cả</option>
                            <?php foreach ($brands as $b): ?>
                                <option value="<?php echo htmlspecialchars($b['brand']); ?>" <?php echo $filters['brand'] == $b['brand'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($b['brand']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Sắp xếp:</label>
                        <select name="sort" class="form-control">
                            <option value="newest" <?php echo $filters['sort'] == 'newest' ? 'selected' : ''; ?>>Mới nhất</option>
                            <option value="price_asc" <?php echo $filters['sort'] == 'price_asc' ? 'selected' : ''; ?>>Giá tăng dần</option>
                            <option value="price_desc" <?php echo $filters['sort'] == 'price_desc' ? 'selected' : ''; ?>>Giá giảm dần</option>
                            <option value="name" <?php echo $filters['sort'] == 'name' ? 'selected' : ''; ?>>Tên A-Z</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Lọc</button>
                    <a href="<?php echo baseUrl('products.php'); ?>" class="btn btn-secondary">Xóa bộ lọc</a>
                </form>
            </aside>

            <div class="products-content">
                <h2>Sản phẩm</h2>
                <div class="product-grid">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product-card">
                                <div class="product-image">
                                    <img src="<?php echo assetUrl('images/products/' . $product['variant_id'] . '.jpg'); ?>" 
                                         alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                                         onerror="this.src='<?php echo assetUrl('images/placeholder.jpg'); ?>'">
                                </div>
                                <div class="product-info">
                                    <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                                    <p class="product-brand"><?php echo htmlspecialchars($product['brand']); ?></p>
                                    <p class="product-variant"><?php echo htmlspecialchars($product['variant_name']); ?></p>
                                    <p class="product-price"><?php echo formatCurrency($product['price']); ?></p>
                                    <p class="product-stock">Còn lại: <?php echo $product['stock_quantity']; ?> sản phẩm</p>
                                    <div class="product-actions">
                                        <a href="<?php echo baseUrl('product-detail.php?id=' . $product['variant_id']); ?>" class="btn btn-primary">Xem chi tiết</a>
                                        <button class="btn btn-cart" onclick="addToCart(<?php echo $product['variant_id']; ?>)">Thêm vào giỏ</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Không tìm thấy sản phẩm nào.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>

