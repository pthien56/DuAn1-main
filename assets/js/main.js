// Get base URL dynamically
function getBaseUrl() {
    const script = document.currentScript || document.querySelector('script[src*="main.js"]');
    if (script) {
        const src = script.src;
        const basePath = src.substring(0, src.lastIndexOf('/assets'));
        return basePath;
    }
    // Fallback: try to detect from current path
    const path = window.location.pathname;
    const parts = path.split('/');
    if (parts.length > 1) {
        return '/' + parts.slice(1, -1).join('/');
    }
    return '';
}

const BASE_URL = getBaseUrl();

// Cart Functions
function addToCart(variantId, quantity = 1) {
    const formData = new FormData();
    formData.append('action', 'add');
    formData.append('variant_id', variantId);
    formData.append('quantity', quantity);
    
    fetch(BASE_URL + '/api/cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            updateCartCount();
            if (window.location.pathname.includes('cart.php')) {
                location.reload();
            }
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi thêm vào giỏ hàng');
    });
}

function updateCart(variantId, quantity) {
    const formData = new FormData();
    formData.append('action', 'update');
    formData.append('variant_id', variantId);
    formData.append('quantity', quantity);
    
    fetch(BASE_URL + '/api/cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi cập nhật giỏ hàng');
    });
}

function removeFromCart(variantId) {
    if (!confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'remove');
    formData.append('variant_id', variantId);
    
    fetch(BASE_URL + '/api/cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi xóa sản phẩm');
    });
}

function updateCartCount() {
    fetch(BASE_URL + '/api/cart.php?action=get')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const cartLinks = document.querySelectorAll('a[href*="cart.php"]');
                cartLinks.forEach(link => {
                    const text = link.textContent;
                    const match = text.match(/Giỏ hàng \((\d+)\)/);
                    if (match) {
                        link.textContent = `Giỏ hàng (${data.cart_count})`;
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error updating cart count:', error);
        });
}

// Initialize cart count on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
    
    // Search functionality
    const searchInput = document.querySelector('.search-input');
    const searchBtn = document.querySelector('.search-btn');
    
    if (searchInput && searchBtn) {
        function performSearch() {
            const query = searchInput.value.trim();
            if (query) {
                window.location.href = BASE_URL + '/products.php?search=' + encodeURIComponent(query);
            }
        }
        
        searchBtn.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    }
    
    // Image error handling - chỉ xử lý khi placeholder cũng fail
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        // Lưu src gốc
        const originalSrc = img.src;
        let errorCount = 0;
        
        img.addEventListener('error', function() {
            errorCount++;
            
            // Nếu đã thử placeholder rồi mà vẫn lỗi, dừng lại
            if (errorCount > 1 || this.src.includes('placeholder.jpg')) {
                // Xóa onerror attribute để tránh vòng lặp
                this.removeAttribute('onerror');
                // Ẩn hình ảnh hoặc hiển thị placeholder text
                this.style.display = 'none';
                // Hoặc set một placeholder mặc định
                this.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="200" height="200"%3E%3Crect fill="%23ddd" width="200" height="200"/%3E%3Ctext fill="%23999" font-family="sans-serif" font-size="14" x="50%25" y="50%25" text-anchor="middle" dy=".3em"%3ENo Image%3C/text%3E%3C/svg%3E';
                return;
            }
            
            // Nếu chưa phải placeholder, thử set placeholder
            if (!this.src.includes('placeholder.jpg')) {
                const placeholderUrl = BASE_URL + '/assets/images/placeholder.jpg';
                // Xóa onerror attribute trước khi set src mới để tránh vòng lặp
                this.removeAttribute('onerror');
                this.src = placeholderUrl;
            }
        }, { once: false });
    });
});

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.style.borderColor = '#dc3545';
        } else {
            input.style.borderColor = '#ddd';
        }
    });
    
    if (!isValid) {
        alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
    }
    
    return isValid;
}