<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<style>
.cart-item-card {
    background: white;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: all 0.3s;
    border: 2px solid transparent;
}
.cart-item-card:hover {
    box-shadow: 0 5px 20px rgba(0,0,0,0.12);
    transform: translateY(-3px);
}
.cart-item-card.selected {
    border-color: #dc3545;
    background: #fff5f5;
    box-shadow: 0 5px 20px rgba(220, 53, 69, 0.15) !important;
}
.cart-item-card.selectable {
    cursor: pointer;
}
.cart-item-card.selectable:hover {
    border-color: #dc3545;
}
.cart-item-card.out-of-stock {
    opacity: 0.6;
    background: #f8f9fa;
}
.product-image-cart {
    width: 120px;
    height: 120px;
    object-fit: contain;
    border-radius: 10px;
    background: #f8f9fa;
    padding: 10px;
    transition: transform 0.3s;
}
.product-image-cart:hover {
    transform: scale(1.05);
}
.quantity-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}
.quantity-btn {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    border: 2px solid #dee2e6;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    position: relative;
    z-index: 10;
}
.quantity-btn:hover:not(:disabled) {
    background: #dc3545;
    border-color: #dc3545;
    color: white;
    transform: scale(1.1);
}
.quantity-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
.quantity-btn i,
.remove-btn i {
    pointer-events: none;
}
.quantity-controls {
    position: relative;
    z-index: 10;
}
.quantity-input-cart {
    width: 60px;
    text-align: center;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    padding: 8px;
    font-weight: 600;
}
.summary-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    position: sticky;
    top: 100px;
}
.summary-item {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #e9ecef;
}
.summary-item:last-child {
    border-bottom: none;
}
.summary-total {
    font-size: 1.5rem;
    font-weight: 800;
    color: #dc3545;
}
.empty-cart {
    text-align: center;
    padding: 80px 20px;
}
.empty-cart-icon {
    font-size: 8rem;
    color: #dee2e6;
    margin-bottom: 30px;
}
.checkbox-custom {
    width: 22px;
    height: 22px;
    cursor: pointer;
    accent-color: #dc3545;
    transition: all 0.3s;
}
.checkbox-custom:checked {
    background-color: #dc3545;
    border-color: #dc3545;
}
.checkbox-custom:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}
.select-all-section {
    background: #f8f9fa;
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}
.remove-btn {
    background: none;
    border: none;
    color: #dc3545;
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.3s;
    padding: 5px 10px;
    border-radius: 5px;
}
.remove-btn:hover {
    background: #fff5f5;
    transform: scale(1.1);
}
</style>

<div class="container mb-5 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div>
            <h2 class="fw-bold mb-2">
                <i class="bi bi-cart3 me-2 text-danger"></i>Giỏ Hàng Của Bạn
            </h2>
            <p class="text-muted mb-0">
                <span id="totalItems"><?= count($cartItems) ?></span> sản phẩm trong giỏ hàng
            </p>
        </div>
        <?php if (!empty($cartItems)): ?>
        <a href="<?= BASE_URL ?>product/index" class="btn btn-outline-danger">
            <i class="bi bi-plus-circle me-2"></i> Thêm Sản Phẩm
        </a>
        <?php endif; ?>
    </div>
    <?php if (empty($cartItems)): ?>
        <!-- Empty Cart -->
        <div class="empty-cart">
            <i class="bi bi-cart-x empty-cart-icon"></i>
            <h2 class="fw-bold mb-3">Giỏ hàng của bạn đang trống</h2>
            <p class="text-muted mb-4 fs-5">Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
            <a href="<?= BASE_URL ?>product/index" class="btn btn-danger btn-lg px-5">
                <i class="bi bi-arrow-left me-2"></i> Tiếp Tục Mua Sắm
            </a>
        </div>
    <?php else: ?>
        <form id="cartForm" method="POST" action="<?= BASE_URL ?>cart/removeMultiple">
            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <!-- Select All -->
                    <div class="select-all-section">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div class="form-check d-flex align-items-center">
                                <input type="checkbox" id="selectAll" class="form-check-input checkbox-custom me-2">
                                <label class="form-check-label fw-bold mb-0" for="selectAll" style="cursor: pointer;">
                                    Chọn tất cả 
                                    <span class="badge bg-danger ms-2" id="selectedCount">0</span>
                                </label>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-danger btn-sm" id="removeSelectedBtn" disabled>
                                    <i class="bi bi-trash me-1"></i> Xóa đã chọn (<span id="removeCount">0</span>)
                                </button>
                            </div>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Tổng tiền các sản phẩm đã chọn: <strong class="text-danger" id="selectedTotalPreview">0₫</strong>
                            </small>
                        </div>
                    </div>
                    
                    <!-- Cart Items List -->
                    <div id="cartItemsList">
                        <?php foreach ($cartItems as $item): ?>
                        <div class="cart-item-card <?= $item['stock_quantity'] == 0 ? 'out-of-stock' : 'selectable' ?> <?= ($item['stock_quantity'] > 0 && $item['stock_quantity'] <= 5) ? 'selected' : '' ?>" 
                             data-variant-id="<?= $item['variant_id'] ?>"
                             data-subtotal="<?= $item['subtotal'] ?>">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="form-check">
                                        <input type="checkbox" 
                                               name="variant_ids[]" 
                                               value="<?= $item['variant_id'] ?>" 
                                               id="checkbox_<?= $item['variant_id'] ?>"
                                               class="form-check-input checkbox-custom item-checkbox" 
                                               data-variant-id="<?= $item['variant_id'] ?>"
                                               <?= $item['stock_quantity'] > 0 ? 'checked' : '' ?>
                                               <?= $item['stock_quantity'] == 0 ? 'disabled' : '' ?>>
                                        <label class="form-check-label" for="checkbox_<?= $item['variant_id'] ?>" style="cursor: pointer;"></label>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <?php 
                                        $imgUrl = BASE_URL . "public/data/" . rawurlencode($item['product_name'] ?? 'default') . ".jpg";
                                    ?>
                                    <a href="<?= BASE_URL ?>product/detail/<?= $item['product_id'] ?>">
                                        <img src="<?= $imgUrl ?>" 
                                             alt="<?= htmlspecialchars($item['product_name']) ?>" 
                                             class="product-image-cart"
                                             onerror="this.src='https://placehold.co/120x120?text=<?= urlencode($item['product_name'] ?? '') ?>'">
                                    </a>
                                </div>
                                <div class="col">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <a href="<?= BASE_URL ?>product/detail/<?= $item['product_id'] ?>" 
                                               class="text-decoration-none text-dark">
                                                <h5 class="fw-bold mb-2"><?= htmlspecialchars($item['product_name']) ?></h5>
                                            </a>
                                            <div class="mb-2">
                                                <span class="badge bg-primary me-2"><?= htmlspecialchars($item['variant_name']) ?></span>
                                                <span class="text-muted small">
                                                    <i class="bi bi-palette"></i> <?= htmlspecialchars($item['color']) ?> | 
                                                    <i class="bi bi-hdd"></i> <?= htmlspecialchars($item['storage']) ?>
                                                </span>
                                            </div>
                                            <?php if ($item['stock_quantity'] <= 5 && $item['stock_quantity'] > 0): ?>
                                                <span class="badge bg-warning text-dark">
                                                    <i class="bi bi-exclamation-triangle"></i> Còn <?= $item['stock_quantity'] ?> sản phẩm
                                                </span>
                                            <?php elseif ($item['stock_quantity'] == 0): ?>
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-x-circle"></i> Hết hàng
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <button type="button" class="remove-btn remove-item-btn" 
                                                data-variant-id="<?= $item['variant_id'] ?>"
                                                title="Xóa sản phẩm"
                                                onclick="removeCartItem(<?= $item['variant_id'] ?>); event.stopPropagation(); return false;">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div>
                                            <span class="text-danger fw-bold fs-5">
                                                <?= number_format($item['price'], 0, ',', '.') ?>₫
                                            </span>
                                        </div>
                                        <div class="quantity-controls">
                                            <button type="button" 
                                                    class="quantity-btn quantity-decrease" 
                                                    data-variant-id="<?= $item['variant_id'] ?>"
                                                    data-stock="<?= $item['stock_quantity'] ?>"
                                                    onclick="decreaseQty(<?= $item['variant_id'] ?>, <?= $item['stock_quantity'] ?>); event.stopPropagation(); return false;"
                                                    <?= $item['quantity'] <= 1 ? 'disabled' : '' ?>>
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="number" 
                                                   class="quantity-input-cart quantity-input" 
                                                   id="qty-input-<?= $item['variant_id'] ?>"
                                                   value="<?= $item['quantity'] ?>" 
                                                   min="1" 
                                                   max="<?= $item['stock_quantity'] ?>"
                                                   data-variant-id="<?= $item['variant_id'] ?>"
                                                   data-price="<?= $item['price'] ?>"
                                                   data-stock="<?= $item['stock_quantity'] ?>"
                                                   data-current-qty="<?= $item['quantity'] ?>"
                                                   readonly>
                                            <button type="button" 
                                                    class="quantity-btn quantity-increase"
                                                    onclick="increaseQty(<?= $item['variant_id'] ?>, <?= $item['stock_quantity'] ?>); event.stopPropagation(); return false;" 
                                                    data-variant-id="<?= $item['variant_id'] ?>"
                                                    data-stock="<?= $item['stock_quantity'] ?>"
                                                    <?= $item['quantity'] >= $item['stock_quantity'] ? 'disabled' : '' ?>>
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                        <div class="text-end">
                                            <div class="text-muted small mb-1">Thành tiền</div>
                                            <div class="fw-bold text-danger fs-5 item-subtotal" 
                                                 data-variant-id="<?= $item['variant_id'] ?>">
                                                <?= number_format($item['subtotal'], 0, ',', '.') ?>₫
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Continue Shopping -->
                    <div class="mt-4">
                        <a href="<?= BASE_URL ?>product/index" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Tiếp Tục Mua Sắm
                        </a>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="summary-card">
                        <h4 class="fw-bold mb-4">
                            <i class="bi bi-receipt me-2 text-danger"></i> Tóm Tắt Đơn Hàng
                        </h4>
                        
                        <div class="summary-item">
                            <span class="text-muted">Tạm tính:</span>
                            <span class="fw-bold" id="subtotal"><?= number_format($total, 0, ',', '.') ?>₫</span>
                        </div>
                        <div class="summary-item">
                            <span class="text-muted">Phí vận chuyển:</span>
                            <span class="fw-bold text-success">Miễn phí</span>
                        </div>
                        <div class="summary-item">
                            <span class="text-muted">Giảm giá:</span>
                            <span class="fw-bold text-success">-0₫</span>
                        </div>
                        <hr>
                        <div class="summary-item">
                            <span class="fw-bold fs-5">Tổng cộng:</span>
                            <span class="summary-total" id="selectedTotal"><?= number_format($total, 0, ',', '.') ?>₫</span>
                        </div>
                        
                        <a href="<?= BASE_URL ?>cart/checkout" 
                           class="btn btn-danger btn-lg w-100 mt-4" 
                           id="checkoutBtn">
                            <i class="bi bi-cart-check me-2"></i> Thanh Toán
                        </a>
                        
                        <div class="mt-4 p-3 bg-light rounded">
                            <h6 class="fw-bold mb-2">
                                <i class="bi bi-shield-check text-success me-2"></i> Cam Kết
                            </h6>
                            <ul class="small mb-0 ps-3">
                                <li>Sản phẩm chính hãng 100%</li>
                                <li>Miễn phí vận chuyển</li>
                                <li>Đổi trả trong 7 ngày</li>
                                <li>Bảo hành chính hãng</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

<script>
// Global functions for quantity buttons
function increaseQty(variantId, maxStock) {
    console.log('increaseQty called:', variantId, maxStock);
    var input = $('#qty-input-' + variantId);
    var currentQty = parseInt(input.val()) || 1;
    
    if (currentQty < maxStock) {
        input.val(currentQty + 1);
        updateQuantityAjax(variantId, currentQty + 1);
    } else {
        alert('Số lượng không được vượt quá tồn kho (' + maxStock + ')');
    }
}

function decreaseQty(variantId, maxStock) {
    console.log('decreaseQty called:', variantId);
    var input = $('#qty-input-' + variantId);
    var currentQty = parseInt(input.val()) || 1;
    
    if (currentQty > 1) {
        input.val(currentQty - 1);
        updateQuantityAjax(variantId, currentQty - 1);
    }
}

function updateQuantityAjax(variantId, quantity) {
    console.log('updateQuantityAjax:', variantId, quantity);
    
    var card = $('.cart-item-card[data-variant-id="' + variantId + '"]');
    var input = $('#qty-input-' + variantId);
    var price = parseFloat(input.data('price'));
    var subtotal = price * quantity;
    
    // Disable buttons
    card.find('.quantity-btn').prop('disabled', true);
    
    $.ajax({
        url: BASE_URL + 'cart/update',
        method: 'POST',
        data: {
            variant_id: variantId,
            quantity: quantity,
            ajax: 1
        },
        dataType: 'json',
        success: function(response) {
            console.log('AJAX response:', response);
            if (response.success) {
                // Update subtotal display
                card.find('.item-subtotal').text(subtotal.toLocaleString('vi-VN') + '₫');
                card.data('subtotal', subtotal);
                input.data('current-qty', quantity);
                
                // Update buttons state
                var maxQty = parseInt(input.data('stock'));
                card.find('.quantity-decrease').prop('disabled', quantity <= 1);
                card.find('.quantity-increase').prop('disabled', quantity >= maxQty);
                
                // Update totals - call global function
                updateCartTotals();
                
                showToast('Đã cập nhật số lượng', 'success');
            } else {
                input.val(input.data('current-qty'));
                showToast(response.message || 'Không thể cập nhật số lượng', 'danger');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            input.val(input.data('current-qty'));
            showToast('Không thể cập nhật số lượng. Vui lòng thử lại.', 'danger');
        },
        complete: function() {
            card.find('.quantity-btn').prop('disabled', false);
            // Re-check button states
            var currentVal = parseInt(input.val());
            var maxQty = parseInt(input.data('stock'));
            card.find('.quantity-decrease').prop('disabled', currentVal <= 1);
            card.find('.quantity-increase').prop('disabled', currentVal >= maxQty);
        }
    });
}

// Global function to update cart totals
function updateCartTotals() {
    var total = 0;
    var selectedCount = 0;
    
    $('.item-checkbox:checked:not(:disabled)').each(function() {
        var card = $(this).closest('.cart-item-card');
        var input = card.find('.quantity-input');
        var price = parseFloat(input.data('price')) || 0;
        var qty = parseInt(input.val()) || 0;
        
        if (price > 0 && qty > 0) {
            var subtotal = price * qty;
            card.find('.item-subtotal').text(subtotal.toLocaleString('vi-VN') + '₫');
            total += subtotal;
            selectedCount++;
        }
    });
    
    var formattedTotal = total.toLocaleString('vi-VN') + '₫';
    $('#selectedTotal').text(formattedTotal);
    $('#subtotal').text(formattedTotal);
    $('#selectedCount').text(selectedCount);
    $('#removeCount').text(selectedCount);
    $('#selectedTotalPreview').text(formattedTotal);
}

// Toast notification
function showToast(message, type) {
    type = type || 'info';
    var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999; min-width: 300px;" role="alert">' +
        '<i class="bi bi-' + (type === 'success' ? 'check-circle' : 'exclamation-circle') + ' me-2"></i>' +
        message +
        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
        '</div>';
    $('body').append(alertHtml);
    setTimeout(function() {
        $('.alert').fadeOut(function() {
            $(this).remove();
        });
    }, 3000);
}

function removeCartItem(variantId) {
    console.log('removeCartItem:', variantId);
    if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
        window.location.href = BASE_URL + 'cart/remove/' + variantId;
    }
}

$(document).ready(function() {
    console.log('Cart page loaded');
    console.log('BASE_URL:', BASE_URL);
    
    // Select All checkbox
    $('#selectAll').on('change', function() {
        var isChecked = $(this).prop('checked');
        $('.item-checkbox:not(:disabled)').prop('checked', isChecked).trigger('change');
    });
    
    // Item checkbox change - sử dụng event delegation
    $(document).on('change', '.item-checkbox', function(e) {
        e.stopPropagation();
        var checkbox = $(this);
        var card = checkbox.closest('.cart-item-card');
        
        // Update card styling
        if (checkbox.prop('checked') && !checkbox.prop('disabled')) {
            card.addClass('selected');
        } else {
            card.removeClass('selected');
        }
        
        // Update select all checkbox state
        updateSelectAllState();
        
        // Update totals and buttons
        updateSelectedTotal();
        
        // Save checkbox state to localStorage
        saveCheckboxState();
    });
    
    // Click on card to toggle checkbox (except on buttons and inputs)
    $(document).on('click', '.cart-item-card.selectable', function(e) {
        // Don't trigger if clicking on buttons, inputs, links, or icons
        var target = $(e.target);
        if (target.closest('button, input, a, .quantity-controls, .remove-btn, .quantity-btn, .bi, i').length) {
            return;
        }
        
        var checkbox = $(this).find('.item-checkbox');
        if (!checkbox.prop('disabled')) {
            checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
        }
    });
    
    // Update select all checkbox state
    function updateSelectAllState() {
        var totalCheckboxes = $('.item-checkbox:not(:disabled)').length;
        var checkedCheckboxes = $('.item-checkbox:not(:disabled):checked').length;
        
        if (totalCheckboxes === 0) {
            $('#selectAll').prop('checked', false).prop('disabled', true);
        } else {
            $('#selectAll').prop('disabled', false);
            $('#selectAll').prop('checked', totalCheckboxes > 0 && checkedCheckboxes === totalCheckboxes);
        }
    }
    
    // Save checkbox state to localStorage
    function saveCheckboxState() {
        if (typeof Storage !== 'undefined') {
            var checkedItems = [];
            $('.item-checkbox:checked:not(:disabled)').each(function() {
                checkedItems.push($(this).val());
            });
            localStorage.setItem('cart_checked_items', JSON.stringify(checkedItems));
        }
    }
    
    // Load checkbox state from localStorage
    function loadCheckboxState() {
        if (typeof Storage !== 'undefined') {
            var savedChecked = localStorage.getItem('cart_checked_items');
            if (savedChecked) {
                try {
                    var checkedItems = JSON.parse(savedChecked);
                    $('.item-checkbox').each(function() {
                        var variantId = $(this).val();
                        if (checkedItems.indexOf(variantId) !== -1 && !$(this).prop('disabled')) {
                            $(this).prop('checked', true).trigger('change');
                        }
                    });
                } catch (e) {
                    console.error('Error loading checkbox state:', e);
                }
            }
        }
    }
    
    // Quantity increase
    $(document).on('click', '.quantity-increase', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var btn = $(this);
        var container = btn.closest('.quantity-controls');
        var input = container.find('.quantity-input');
        var currentQty = parseInt(input.val()) || 1;
        var maxQty = parseInt(btn.attr('data-stock')) || 99;
        var variantId = btn.attr('data-variant-id');
        
        console.log('Increase clicked - variantId:', variantId, 'currentQty:', currentQty, 'maxQty:', maxQty);
        
        if (!variantId) {
            console.error('variantId is undefined!');
            return;
        }
        
        if (currentQty < maxQty) {
            input.val(currentQty + 1);
            updateQuantity(variantId, currentQty + 1);
        } else {
            showAlert('Số lượng không được vượt quá tồn kho (' + maxQty + ')', 'warning');
        }
    });
    
    // Quantity decrease
    $(document).on('click', '.quantity-decrease', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var btn = $(this);
        var container = btn.closest('.quantity-controls');
        var input = container.find('.quantity-input');
        var currentQty = parseInt(input.val()) || 1;
        var variantId = btn.attr('data-variant-id');
        
        console.log('Decrease clicked - variantId:', variantId, 'currentQty:', currentQty);
        
        if (!variantId) {
            console.error('variantId is undefined!');
            return;
        }
        
        if (currentQty > 1) {
            input.val(currentQty - 1);
            updateQuantity(variantId, currentQty - 1);
        }
    });
    
    // Update quantity
    function updateQuantity(variantId, quantity) {
        console.log('updateQuantity called:', variantId, quantity);
        
        var card = $('.cart-item-card[data-variant-id="' + variantId + '"]');
        console.log('Card found:', card.length);
        
        var input = card.find('.quantity-input');
        console.log('Input found:', input.length);
        
        var price = parseFloat(input.data('price'));
        var subtotal = price * quantity;
        
        console.log('Price:', price, 'Subtotal:', subtotal);
        
        // Disable buttons
        card.find('.quantity-btn').prop('disabled', true);
        
        // Update localStorage
        if (typeof CartStorage !== 'undefined') {
            CartStorage.updateItem(variantId, quantity);
        }
        
        console.log('Sending AJAX to:', '<?= BASE_URL ?>cart/update');
        
        $.ajax({
            url: '<?= BASE_URL ?>cart/update',
            method: 'POST',
            data: {
                variant_id: variantId,
                quantity: quantity,
                ajax: 1
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Update subtotal
                    card.find('.item-subtotal').text(subtotal.toLocaleString('vi-VN') + '₫');
                    card.data('subtotal', subtotal);
                    
                    // Update buttons
                    if (quantity <= 1) {
                        card.find('.quantity-decrease').prop('disabled', true);
                    } else {
                        card.find('.quantity-decrease').prop('disabled', false);
                    }
                    
                    var maxQty = parseInt(input.data('stock'));
                    if (quantity >= maxQty) {
                        card.find('.quantity-increase').prop('disabled', true);
                    } else {
                        card.find('.quantity-increase').prop('disabled', false);
                    }
                    
                    // Update localStorage
                    if (typeof CartStorage !== 'undefined' && response.cart) {
                        CartStorage.save(response.cart);
                    }
                    
                    // Update totals and checkboxes
                    updateSelectedTotal();
                    updateCartCount();
                    updateSelectAllState();
                    saveCheckboxState();
                    
                    showAlert('Đã cập nhật số lượng', 'success');
                } else {
                    input.val(input.data('current-qty'));
                    if (typeof CartStorage !== 'undefined') {
                        CartStorage.updateItem(variantId, input.data('current-qty'));
                    }
                    showAlert(response.message || 'Không thể cập nhật số lượng', 'danger');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                console.error('Response:', xhr.responseText);
                input.val(input.data('current-qty'));
                if (typeof CartStorage !== 'undefined') {
                    CartStorage.updateItem(variantId, input.data('current-qty'));
                }
                showAlert('Không thể cập nhật số lượng. Vui lòng thử lại.', 'danger');
            },
            complete: function() {
                card.find('.quantity-btn').prop('disabled', false);
            }
        });
    }
    
    // Update selected total
    function updateSelectedTotal() {
        var total = 0;
        var selectedCount = 0;
        var selectedItems = [];
        
        $('.item-checkbox:checked:not(:disabled)').each(function() {
            var checkbox = $(this);
            var card = checkbox.closest('.cart-item-card');
            var input = card.find('.quantity-input');
            var price = parseFloat(input.data('price')) || 0;
            var qty = parseInt(input.val()) || 0;
            
            if (price > 0 && qty > 0) {
                var subtotal = price * qty;
                // Update data attribute
                card.data('subtotal', subtotal);
                // Update display
                card.find('.item-subtotal').text(subtotal.toLocaleString('vi-VN') + '₫');
                total += subtotal;
                selectedCount++;
                selectedItems.push({
                    variantId: checkbox.val(),
                    subtotal: subtotal
                });
            }
        });
        
        // Update display
        var formattedTotal = total.toLocaleString('vi-VN') + '₫';
        $('#selectedTotal').text(formattedTotal);
        $('#subtotal').text(formattedTotal);
        $('#selectedCount').text(selectedCount);
        $('#removeCount').text(selectedCount);
        $('#selectedTotalPreview').text(formattedTotal);
        
        // Update buttons state
        var hasSelected = selectedCount > 0;
        $('#removeSelectedBtn').prop('disabled', !hasSelected);
        
        if (hasSelected) {
            $('#removeSelectedBtn').removeClass('btn-outline-secondary').addClass('btn-outline-danger');
        } else {
            $('#removeSelectedBtn').removeClass('btn-outline-danger').addClass('btn-outline-secondary');
        }
        
        // Update checkout button
        if (!hasSelected) {
            $('#checkoutBtn').addClass('disabled').css({
                'pointer-events': 'none',
                'opacity': '0.6',
                'cursor': 'not-allowed'
            });
        } else {
            $('#checkoutBtn').removeClass('disabled').css({
                'pointer-events': 'auto',
                'opacity': '1',
                'cursor': 'pointer'
            });
        }
        
        // Update checkout URL with selected items
        if (hasSelected) {
            var selectedIds = selectedItems.map(item => item.variantId).join(',');
            $('#checkoutBtn').attr('href', '<?= BASE_URL ?>cart/checkout?selected=' + selectedIds);
        } else {
            $('#checkoutBtn').attr('href', '<?= BASE_URL ?>cart/checkout');
        }
    }
    
    // Update cart count
    function updateCartCount() {
        var totalCount = 0;
        $('.quantity-input').each(function() {
            totalCount += parseInt($(this).val()) || 0;
        });
        
        if ($('#cart-count').length) {
            $('#cart-count').text(totalCount);
        }
        
        var itemCount = $('.item-checkbox').length;
        $('#totalItems').text(itemCount);
    }
    
    // Remove item
    $(document).on('click', '.remove-item-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var btn = $(this);
        var variantId = btn.attr('data-variant-id');
        
        console.log('Remove item clicked - variantId:', variantId);
        
        if (!variantId) {
            console.error('variantId is undefined!');
            return false;
        }
        
        if (!confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
            return false;
        }
        
        btn.prop('disabled', true);
        
        if (typeof CartStorage !== 'undefined') {
            CartStorage.removeItem(variantId);
        }
        
        window.location.href = '<?= BASE_URL ?>cart/remove/' + variantId;
        return false;
    });
    
    // Remove selected
    $(document).on('click', '#removeSelectedBtn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var selectedCount = $('.item-checkbox:checked:not(:disabled)').length;
        console.log('Remove selected clicked:', selectedCount);
        
        if (selectedCount === 0) {
            showAlert('Vui lòng chọn ít nhất một sản phẩm để xóa', 'warning');
            return false;
        }
        
        var message = selectedCount === 1 
            ? 'Bạn có chắc muốn xóa sản phẩm đã chọn?' 
            : 'Bạn có chắc muốn xóa ' + selectedCount + ' sản phẩm đã chọn?';
        
        if (!confirm(message)) {
            return false;
        }
        
        var variantIds = [];
        $('.item-checkbox:checked:not(:disabled)').each(function() {
            variantIds.push($(this).val());
        });
        
        console.log('Removing:', variantIds);
        
        if (typeof CartStorage !== 'undefined') {
            CartStorage.removeItems(variantIds);
        }
        
        $('#cartForm').submit();
        return false;
    });
    
    // Checkout button
    $('#checkoutBtn').on('click', function(e) {
        var selectedCount = $('.item-checkbox:checked:not(:disabled)').length;
        if (selectedCount === 0) {
            e.preventDefault();
            showAlert('Vui lòng chọn ít nhất một sản phẩm để thanh toán', 'warning');
            return false;
        }
    });
    
    // Show alert
    function showAlert(message, type) {
        type = type || 'info';
        var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999; min-width: 300px;" role="alert">' +
            message +
            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
            '</div>';
        $('body').append(alertHtml);
        setTimeout(function() {
            $('.alert').fadeOut(function() {
                $(this).remove();
            });
        }, 3000);
    }
    
    // Initialize on page load
    function initializeCart() {
        // Load saved checkbox state
        loadCheckboxState();
        
        // Update card styling based on checkbox state
        $('.cart-item-card').each(function() {
            var checkbox = $(this).find('.item-checkbox');
            if (checkbox.prop('checked') && !checkbox.prop('disabled')) {
                $(this).addClass('selected');
            } else {
                $(this).removeClass('selected');
            }
        });
        
        // Update select all state
        updateSelectAllState();
        
        // Update totals
        updateSelectedTotal();
        updateCartCount();
    }
    
    // Initialize
    initializeCart();
    
    // Sync from localStorage
    if (typeof CartStorage !== 'undefined') {
        CartStorage.syncFromServer();
        // Re-initialize after sync
        setTimeout(function() {
            initializeCart();
        }, 500);
    }
    
    // Re-initialize when cart is updated
    $(document).on('cartUpdated', function() {
        initializeCart();
    });
    
    // Save checkbox state before page unload
    $(window).on('beforeunload', function() {
        saveCheckboxState();
    });
});
</script>
