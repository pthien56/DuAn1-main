<?php require_once __DIR__ . '/header.php'; ?>

<main>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Điện thoại chính hãng giá tốt nhất</h1>
                    <p>Khám phá bộ sưu tập điện thoại từ các thương hiệu hàng đầu</p>
                    <div class="hero-buttons">
                        <a href="<?php echo baseUrl('products.php'); ?>" class="btn btn-primary">Mua ngay</a>
                        <a href="<?php echo baseUrl('products.php'); ?>" class="btn btn-secondary">Xem thêm</a>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="<?php echo assetUrl('images/hero-phones.png'); ?>" alt="Điện thoại" onerror="this.style.display='none'">
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Brands -->
    <section class="featured-brands">
        <div class="container">
            <div class="section-header">
                <h2>Thương hiệu nổi bật</h2>
                <button class="collapse-btn"><i class="fas fa-chevron-up"></i></button>
            </div>
            <div class="brands-grid">
                <a href="<?php echo baseUrl('products.php?brand=Samsung'); ?>" class="brand-item">
                    <div class="brand-icon">S</div>
                    <span>Samsung</span>
                </a>
                <a href="<?php echo baseUrl('products.php?brand=Apple'); ?>" class="brand-item">
                    <div class="brand-icon">🍎</div>
                    <span>Apple</span>
                </a>
                <a href="<?php echo baseUrl('products.php?brand=Xiaomi'); ?>" class="brand-item">
                    <div class="brand-icon">X</div>
                    <span>Xiaomi</span>
                </a>
                <a href="<?php echo baseUrl('products.php?brand=OPPO'); ?>" class="brand-item">
                    <div class="brand-icon">O</div>
                    <span>Oppo</span>
                </a>
                <a href="<?php echo baseUrl('products.php?brand=Vivo'); ?>" class="brand-item">
                    <div class="brand-icon">V</div>
                    <span>Vivo</span>
                </a>
                <a href="<?php echo baseUrl('products.php?brand=Huawei'); ?>" class="brand-item">
                    <div class="brand-icon">H</div>
                    <span>Huawei</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products">
        <div class="container">
            <div class="section-header">
                <h2>Sản phẩm nổi bật</h2>
                <a href="<?php echo baseUrl('products.php'); ?>" class="view-all-link">
                    Xem tất cả <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="products-scroll">
                <?php if (!empty($featuredProducts)): ?>
                    <?php foreach ($featuredProducts as $product): ?>
                        <a href="<?php echo baseUrl('product-detail.php?id=' . $product['variant_id']); ?>" class="product-card">
                            <div class="product-image">
                                <img src="<?php echo assetUrl('images/products/' . $product['variant_id'] . '.jpg'); ?>" 
                                     alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                                     onerror="this.src='<?php echo assetUrl('images/placeholder.jpg'); ?>'">
                            </div>
                            <div class="product-info">
                                <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                                <p class="product-specs">
                                    <?php 
                                    $specs = [];
                                    if (!empty($product['storage'])) $specs[] = $product['storage'];
                                    if (!empty($product['color'])) $specs[] = $product['color'];
                                    echo htmlspecialchars(implode(' - ', $specs));
                                    ?>
                                </p>
                                <p class="product-price"><?php echo formatCurrency($product['price']); ?></p>
                                <button class="btn-cart-icon" onclick="event.preventDefault(); event.stopPropagation(); addToCart(<?php echo $product['variant_id']; ?>)">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Chưa có sản phẩm nào.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Promotional Banners -->
    <section class="promo-banners">
        <div class="container">
            <div class="banners-grid">
                <div class="promo-banner promo-discount">
                    <div class="promo-content">
                        <h3>Giảm 20% cho đơn hàng đầu tiên</h3>
                        <p>Áp dụng tất cả sản phẩm cho iPhone và Samsung</p>
                        <a href="<?php echo baseUrl('products.php'); ?>" class="btn btn-black">Mua ngay</a>
                    </div>
                    <div class="promo-badge">20% OFF</div>
                </div>
                <div class="promo-banner promo-installment">
                    <div class="promo-content">
                        <h3>Trả góp 0% lãi suất</h3>
                        <p>Mua điện thoại cao cấp không cần trả trước</p>
                        <a href="#" class="btn btn-black">Tìm hiểu</a>
                    </div>
                    <div class="promo-badge">0% APR</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section">
        <div class="container">
            <h2>Dịch vụ của chúng tôi</h2>
            <div class="services-grid">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h3>Giao hàng miễn phí</h3>
                    <p>Miễn phí giao hàng cho đơn từ 5 triệu</p>
                </div>
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Bảo hành chính hãng</h3>
                    <p>Bảo hành 12-24 tháng tùy sản phẩm</p>
                </div>
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <h3>Đổi trả 30 ngày</h3>
                    <p>Đổi trả miễn phí trong 30 ngày</p>
                </div>
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Hỗ trợ 24/7</h3>
                    <p>Tư vấn và hỗ trợ mọi lúc</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>
