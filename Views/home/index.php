<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main>
    <!-- Hero Section -->
    <section class="bg-light py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-3">Chào mừng đến với Cửa hàng Điện thoại</h1>
                    <p class="lead mb-4">Nơi cung cấp các sản phẩm điện thoại và phụ kiện chính hãng</p>
                    <a href="<?php echo baseUrl('products.php'); ?>" class="btn btn-primary btn-lg">Xem sản phẩm</a>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="<?php echo assetUrl('images/hero-phones.png'); ?>" alt="Hero" class="img-fluid" onerror="this.style.display='none'">
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Danh mục sản phẩm</h2>
            <div class="row g-4">
                <?php foreach ($categories as $category): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h3 class="card-title"><?php echo htmlspecialchars($category['category_name']); ?></h3>
                                <p class="card-text text-muted"><?php echo htmlspecialchars($category['description'] ?? ''); ?></p>
                                <a href="<?php echo baseUrl('products.php?category=' . $category['category_id']); ?>" class="btn btn-outline-primary">Xem sản phẩm</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Sản phẩm nổi bật</h2>
            <div class="row g-4">
                <?php foreach ($featuredProducts as $product): ?>
                    <div class="col-md-6 col-lg-4 col-xl-3">
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
                                <p class="card-text fw-bold text-warning fs-5 mb-3"><?php echo formatCurrency($product['price']); ?></p>
                                <a href="<?php echo baseUrl('product-detail.php?id=' . $product['variant_id']); ?>" class="btn btn-primary mt-auto">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>