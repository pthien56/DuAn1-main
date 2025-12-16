// Main JavaScript for User Frontend

$(document).ready(function() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
    // Format currency on page load
    $('.price').each(function() {
        var price = $(this).text();
        if (price && !isNaN(price)) {
            $(this).text(formatCurrency(price));
        }
    });
});

function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount);
}

// Add to cart with AJAX
function addToCart(variantId, quantity) {
    // Lưu vào localStorage ngay lập tức
    if (typeof CartStorage !== 'undefined') {
        CartStorage.addItem(variantId, quantity || 1);
    }
    
    $.ajax({
        url: BASE_URL + 'cart/add',
        method: 'POST',
        data: {
            variant_id: variantId,
            quantity: quantity || 1,
            ajax: 1
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#cart-count').text(response.cartCount);
                
                // Cập nhật localStorage từ response
                if (typeof CartStorage !== 'undefined' && response.cart) {
                    CartStorage.save(response.cart);
                }
                
                // Hiển thị thông báo
                var alertHtml = '<div class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999; min-width: 300px;" role="alert">' +
                    response.message +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                    '</div>';
                $('body').append(alertHtml);
                setTimeout(function() {
                    $('.alert').fadeOut(function() {
                        $(this).remove();
                    });
                }, 3000);
            } else {
                // Xóa khỏi localStorage nếu thất bại
                if (typeof CartStorage !== 'undefined') {
                    CartStorage.removeItem(variantId);
                }
                
                if (response.requireLogin) {
                    if (confirm(response.message + '\n\nBạn có muốn chuyển đến trang đăng nhập?')) {
                        window.location.href = response.loginUrl;
                    }
                } else {
                    alert(response.message);
                }
            }
        },
        error: function() {
            // Xóa khỏi localStorage nếu có lỗi
            if (typeof CartStorage !== 'undefined') {
                CartStorage.removeItem(variantId);
            }
            alert('Có lỗi xảy ra khi thêm vào giỏ hàng');
        }
    });
}

