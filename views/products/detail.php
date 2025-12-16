<div class="product-detail-page">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>home/index">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>product/index">Sản phẩm</a></li>
            <?php if (!empty($product['category_name'])): ?>
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>product/category/<?= $product['category_id'] ?>"><?= htmlspecialchars($product['category_name']) ?></a></li>
            <?php endif; ?>
            <li class="breadcrumb-item active"><?= htmlspecialchars($product['product_name']) ?></li>
        </ol>
    </nav>

    <div class="row mb-5">
        <!-- Left: Product Images -->
        <div class="col-lg-5 col-md-6 mb-4">
            <div class="product-images-wrapper">
                <div class="main-image-container mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 text-center" style="background: #f8f9fa; min-height: 500px; display: flex; align-items: center; justify-content: center;">
                            <?php 
                                $imgUrl = BASE_URL . "public/data/" . rawurlencode($product['product_name'] ?? 'default') . ".jpg";
                            ?>
                            <img src="<?= $imgUrl ?>" 
                                 alt="<?= htmlspecialchars($product['product_name']) ?>" 
                                 class="img-fluid main-product-image" 
                                 id="mainProductImage"
                                 style="max-height: 450px; max-width: 100%; object-fit: contain; cursor: zoom-in;"
                                 onerror="this.src='https://placehold.co/500x500?text=<?= urlencode($product['product_name']) ?>'">
                        </div>
                    </div>
                </div>
                
                <!-- Thumbnail Gallery (nếu có nhiều ảnh) -->
                <div class="thumbnail-gallery d-flex gap-2 justify-content-center">
                    <div class="thumbnail-item active" data-image="<?= $imgUrl ?>">
                        <img src="<?= $imgUrl ?>" alt="Thumbnail" class="img-fluid rounded border" 
                             style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                             onerror="this.style.display='none'">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right: Product Info -->
        <div class="col-lg-7 col-md-6">
            <div class="product-info">
                <!-- Brand & Category Badges -->
                <div class="mb-3">
                    <?php if (!empty($product['brand'])): ?>
                        <span class="badge bg-danger me-2 px-3 py-2">
                            <i class="bi bi-tag-fill"></i> <?= htmlspecialchars($product['brand']) ?>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($product['category_name'])): ?>
                        <span class="badge bg-secondary me-2 px-3 py-2">
                            <i class="bi bi-grid"></i> <?= htmlspecialchars($product['category_name']) ?>
                        </span>
                    <?php endif; ?>
                </div>
                
                <!-- Product Name -->
                <h1 class="product-name fw-bold mb-3" style="font-size: 2rem; color: #212529; line-height: 1.3;">
                    <?= htmlspecialchars($product['product_name']) ?>
                </h1>
                
                <!-- Rating & Reviews -->
                <?php if ($reviewStats && $reviewStats['total_reviews'] > 0): ?>
                    <div class="d-flex align-items-center mb-3">
                        <div class="rating-display me-3">
                            <?php 
                                $avgRating = round($reviewStats['average_rating']);
                                for ($i = 1; $i <= 5; $i++): 
                            ?>
                                <i class="bi bi-star<?= $i <= $avgRating ? '-fill' : '' ?> text-warning" style="font-size: 1.2rem;"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="text-muted">
                            <strong class="text-dark"><?= number_format($reviewStats['average_rating'], 1) ?></strong>
                            (<?= $reviewStats['total_reviews'] ?> đánh giá)
                        </span>
                    </div>
                <?php else: ?>
                    <div class="mb-3">
                        <span class="text-muted">
                            <i class="bi bi-star text-warning"></i> Chưa có đánh giá
                        </span>
                    </div>
                <?php endif; ?>
                
                <hr class="my-4">
                
                <!-- Price Section -->
                <?php if (!empty($variants)): ?>
                    <?php 
                        $firstVariant = $variants[0];
                        $minPrice = min(array_column($variants, 'price'));
                        $maxPrice = max(array_column($variants, 'price'));
                        $discountPercent = rand(5, 15);
                        $oldPrice = round($minPrice / (1 - $discountPercent / 100));
                    ?>
                    <div class="price-section mb-4">
                        <div class="d-flex align-items-baseline gap-3 mb-2">
                            <span class="current-price text-danger fw-bold" style="font-size: 2.5rem;">
                                <?= number_format($minPrice, 0, ',', '.') ?>₫
                            </span>
                            <?php if ($minPrice < $oldPrice): ?>
                                <del class="old-price text-muted" style="font-size: 1.5rem;">
                                    <?= number_format($oldPrice, 0, ',', '.') ?>₫
                                </del>
                                <span class="badge bg-danger px-3 py-2" style="font-size: 1rem;">
                                    -<?= $discountPercent ?>%
                                </span>
                            <?php endif; ?>
                        </div>
                        <?php if ($minPrice != $maxPrice): ?>
                            <p class="text-muted mb-0">
                                <small>Giá từ <?= number_format($minPrice, 0, ',', '.') ?>₫ đến <?= number_format($maxPrice, 0, ',', '.') ?>₫</small>
                            </p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Promotions -->
                    <div class="promotions-box mb-4 p-3 rounded" style="background: #fff3cd; border: 1px solid #ffc107;">
                        <h6 class="fw-bold mb-2">
                            <i class="bi bi-gift-fill text-danger me-2"></i> Ưu Đãi Đặc Biệt
                        </h6>
                        <ul class="mb-0" style="list-style: none; padding: 0;">
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <strong>Smember giảm đến <?= rand(3, 8) ?>%</strong> - Đăng ký thành viên ngay!
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <strong>Trả góp 0%</strong> - 0₫ phụ thu - 0₫ trả trước - kỳ hạn đến 12 tháng
                            </li>
                            <li class="mb-0">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <strong>Miễn phí vận chuyển</strong> cho đơn hàng từ 300.000₫
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <hr class="my-4">
                
                <!-- Variant Selection -->
                <?php if (empty($variants)): ?>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Sản phẩm hiện đang hết hàng. Vui lòng quay lại sau!
                    </div>
                <?php else: ?>
                    <form id="addToCartForm" method="POST" action="<?= BASE_URL ?>cart/add">
                        <div class="variant-selection mb-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-list-ul text-primary me-2"></i> Chọn Phiên Bản
                            </h5>
                            
                            <div class="variants-list">
                                <?php foreach ($variants as $index => $variant): ?>
                                    <?php 
                                        $variantDiscount = rand(5, 15);
                                        $variantOldPrice = round($variant['price'] / (1 - $variantDiscount / 100));
                                    ?>
                                    <div class="variant-card mb-3 border rounded p-3 position-relative" 
                                         data-variant-id="<?= $variant['variant_id'] ?>"
                                         style="cursor: pointer; transition: all 0.3s; background: #fff;">
                                        <div class="form-check m-0">
                                            <input class="form-check-input" type="radio" name="variant_id" 
                                                   id="variant_<?= $variant['variant_id'] ?>" 
                                                   value="<?= $variant['variant_id'] ?>" 
                                                   data-price="<?= $variant['price'] ?>"
                                                   data-stock="<?= $variant['stock_quantity'] ?>"
                                                   <?= $index === 0 ? 'checked' : '' ?> 
                                                   <?= $variant['stock_quantity'] == 0 ? 'disabled' : '' ?>
                                                   required>
                                            <label class="form-check-label w-100" for="variant_<?= $variant['variant_id'] ?>" style="cursor: pointer;">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <strong class="d-block mb-2" style="font-size: 1.1rem;">
                                                            <?= htmlspecialchars($variant['variant_name']) ?>
                                                        </strong>
                                                        <div class="variant-specs mb-2">
                                                            <span class="badge bg-light text-dark me-2">
                                                                <i class="bi bi-palette"></i> <?= htmlspecialchars($variant['color']) ?>
                                                            </span>
                                                            <span class="badge bg-light text-dark me-2">
                                                                <i class="bi bi-hdd"></i> <?= htmlspecialchars($variant['storage']) ?>
                                                            </span>
                                                            <span class="badge bg-light text-dark">
                                                                <i class="bi bi-shield-check"></i> Bảo hành <?= $variant['warranty_months'] ?> tháng
                                                            </span>
                                                        </div>
                                                        <?php if ($variant['stock_quantity'] > 0 && $variant['stock_quantity'] <= 5): ?>
                                                            <small class="text-warning d-block">
                                                                <i class="bi bi-exclamation-triangle"></i> 
                                                                Chỉ còn <?= $variant['stock_quantity'] ?> sản phẩm
                                                            </small>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="text-end ms-3">
                                                        <div class="price-info">
                                                            <div class="d-flex align-items-baseline justify-content-end gap-2 mb-1">
                                                                <span class="text-danger fw-bold" style="font-size: 1.5rem;">
                                                                    <?= number_format($variant['price'], 0, ',', '.') ?>₫
                                                                </span>
                                                                <?php if ($variant['price'] < $variantOldPrice): ?>
                                                                    <del class="text-muted small">
                                                                        <?= number_format($variantOldPrice, 0, ',', '.') ?>₫
                                                                    </del>
                                                                <?php endif; ?>
                                                            </div>
                                                            <span class="badge bg-<?= $variant['stock_quantity'] > 10 ? 'success' : ($variant['stock_quantity'] > 0 ? 'warning' : 'danger') ?> d-block">
                                                                <?= $variant['stock_quantity'] > 0 ? '✓ Còn hàng' : '✗ Hết hàng' ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <!-- Quantity Selection -->
                        <div class="quantity-selection mb-4">
                            <label for="quantity" class="form-label fw-bold mb-2">
                                <i class="bi bi-123 me-2"></i> Số Lượng
                            </label>
                            <div class="input-group" style="max-width: 200px;">
                                <button class="btn btn-outline-secondary" type="button" id="decreaseQty">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" class="form-control text-center fw-bold" 
                                       id="quantity" name="quantity" 
                                       value="1" min="1" max="10" required
                                       style="font-size: 1.1rem;">
                                <button class="btn btn-outline-secondary" type="button" id="increaseQty">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle"></i> Số lượng tối đa: 10 sản phẩm
                            </small>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <?php if (isset($_SESSION['customer_id'])): ?>
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-outline-danger btn-lg w-100 py-3 fw-bold" style="font-size: 1rem;">
                                            <i class="bi bi-cart-plus me-2"></i> Thêm Giỏ Hàng
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" name="buy_now" value="1" class="btn btn-danger btn-lg w-100 py-3 fw-bold" style="font-size: 1rem;">
                                            <i class="bi bi-lightning-fill me-2"></i> Mua Ngay
                                        </button>
                                    </div>
                                </div>
                            <?php else: ?>
                                <a href="<?= BASE_URL ?>auth/login" class="btn btn-danger btn-lg w-100 mb-3 py-3 fw-bold" style="font-size: 1.1rem;">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> Đăng Nhập Để Mua Hàng
                                </a>
                                <div class="alert alert-info mb-2">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <small>Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng</small>
                                </div>
                            <?php endif; ?>
                            <a href="<?= BASE_URL ?>product/index" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-arrow-left me-2"></i> Tiếp Tục Mua Sắm
                            </a>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Product Description & Details -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <ul class="nav nav-tabs border-0" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                                <i class="bi bi-file-text me-2"></i> Mô Tả Sản Phẩm
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab">
                                <i class="bi bi-list-check me-2"></i> Thông Số Kỹ Thuật
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="warranty-tab" data-bs-toggle="tab" data-bs-target="#warranty" type="button" role="tab">
                                <i class="bi bi-shield-check me-2"></i> Bảo Hành & Dịch Vụ
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <?php if (!empty($product['description'])): ?>
                                <div style="line-height: 1.8; font-size: 1rem;">
                                    <?= nl2br(htmlspecialchars($product['description'])) ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">Sản phẩm chất lượng cao, chính hãng, bảo hành đầy đủ. Liên hệ để biết thêm chi tiết.</p>
                            <?php endif; ?>
                        </div>
                        <div class="tab-pane fade" id="specs" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold" style="width: 40%;">Thương hiệu:</td>
                                                <td><?= htmlspecialchars($product['brand'] ?? 'N/A') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Danh mục:</td>
                                                <td><?= htmlspecialchars($product['category_name'] ?? 'N/A') ?></td>
                                            </tr>
                                            <?php if (!empty($variants)): ?>
                                                <tr>
                                                    <td class="fw-bold">Màu sắc:</td>
                                                    <td>
                                                        <?php 
                                                            $colors = array_unique(array_column($variants, 'color'));
                                                            echo htmlspecialchars(implode(', ', $colors));
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Dung lượng:</td>
                                                    <td>
                                                        <?php 
                                                            $storages = array_unique(array_column($variants, 'storage'));
                                                            echo htmlspecialchars(implode(', ', $storages));
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="warranty" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3">Chính Sách Bảo Hành</h6>
                                    <ul>
                                        <li>Bảo hành chính hãng từ nhà sản xuất</li>
                                        <li>Thời gian bảo hành: 12-24 tháng tùy sản phẩm</li>
                                        <li>Bảo hành tại các trung tâm ủy quyền</li>
                                        <li>Hỗ trợ đổi trả trong 7 ngày đầu</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3">Dịch Vụ Hỗ Trợ</h6>
                                    <ul>
                                        <li>Miễn phí vận chuyển toàn quốc</li>
                                        <li>Hỗ trợ kỹ thuật 24/7</li>
                                        <li>Thanh toán linh hoạt: Tiền mặt, Chuyển khoản, Trả góp</li>
                                        <li>Tư vấn miễn phí trước khi mua</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reviews Section -->
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-12">
            <h3 class="fw-bold mb-4 border-bottom pb-3">
                <i class="bi bi-star-fill text-warning me-2"></i> Đánh Giá & Bình Luận
            </h3>
            
            <!-- Review Stats -->
            <?php if ($reviewStats && $reviewStats['total_reviews'] > 0): ?>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card shadow-sm text-center p-4">
                        <div class="display-4 fw-bold text-primary mb-2">
                            <?= number_format($reviewStats['average_rating'], 1) ?>
                        </div>
                        <div class="mb-2">
                            <?php 
                                $avgRating = round($reviewStats['average_rating']);
                                for ($i = 1; $i <= 5; $i++): 
                            ?>
                                <i class="bi bi-star<?= $i <= $avgRating ? '-fill' : '' ?> text-warning" style="font-size: 1.5rem;"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="text-muted mb-0">Dựa trên <?= $reviewStats['total_reviews'] ?> đánh giá</p>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card shadow-sm p-4">
                        <h6 class="fw-bold mb-3">Phân Bố Đánh Giá</h6>
                        <?php for ($i = 5; $i >= 1; $i--): 
                            $count = $reviewStats['rating_' . $i] ?? 0;
                            $percentage = $reviewStats['total_reviews'] > 0 ? ($count / $reviewStats['total_reviews']) * 100 : 0;
                        ?>
                        <div class="mb-2">
                            <div class="d-flex align-items-center">
                                <span class="me-2" style="width: 60px;">
                                    <?= $i ?> <i class="bi bi-star-fill text-warning"></i>
                                </span>
                                <div class="progress flex-grow-1 me-2" style="height: 20px;">
                                    <div class="progress-bar bg-warning" role="progressbar" 
                                         style="width: <?= $percentage ?>%"></div>
                                </div>
                                <span class="text-muted small" style="width: 50px; text-align: right;">
                                    <?= $count ?>
                                </span>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle me-2"></i>
                Chưa có đánh giá nào cho sản phẩm này. Hãy là người đầu tiên đánh giá!
            </div>
            <?php endif; ?>
            
            <!-- Add Review Form -->
            <?php if (isset($_SESSION['customer_id'])): ?>
                <?php if ($hasReviewed): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>
                    Bạn đã đánh giá sản phẩm này rồi. Cảm ơn bạn đã chia sẻ!
                </div>
                <?php elseif (!$hasPurchased): ?>
                <div class="alert alert-info">
                    <i class="bi bi-bag-check me-2"></i>
                    <strong>Bạn cần mua sản phẩm này để có thể đánh giá.</strong>
                    <br><small class="text-muted">Chỉ khách hàng đã mua và nhận hàng thành công mới có thể viết đánh giá.</small>
                </div>
                <?php else: ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Viết Đánh Giá</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success mb-3">
                            <i class="bi bi-patch-check me-2"></i>
                            <strong>Đã xác nhận mua hàng</strong> - Bạn có thể đánh giá sản phẩm này
                        </div>
                        <form method="POST" action="<?= BASE_URL ?>review/create" id="reviewForm">
                            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                            <input type="hidden" name="rating" id="rating" value="5" required>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Đánh Giá <span class="text-danger">*</span></label>
                                <div class="star-rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="bi bi-star-fill star <?= $i <= 5 ? 'active' : '' ?>" 
                                           data-rating="<?= $i ?>" 
                                           style="font-size: 2rem; color: #ffc107; cursor: pointer; margin-right: 5px;"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="comment" class="form-label fw-bold">Bình Luận</label>
                                <textarea class="form-control" id="comment" name="comment" rows="4" 
                                          placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này..."></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-2"></i> Gửi Đánh Giá
                            </button>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
            <?php else: ?>
            <div class="alert alert-warning">
                <i class="bi bi-info-circle me-2"></i>
                <a href="<?= BASE_URL ?>auth/login" class="alert-link">Đăng nhập</a> để viết đánh giá và bình luận.
            </div>
            <?php endif; ?>
            
            <!-- Reviews List -->
            <div class="mt-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-chat-dots me-2"></i> 
                    Tất Cả Đánh Giá (<?= count($reviews) ?>)
                </h5>
                
                <?php if (empty($reviews)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                    <p class="text-muted">Chưa có đánh giá nào</p>
                </div>
                <?php else: ?>
                <div class="reviews-list">
                    <?php foreach ($reviews as $review): ?>
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold mb-1">
                                        <i class="bi bi-person-circle me-2"></i>
                                        <?= htmlspecialchars($review['full_name'] ?? 'Khách hàng') ?>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>
                                        <?= date('d/m/Y H:i', strtotime($review['created_at'])) ?>
                                    </small>
                                </div>
                                <div class="text-end">
                                    <div class="mb-1">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="bi bi-star<?= $i <= $review['rating'] ? '-fill' : '' ?> text-warning"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="badge bg-primary"><?= $review['rating'] ?>/5</span>
                                </div>
                            </div>
                            <?php if (!empty($review['comment'])): ?>
                            <p class="mb-0 mt-2" style="line-height: 1.6;">
                                <?= nl2br(htmlspecialchars($review['comment'])) ?>
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.product-detail-page {
    padding: 20px 0;
}

.product-images-wrapper .main-image-container {
    position: relative;
}

.main-product-image {
    transition: transform 0.3s;
}

.main-product-image:hover {
    transform: scale(1.05);
}

.thumbnail-item {
    border: 2px solid transparent;
    border-radius: 8px;
    transition: all 0.3s;
    padding: 2px;
}

.thumbnail-item:hover {
    border-color: #dc3545;
}

.thumbnail-item.active {
    border-color: #dc3545;
}

.variant-card {
    transition: all 0.3s;
}

.variant-card:hover {
    border-color: #dc3545 !important;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15);
    transform: translateX(5px);
}

.variant-card input[type="radio"]:checked ~ label {
    color: #dc3545;
}

.variant-card:has(input[type="radio"]:checked) {
    border-color: #dc3545 !important;
    background: #fff5f5 !important;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
}

.variant-card:has(input[type="radio"]:disabled) {
    opacity: 0.6;
    cursor: not-allowed;
    background: #f8f9fa;
}

.promotions-box {
    border-left: 4px solid #ffc107;
}

.nav-tabs .nav-link {
    color: #666;
    border: none;
    padding: 15px 20px;
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

.star-rating .star {
    transition: all 0.2s ease;
}

.star-rating .star.active,
.star-rating .star.hover {
    color: #ffc107 !important;
    transform: scale(1.1);
}

.star-rating .star:not(.active):not(.hover) {
    color: #dee2e6 !important;
}

.reviews-list .card {
    transition: all 0.3s ease;
}

.reviews-list .card:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
}

.quantity-selection .input-group button {
    width: 45px;
    font-weight: bold;
}

.quantity-selection .input-group button:hover {
    background: #dc3545;
    color: white;
    border-color: #dc3545;
}

@media (max-width: 768px) {
    .product-name {
        font-size: 1.5rem !important;
    }
    
    .current-price {
        font-size: 2rem !important;
    }
    
    .variant-card {
        padding: 15px !important;
    }
}
</style>

<script>
$(document).ready(function() {
    // Thumbnail click
    $('.thumbnail-item').on('click', function() {
        const imageUrl = $(this).data('image');
        $('#mainProductImage').attr('src', imageUrl);
        $('.thumbnail-item').removeClass('active');
        $(this).addClass('active');
    });
    
    // Variant selection - update price
    $('input[name="variant_id"]').on('change', function() {
        const price = $(this).data('price');
        const stock = $(this).data('stock');
        
        // Update displayed price
        $('.current-price').text(new Intl.NumberFormat('vi-VN').format(price) + '₫');
        
        // Update max quantity
        $('#quantity').attr('max', Math.min(stock, 10));
        
        // Update variant cards styling
        $('.variant-card').removeClass('border-danger');
        $(this).closest('.variant-card').addClass('border-danger');
    });
    
    // Nút Mua Ngay - submit form bình thường (không AJAX)
    $('button[name="buy_now"]').on('click', function(e) {
        // Cho phép form submit bình thường để chuyển đến trang thanh toán
        $('#addToCartForm').off('submit');
    });
    
    // Add to cart form (chỉ cho nút Thêm Giỏ Hàng)
    $('#addToCartForm').on('submit', function(e) {
        // Nếu nhấn nút Mua Ngay thì submit bình thường
        if ($(document.activeElement).attr('name') === 'buy_now') {
            return true;
        }
        
        e.preventDefault();
        const form = $(this);
        const formData = form.serialize() + '&ajax=1';
        const submitBtn = form.find('button[type="submit"]:not([name="buy_now"])');
        const originalText = submitBtn.html();
        
        // Disable button and show loading
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Đang thêm...');
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Update cart count
                    if ($('#cart-count').length) {
                        $('#cart-count').text(response.cartCount);
                    }
                    
                    // Update localStorage
                    if (typeof CartStorage !== 'undefined' && response.cart) {
                        CartStorage.save(response.cart);
                    }
                    
                    // Show success message
                    const alertHtml = '<div class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999; min-width: 300px;" role="alert">' +
                        '<i class="bi bi-check-circle me-2"></i>' + response.message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>';
                    $('body').append(alertHtml);
                    setTimeout(function() {
                        $('.alert').fadeOut(function() {
                            $(this).remove();
                        });
                    }, 3000);
                } else {
                    if (response.requireLogin) {
                        if (confirm(response.message + '\n\nBạn có muốn chuyển đến trang đăng nhập không?')) {
                            window.location.href = response.loginUrl;
                        }
                    } else {
                        alert(response.message);
                    }
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    const response = xhr.responseJSON;
                    if (response && response.requireLogin) {
                        if (confirm(response.message + '\n\nBạn có muốn chuyển đến trang đăng nhập không?')) {
                            window.location.href = response.loginUrl;
                        }
                    } else {
                        alert('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng');
                    }
                } else {
                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
    
    // Quantity controls
    $('#increaseQty').on('click', function() {
        const qtyInput = $('#quantity');
        const currentQty = parseInt(qtyInput.val());
        const maxQty = parseInt(qtyInput.attr('max'));
        if (currentQty < maxQty) {
            qtyInput.val(currentQty + 1);
        } else {
            alert('Số lượng tối đa là ' + maxQty);
        }
    });
    
    $('#decreaseQty').on('click', function() {
        const qtyInput = $('#quantity');
        const currentQty = parseInt(qtyInput.val());
        const minQty = parseInt(qtyInput.attr('min'));
        if (currentQty > minQty) {
            qtyInput.val(currentQty - 1);
        }
    });
    
    // Update max quantity when variant changes
    $('input[name="variant_id"]').on('change', function() {
        const stock = $(this).data('stock');
        const maxQty = Math.min(stock, 10);
        $('#quantity').attr('max', maxQty);
        
        if (parseInt($('#quantity').val()) > maxQty) {
            $('#quantity').val(maxQty);
        }
    });
    
    // Star rating
    $('.star-rating .star').on('click', function() {
        const rating = $(this).data('rating');
        $('.star-rating .star').removeClass('active');
        $('.star-rating .star').each(function(index) {
            if (index < rating) {
                $(this).addClass('active');
            }
        });
        $('#rating').val(rating);
    });
    
    $('.star-rating .star').on('mouseenter', function() {
        const rating = $(this).data('rating');
        $('.star-rating .star').removeClass('hover');
        $('.star-rating .star').each(function(index) {
            if (index < rating) {
                $(this).addClass('hover');
            }
        });
    });
    
    $('.star-rating').on('mouseleave', function() {
        const currentRating = $('#rating').val() || 0;
        $('.star-rating .star').removeClass('hover');
        $('.star-rating .star').each(function(index) {
            if (index < currentRating) {
                $(this).addClass('active');
            }
        });
    });
    
    // Initialize - mark first variant as selected
    $('input[name="variant_id"]:checked').closest('.variant-card').addClass('border-danger');
    
    // Image zoom on click
    $('#mainProductImage').on('click', function() {
        if ($(this).css('cursor') === 'zoom-in') {
            $(this).css({
                'transform': 'scale(2)',
                'cursor': 'zoom-out',
                'z-index': '1000',
                'position': 'relative'
            });
        } else {
            $(this).css({
                'transform': 'scale(1)',
                'cursor': 'zoom-in',
                'z-index': 'auto',
                'position': 'static'
            });
        }
    });
});
</script>
