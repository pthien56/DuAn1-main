// Cart Storage Management - Lưu giỏ hàng vào localStorage
(function() {
    'use strict';
    
    const CART_STORAGE_KEY = 'mivonstore_cart';
    
    // Lưu giỏ hàng vào localStorage
    function saveCartToStorage(cart) {
        try {
            localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
            return true;
        } catch (e) {
            console.error('Lỗi khi lưu giỏ hàng vào localStorage:', e);
            return false;
        }
    }
    
    // Lấy giỏ hàng từ localStorage
    function getCartFromStorage() {
        try {
            const cartData = localStorage.getItem(CART_STORAGE_KEY);
            return cartData ? JSON.parse(cartData) : {};
        } catch (e) {
            console.error('Lỗi khi đọc giỏ hàng từ localStorage:', e);
            return {};
        }
    }
    
    // Xóa giỏ hàng khỏi localStorage
    function clearCartStorage() {
        try {
            localStorage.removeItem(CART_STORAGE_KEY);
            return true;
        } catch (e) {
            console.error('Lỗi khi xóa giỏ hàng khỏi localStorage:', e);
            return false;
        }
    }
    
    // Đồng bộ giỏ hàng từ server (session) sang localStorage
    function syncCartFromServer() {
        // Chỉ sync nếu đã đăng nhập
        if (typeof BASE_URL === 'undefined') {
            return;
        }
        
        $.ajax({
            url: BASE_URL + 'cart/getCart',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success && response.cart) {
                    // Merge với localStorage (ưu tiên số lượng lớn hơn)
                    const localCart = getCartFromStorage();
                    const serverCart = response.cart;
                    const mergedCart = {...localCart};
                    
                    for (let variantId in serverCart) {
                        if (!mergedCart[variantId] || parseInt(mergedCart[variantId]) < parseInt(serverCart[variantId])) {
                            mergedCart[variantId] = serverCart[variantId];
                        }
                    }
                    
                    saveCartToStorage(mergedCart);
                }
            },
            error: function() {
                // Không có session cart, giữ nguyên localStorage
            }
        });
    }
    
    // Đồng bộ giỏ hàng từ localStorage lên server (session)
    function syncCartToServer() {
        if (typeof BASE_URL === 'undefined') {
            return;
        }
        
        const cart = getCartFromStorage();
        if (Object.keys(cart).length === 0) {
            return;
        }
        
        $.ajax({
            url: BASE_URL + 'cart/syncCart',
            method: 'POST',
            data: {
                cart: JSON.stringify(cart),
                ajax: 1
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Cập nhật lại từ server để đảm bảo đồng bộ
                    if (response.cart) {
                        saveCartToStorage(response.cart);
                    }
                }
            },
            error: function(xhr) {
                // Chỉ log lỗi nếu không phải lỗi 401 (chưa đăng nhập)
                if (xhr.status !== 401) {
                    console.error('Lỗi khi đồng bộ giỏ hàng lên server');
                }
            }
        });
    }
    
    // Cập nhật số lượng sản phẩm trong localStorage
    function updateCartItem(variantId, quantity) {
        const cart = getCartFromStorage();
        
        if (quantity <= 0) {
            delete cart[variantId];
        } else {
            cart[variantId] = quantity;
        }
        
        saveCartToStorage(cart);
        syncCartToServer();
    }
    
    // Xóa sản phẩm khỏi localStorage
    function removeCartItem(variantId) {
        const cart = getCartFromStorage();
        delete cart[variantId];
        saveCartToStorage(cart);
        syncCartToServer();
    }
    
    // Xóa nhiều sản phẩm
    function removeCartItems(variantIds) {
        const cart = getCartFromStorage();
        variantIds.forEach(function(variantId) {
            delete cart[variantId];
        });
        saveCartToStorage(cart);
        syncCartToServer();
    }
    
    // Thêm sản phẩm vào localStorage
    function addCartItem(variantId, quantity) {
        const cart = getCartFromStorage();
        if (cart[variantId]) {
            cart[variantId] = parseInt(cart[variantId]) + parseInt(quantity);
        } else {
            cart[variantId] = parseInt(quantity);
        }
        saveCartToStorage(cart);
        syncCartToServer();
    }
    
    // Lấy tổng số lượng sản phẩm
    function getCartCount() {
        const cart = getCartFromStorage();
        let count = 0;
        for (let variantId in cart) {
            count += parseInt(cart[variantId]) || 0;
        }
        return count;
    }
    
    // Export functions to window
    window.CartStorage = {
        save: saveCartToStorage,
        load: getCartFromStorage,
        clear: clearCartStorage,
        syncFromServer: syncCartFromServer,
        syncToServer: syncCartToServer,
        updateItem: updateCartItem,
        removeItem: removeCartItem,
        removeItems: removeCartItems,
        addItem: addCartItem,
        getCount: getCartCount
    };
    
    // Tự động sync khi trang load
    $(document).ready(function() {
        // Sync từ server khi load trang (nếu đã đăng nhập)
        // Delay một chút để đảm bảo jQuery đã sẵn sàng
        setTimeout(function() {
            syncCartFromServer();
        }, 500);
        
        // Sync lên server khi có thay đổi trong localStorage (nếu đã đăng nhập)
        $(window).on('beforeunload', function() {
            syncCartToServer();
        });
        
        // Lắng nghe sự kiện storage từ các tab khác
        $(window).on('storage', function(e) {
            if (e.originalEvent.key === CART_STORAGE_KEY) {
                // Giỏ hàng đã được cập nhật từ tab khác
                // Reload trang hoặc sync lên server
                if (typeof location !== 'undefined' && location.reload) {
                    // Chỉ sync, không reload để tránh mất dữ liệu
                    syncCartToServer();
                }
            }
        });
        
        // Sync định kỳ mỗi 30 giây (nếu đã đăng nhập)
        setInterval(function() {
            syncCartToServer();
        }, 30000);
    });
})();

