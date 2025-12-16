<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<style>
.search-hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 60px 0;
    margin-bottom: 30px;
    border-radius: 0 0 30px 30px;
}
.search-hero-section .search-box {
    max-width: 700px;
    margin: 0 auto;
}
.search-hero-section .search-input-group {
    position: relative;
    background: white;
    border-radius: 50px;
    padding: 5px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}
.search-hero-section .search-input-group input {
    border: none;
    padding: 15px 25px;
    font-size: 1.1rem;
    border-radius: 50px;
}
.search-hero-section .search-input-group input:focus {
    outline: none;
    box-shadow: none;
}
.search-hero-section .search-input-group button {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    border: none;
    background: #dc3545;
    color: white;
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s;
}
.search-hero-section .search-input-group button:hover {
    background: #c82333;
    transform: translateY(-50%) scale(1.05);
}
.search-results-header {
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin-bottom: 25px;
}
.filter-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin-bottom: 20px;
    border: none;
    overflow: hidden;
}
.filter-card .card-header {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    border: none;
    padding: 15px 20px;
    font-weight: 600;
}
.filter-card .card-body {
    padding: 20px;
}
.sort-section {
    background: white;
    padding: 15px 20px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin-bottom: 25px;
}
.empty-search {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}
.empty-search-icon {
    font-size: 6rem;
    color: #dee2e6;
    margin-bottom: 20px;
}
.price-range-inputs {
    display: flex;
    gap: 10px;
    align-items: center;
}
.price-range-inputs input {
    flex: 1;
    padding: 8px 12px;
    border: 2px solid #dee2e6;
    border-radius: 8px;
}
.price-range-inputs input:focus {
    border-color: #dc3545;
    outline: none;
}
.list-group-item {
    transition: all 0.3s ease;
    border: none;
    border-left: 3px solid transparent;
    padding: 12px 15px;
    cursor: pointer;
}
.list-group-item:hover {
    background: #f8f9fa;
    border-left-color: #dc3545;
    padding-left: 20px;
}
.list-group-item.active {
    background: #fff5f5;
    border-left-color: #dc3545;
    color: #dc3545;
    font-weight: 600;
}
.brand-badge {
    display: inline-block;
    padding: 8px 15px;
    margin: 5px 5px 5px 0;
    border-radius: 20px;
    background: #f8f9fa;
    border: 2px solid #dee2e6;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 0.9rem;
    text-decoration: none;
    color: #333;
}
.brand-badge:hover {
    background: #dc3545;
    color: white !important;
    border-color: #dc3545;
    transform: translateY(-2px);
}
.brand-badge.active {
    background: #dc3545;
    color: white !important;
    border-color: #dc3545;
}
</style>


    <!-- Search Results Header -->
    <div class="search-results-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="mb-1 fw-bold">
                    Kết quả tìm kiếm: "<span class="text-danger"><?= htmlspecialchars($keyword) ?></span>"
                </h3>
                <p class="text-muted mb-0">
                    <i class="bi bi-box-seam me-1"></i>
                    Tìm thấy <strong class="text-danger"><?= $totalProducts ?></strong> sản phẩm
                </p>
            </div>
            <div class="sort-section">
                <form method="GET" action="<?= BASE_URL ?>product/search" id="sortForm">
                    <input type="hidden" name="keyword" value="<?= htmlspecialchars($keyword) ?>">
                    <?php foreach ($filters as $key => $value): ?>
                        <?php if (is_array($value)): ?>
                            <?php foreach ($value as $v): ?>
                                <input type="hidden" name="<?= htmlspecialchars($key) ?>[]" value="<?= htmlspecialchars($v) ?>">
                            <?php endforeach; ?>
                        <?php else: ?>
                            <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <div class="d-flex align-items-center gap-2">
                        <label class="mb-0 fw-bold text-muted">Sắp xếp:</label>
                        <select name="sort" class="form-select form-select-sm" style="width: auto;" onchange="document.getElementById('sortForm').submit()">
                            <option value="newest" <?= $sort == 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                            <option value="price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Giá: Thấp → Cao</option>
                            <option value="price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Giá: Cao → Thấp</option>
                            <option value="name_asc" <?= $sort == 'name_asc' ? 'selected' : '' ?>>Tên: A → Z</option>
                            <option value="name_desc" <?= $sort == 'name_desc' ? 'selected' : '' ?>>Tên: Z → A</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 d-none d-lg-block">
            <form method="GET" action="<?= BASE_URL ?>product/search" id="filterForm">
                <input type="hidden" name="keyword" value="<?= htmlspecialchars($keyword) ?>">
                
                <!-- Categories -->
                <div class="card shadow-sm filter-card border-0">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i> Danh Mục</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="?keyword=<?= urlencode($keyword) ?>" 
                           class="list-group-item list-group-item-action <?= empty($filters['category_id']) ? 'active' : '' ?>">
                            <i class="bi bi-grid me-2"></i> Tất Cả
                        </a>
                        <?php foreach ($categories as $category): ?>
                        <a href="?keyword=<?= urlencode($keyword) ?>&category_id=<?= $category['category_id'] ?>" 
                           class="list-group-item list-group-item-action <?= (isset($filters['category_id']) && $filters['category_id'] == $category['category_id']) ? 'active' : '' ?>">
                            <i class="bi bi-phone me-2"></i> <?= htmlspecialchars($category['category_name']) ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Brands -->
                <div class="card shadow-sm filter-card border-0">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-tags me-2"></i> Thương Hiệu</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap">
                            <a href="?keyword=<?= urlencode($keyword) ?>" 
                               class="brand-badge <?= empty($filters['brand']) ? 'active' : '' ?>">
                                Tất cả
                            </a>
                            <?php if (!empty($brands)): ?>
                                <?php foreach ($brands as $brand): ?>
                                <a href="?keyword=<?= urlencode($keyword) ?>&brand=<?= urlencode($brand) ?>" 
                                   class="brand-badge <?= (isset($filters['brand']) && $filters['brand'] == $brand) ? 'active' : '' ?>">
                                    <?= htmlspecialchars($brand) ?>
                                </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Price Range -->
                <div class="card shadow-sm filter-card border-0">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-currency-dollar me-2"></i> Khoảng Giá</h5>
                    </div>
                    <div class="card-body">
                        <div class="price-range-inputs mb-3">
                            <input type="number" name="min_price" class="form-control" 
                                   placeholder="Từ" 
                                   value="<?= $filters['min_price'] ?? '' ?>"
                                   min="0">
                            <span class="text-muted">-</span>
                            <input type="number" name="max_price" class="form-control" 
                                   placeholder="Đến" 
                                   value="<?= $filters['max_price'] ?? '' ?>"
                                   min="0">
                        </div>
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="bi bi-funnel me-1"></i> Áp Dụng
                        </button>
                    </div>
                </div>

                <!-- In Stock -->
                <div class="card shadow-sm filter-card border-0">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="in_stock" value="1" 
                                   id="inStock" <?= (isset($filters['in_stock']) && $filters['in_stock']) ? 'checked' : '' ?>
                                   onchange="document.getElementById('filterForm').submit()">
                            <label class="form-check-label" for="inStock">
                                <i class="bi bi-check-circle me-1"></i> Chỉ hiển thị còn hàng
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Clear Filters -->
                <?php if (!empty($filters)): ?>
                <a href="?keyword=<?= urlencode($keyword) ?>" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-x-circle me-2"></i> Xóa Bộ Lọc
                </a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <?php if (empty($products)): ?>
                <div class="empty-search">
                    <i class="bi bi-search empty-search-icon"></i>
                    <h3 class="fw-bold mb-3">Không tìm thấy sản phẩm nào</h3>
                    <p class="text-muted mb-4">
                        Không có sản phẩm nào khớp với từ khóa "<strong><?= htmlspecialchars($keyword) ?></strong>"
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="<?= BASE_URL ?>product/index" class="btn btn-primary btn-lg">
                            <i class="bi bi-grid me-2"></i> Xem Tất Cả Sản Phẩm
                        </a>
                        <a href="<?= BASE_URL ?>home/index" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-house me-2"></i> Về Trang Chủ
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="row g-3" id="productsGrid">
                    <?php 
                    require_once __DIR__ . '/../../models/ProductModel.php';
                    $productModel = new ProductModel();
                    foreach ($products as $product): 
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
                        
                        include __DIR__ . '/product_card_home.php';
                    endforeach; 
                    ?>
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
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
