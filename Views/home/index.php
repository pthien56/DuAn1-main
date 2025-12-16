<?php
// Sử dụng dữ liệu từ controller
$allProducts = $allProducts ?? [];
require_once __DIR__ . '/../../models/ProductModel.php';
$productModel = new ProductModel();
?>

<!-- Hero Banner Carousel -->
<div id="homeHeroCarousel" class="carousel slide home-hero-carousel mb-0" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#homeHeroCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#homeHeroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#homeHeroCarousel" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active">
            <a href="<?= BASE_URL ?>product/index?sort=newest">
                <img src="<?= BASE_URL ?>public/images/banner1.jpg" class="d-block w-100" alt="Banner 1" 
                     style="height: 400px; object-fit: cover;"
                     onerror="this.src='https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=1200&q=80'">
            </a>
        </div>
        
        <!-- Slide 2 -->
        <div class="carousel-item">
            <a href="<?= BASE_URL ?>product/index?sort=price_asc">
                <img src="<?= BASE_URL ?>public/images/banner2.jpg" class="d-block w-100" alt="Banner 2" 
                     style="height: 400px; object-fit: cover;"
                     onerror="this.src='https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=1200&q=80'">
            </a>
        </div>
        
        <!-- Slide 3 -->
        <div class="carousel-item">
            <a href="<?= BASE_URL ?>product/index">
                <img src="<?= BASE_URL ?>public/images/banner3.jpg" class="d-block w-100" alt="Banner 3" 
                     style="height: 400px; object-fit: cover;"
                     onerror="this.src='https://images.unsplash.com/photo-1556656793-08538906a9f8?w=1200&q=80'">
            </a>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#homeHeroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homeHeroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="container-fluid px-0">
    <!-- Navigation Tabs -->
    <div class="nav-tabs-section bg-white border-bottom sticky-top" style="z-index: 100;">
        <div class="container">
            <ul class="nav nav-tabs border-0" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="<?= BASE_URL ?>home/index?category_id=1" class="nav-link fw-bold text-uppercase <?= (!isset($filters['category_id']) || $filters['category_id'] == 1) ? 'active' : '' ?>" id="phone-tab">
                        ĐIỆN THOẠI
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="<?= BASE_URL ?>home/index?category_id=2" class="nav-link fw-bold text-uppercase <?= (isset($filters['category_id']) && $filters['category_id'] == 2) ? 'active' : '' ?>" id="tablet-tab">
                        PHỤ KIỆN
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Sub Categories and Brands -->
    <div class="sub-nav-section bg-white border-bottom">
        <div class="container">
            <div class="tab-content">
                <?php 
                $currentCategoryId = $filters['category_id'] ?? 1;
                $isPhoneTab = ($currentCategoryId == 1);
                $isTabletTab = ($currentCategoryId == 2);
                ?>
                <div class="tab-pane fade <?= $isPhoneTab ? 'show active' : '' ?>" id="phone" role="tabpanel">
                    <!-- Brands -->
                    <div class="brands-scroll mb-3">
                        <div class="d-flex gap-2 align-items-center overflow-x-auto py-2" style="scrollbar-width: none;">
                            <?php 
                            $currentBrand = $filters['brand'] ?? '';
                            $brandsToShow = ['Apple', 'Samsung', 'Xiaomi', 'OPPO', 'TECNO', 'HONOR', 'Nubia', 'Sony', 'Nokia', 'Infinix'];
                            if (!empty($brands)) {
                                $brandsToShow = array_intersect($brandsToShow, $brands);
                            }
                            ?>
                            <a href="<?= BASE_URL ?>home/index?category_id=1" class="brand-badge text-decoration-none px-3 py-1 rounded-pill border <?= empty($currentBrand) && $isPhoneTab ? 'active' : '' ?>">
                                Tất cả
                            </a>
                            <?php foreach ($brandsToShow as $brand): ?>
                                <a href="?category_id=1&brand=<?= urlencode($brand) ?>" 
                                   class="brand-badge text-decoration-none px-3 py-1 rounded-pill border <?= ($currentBrand === $brand && $isPhoneTab) ? 'active' : '' ?>">
                                    <?= htmlspecialchars($brand) ?>
                                </a>
                            <?php endforeach; ?>
                            <a href="<?= BASE_URL ?>product/index?category_id=1" class="text-decoration-none text-primary ms-2 fw-bold">Xem tất cả</a>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane fade <?= $isTabletTab ? 'show active' : '' ?>" id="tablet" role="tabpanel">
                    <!-- Brands -->
                    <div class="brands-scroll mb-3">
                        <div class="d-flex gap-2 align-items-center overflow-x-auto py-2" style="scrollbar-width: none;">
                            <?php 
                            $currentBrand = $filters['brand'] ?? '';
                            $brandsToShow = ['Apple', 'Samsung', 'Xiaomi', 'OPPO', 'TECNO', 'HONOR', 'Nubia', 'Sony', 'Nokia', 'Infinix'];
                            if (!empty($brands)) {
                                $brandsToShow = array_intersect($brandsToShow, $brands);
                            }
                            ?>
                            <a href="<?= BASE_URL ?>home/index?category_id=2" class="brand-badge text-decoration-none px-3 py-1 rounded-pill border <?= empty($currentBrand) && $isTabletTab ? 'active' : '' ?>">
                                Tất cả
                            </a>
                            <?php foreach ($brandsToShow as $brand): ?>
                                <a href="?category_id=2&brand=<?= urlencode($brand) ?>" 
                                   class="brand-badge text-decoration-none px-3 py-1 rounded-pill border <?= ($currentBrand === $brand && $isTabletTab) ? 'active' : '' ?>">
                                    <?= htmlspecialchars($brand) ?>
                                </a>
                            <?php endforeach; ?>
                            <a href="<?= BASE_URL ?>product/index?category_id=2" class="text-decoration-none text-primary ms-2 fw-bold">Xem tất cả</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content: Sidebar + Products Grid -->
    <div class="container mt-4 mb-5">
        <div class="row">
            <!-- Left Sidebar - Promotional Banners Carousel -->
            <div class="col-lg-3 d-none d-lg-block">
                <!-- <div class="promo-sidebar" style="position: sticky; top: 200px;"> -->
                    <!-- Promo Carousel -->
                    <div id="promoCarousel" class="carousel slide promo-carousel" data-bs-ride="carousel" data-bs-interval="4000">
                        <div class="carousel-indicators promo-indicators">
                            <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="2"></button>
                        </div>
                        <div class="carousel-inner rounded overflow-hidden shadow-sm">
                            <!-- Slide 1: Samsung Galaxy S25 Ultra -->
                            <div class="carousel-item active">
                                <a href="<?= BASE_URL ?>product/search?keyword=Samsung+Galaxy+S25" class="d-block">
                                    <img src="<?= BASE_URL ?>public/images/promo-samsung.jpg" class="d-block w-100" alt="Samsung Galaxy S25" 
                                         style="height: 520px; object-fit: cover;"
                                         onerror="this.src='https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=400&q=80'">
                                </a>
                                <div class="text-center p-2 bg-white border-top">
                                    <span class="text-dark fw-semibold" style="font-size: 0.9rem;">Galaxy S25</span>
                                </div>
                            </div>
                            
                            <!-- Slide 2: OPPO Find X9 -->
                            <div class="carousel-item">
                                <a href="<?= BASE_URL ?>product/search?keyword=OPPO+Find" class="d-block">
                                    <img src="<?= BASE_URL ?>public/images/promo-oppo.jpg" class="d-block w-100" alt="OPPO Find X9" 
                                         style="height: 520px; object-fit: cover;"
                                         onerror="this.src='https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=400&q=80'">
                                </a>
                                <div class="text-center p-2 bg-white border-top">
                                    <span class="text-dark fw-semibold" style="font-size: 0.9rem;">OPPO Find X9</span>
                                </div>
                            </div>
                            
                            <!-- Slide 3: iPhone 16 Pro -->
                            <div class="carousel-item">
                                <a href="<?= BASE_URL ?>product/search?keyword=iPhone+16" class="d-block">
                                    <img src="<?= BASE_URL ?>public/images/promo-iphone.jpg" class="d-block w-100" alt="iPhone 16 Pro" 
                                         style="height: 520px; object-fit: cover;"
                                         onerror="this.src='https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=400&q=80'">
                                </a>
                                <div class="text-center p-2 bg-white border-top">
                                    <span class="text-dark fw-semibold" style="font-size: 0.9rem;">iPhone 16 Pro</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Navigation Arrows -->
                        <button class="carousel-control-prev promo-nav" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next promo-nav" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                <!-- </div> -->
            </div>
            
            <!-- Right: Products Grid -->
            <div class="col-lg-9">
                <?php if (!empty($filters['brand']) || (isset($filters['category_id']) && $filters['category_id'] == 2)): ?>
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">
                                <?php if (isset($filters['category_id']) && $filters['category_id'] == 2): ?>
                                    <span class="badge bg-info me-2">PHỤ KIỆN</span>
                                <?php endif; ?>
                                <?php if (!empty($filters['brand'])): ?>
                                    <span class="badge bg-danger me-2"><?= htmlspecialchars($filters['brand']) ?></span>
                                <?php endif; ?>
                                <span class="text-muted small"><?= $totalProducts ?> sản phẩm</span>
                            </h5>
                            <a href="<?= BASE_URL ?>home/index?category_id=<?= $currentCategoryId ?>" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Xóa bộ lọc
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="row g-3" id="productsGrid">
                    <?php if (!empty($allProducts)): ?>
                        <?php foreach ($allProducts as $product): ?>
                            <div class="col-6 col-md-4 col-lg-3">
                                <?php 
                                    // Đảm bảo có đủ dữ liệu
                                    if (!isset($product['min_price']) || $product['min_price'] == 0) {
                                        $variants = $productModel->getProductVariants($product['product_id']);
                                        if ($variants) {
                                            $prices = array_column($variants, 'price');
                                            $product['min_price'] = min($prices);
                                            $product['max_price'] = max($prices);
                                            
                                            if (!isset($product['discount_percent'])) {
                                                $product['discount_percent'] = rand(5, 15);
                                            }
                                            if (!isset($product['old_price']) && $product['min_price'] > 0) {
                                                $product['old_price'] = round($product['min_price'] / (1 - $product['discount_percent'] / 100));
                                            }
                                        }
                                    }
                                    
                                    include __DIR__ . '/../products/product_card_home.php';
                                ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 4rem; color: #dee2e6;"></i>
                                <h4 class="mt-3 mb-2">Không tìm thấy sản phẩm</h4>
                                <p class="text-muted mb-4">Hãy thử tìm kiếm với bộ lọc khác hoặc xem tất cả sản phẩm</p>
                                <a href="<?= BASE_URL ?>home/index" class="btn btn-primary me-2">
                                    <i class="bi bi-arrow-left"></i> Về trang chủ
                                </a>
                                <a href="<?= BASE_URL ?>product/index" class="btn btn-outline-primary">
                                    <i class="bi bi-grid"></i> Xem tất cả sản phẩm
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPages, $page + 2);
                            
                            if ($startPage > 1): ?>
                                <li class="page-item"><a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => 1])) ?>">1</a></li>
                                <?php if ($startPage > 2): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($endPage < $totalPages): ?>
                                <?php if ($endPage < $totalPages - 1): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                                <li class="page-item"><a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $totalPages])) ?>"><?= $totalPages ?></a></li>
                            <?php endif; ?>
                            
                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
/* Hero Banner Carousel */
.home-hero-carousel {
    margin-bottom: 0;
}

.home-hero-carousel .carousel-item {
    height: 400px;
}

.home-hero-carousel .carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

@media (max-width: 768px) {
    .home-hero-carousel .carousel-item {
        height: 250px;
    }
}

.home-hero-carousel .carousel-control-prev,
.home-hero-carousel .carousel-control-next {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.8;
    transition: all 0.3s;
}

.home-hero-carousel .carousel-control-prev {
    left: 20px;
}

.home-hero-carousel .carousel-control-next {
    right: 20px;
}

.home-hero-carousel .carousel-control-prev:hover,
.home-hero-carousel .carousel-control-next:hover {
    background: rgba(255, 255, 255, 0.3);
    opacity: 1;
}

.home-hero-carousel .carousel-indicators {
    bottom: 20px;
}

.home-hero-carousel .carousel-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    border: 2px solid rgba(255, 255, 255, 0.8);
    margin: 0 5px;
}

.home-hero-carousel .carousel-indicators button.active {
    background: #fff;
    border-color: #fff;
}

.nav-tabs .nav-link {
    color: #333;
    border: none;
    padding: 15px 20px;
    position: relative;
}

.nav-tabs .nav-link.active {
    color: #dc3545;
    background: transparent;
    border-bottom: 3px solid #dc3545;
}

.nav-tabs .nav-link:hover {
    color: #dc3545;
    border-color: transparent;
}

.brands-scroll::-webkit-scrollbar {
    display: none;
}

.brand-badge {
    transition: all 0.3s;
    white-space: nowrap;
    color: #333;
}

.brand-badge:hover {
    background: #dc3545;
    color: white !important;
    border-color: #dc3545 !important;
}

.brand-badge.active {
    background: #dc3545;
    color: white !important;
    border-color: #dc3545 !important;
}

.promo-banner {
    transition: transform 0.3s;
}

.promo-banner:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.samsung-banner {
    background: linear-gradient(180deg, #a78bfa 0%, #6b21a8 100%) !important;
}

.oppo-banner {
    background: #ec4899 !important;
}

.promo-banner .btn-danger {
    background: #dc3545;
    border: none;
    transition: all 0.3s;
}

.promo-banner .btn-danger:hover {
    background: #c82333;
    transform: scale(1.02);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.promo-sidebar {
    position: sticky;
    top: 200px;
    max-height: calc(100vh - 220px);
    overflow-y: auto;
}

/* Promo Carousel Styles */
.promo-carousel {
    border-radius: 12px;
    overflow: hidden;
}

.promo-carousel .carousel-inner {
    border-radius: 12px;
}

.promo-carousel .promo-slide {
    transition: all 0.3s ease;
}

.promo-carousel .carousel-item {
    transition: transform 0.6s ease-in-out;
}

.promo-indicators {
    bottom: 50px;
    margin-bottom: 0;
}

.promo-indicators button {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    border: none;
    margin: 0 4px;
}

.promo-indicators button.active {
    background: #fff;
    width: 24px;
    border-radius: 4px;
}

.promo-nav {
    width: 30px;
    height: 30px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0;
    transition: all 0.3s;
}

.promo-carousel:hover .promo-nav {
    opacity: 1;
}

.promo-nav:hover {
    background: rgba(255, 255, 255, 0.5);
}

.promo-nav .carousel-control-prev-icon,
.promo-nav .carousel-control-next-icon {
    width: 16px;
    height: 16px;
}

.iphone-banner {
    background: linear-gradient(180deg, #1e3a5f 0%, #0f172a 100%) !important;
}

@media (max-width: 991px) {
    .promo-sidebar {
        position: relative;
        top: 0;
        max-height: none;
    }
    
    .home-hero-carousel .carousel-item {
        min-height: 350px;
    }
    
    .home-hero-carousel .display-4 {
        font-size: 2rem !important;
    }
    
    .home-hero-carousel .lead {
        font-size: 1rem;
    }
    
    .home-hero-carousel .btn-lg {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    
    .home-hero-carousel .col-lg-6:last-child {
        display: none;
    }
}

/* Animation for product cards */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.product-card-home {
    animation: fadeInUp 0.5s ease-out;
}

/* Smooth scroll */
html {
    scroll-behavior: smooth;
}

/* Loading state */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    display: none;
}

.loading-overlay.active {
    display: flex;
    }
</style>

<script>
// Smooth scroll và loading state
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý filter brand với loading
    document.querySelectorAll('.brand-badge').forEach(function(badge) {
        badge.addEventListener('click', function(e) {
            if (!this.classList.contains('active')) {
                // Show loading
                const loading = document.createElement('div');
                loading.className = 'loading-overlay active';
                loading.innerHTML = '<div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div>';
                document.body.appendChild(loading);
                
                // Scroll to top
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    });
    
    // Lazy load images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        observer.unobserve(img);
                    }
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
});
</script>
