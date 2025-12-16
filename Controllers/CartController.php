<?php
// Các class đã được load từ index.php

class CartController extends BaseController {
    
    private $cartModel;
    private $productModel;
    private $customerModel;
    private $orderModel;
    private $couponModel;
    
    public function __construct() {
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
        $this->customerModel = new CustomerModel();
        $this->orderModel = new OrderModel();
        $this->couponModel = new CouponModel();
    }
    
    public function index() {
        $cartItems = $this->cartModel->getCartItems();
        $total = $this->cartModel->getCartTotal();
        
        $data = [
            'cartItems' => $cartItems,
            'total' => $total,
            'pageTitle' => 'Giỏ Hàng'
        ];
        
        $this->view('cart/index', $data);
    }
    
    public function add() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['customer_id'])) {
            if (isset($_POST['ajax'])) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng',
                    'requireLogin' => true,
                    'loginUrl' => BASE_URL . 'auth/login'
                ], 401);
                return;
            } else {
                $_SESSION['error'] = 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng';
                
                // Lưu URL redirect (chuyển từ absolute sang relative nếu cần)
                $referer = $_SERVER['HTTP_REFERER'] ?? '';
                if (!empty($referer) && strpos($referer, BASE_URL) !== false) {
                    $redirectUrl = str_replace(BASE_URL, '', $referer);
                    $_SESSION['redirect_after_login'] = $redirectUrl;
                } else {
                    $_SESSION['redirect_after_login'] = 'product/index';
                }
                
                $this->redirect('auth/login');
                return;
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $variantId = isset($_POST['variant_id']) ? (int)$_POST['variant_id'] : 0;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
            $buyNow = isset($_POST['buy_now']) && $_POST['buy_now'] == '1';
            
            if ($variantId > 0 && $quantity > 0) {
                // Nếu nhấn "Mua Ngay" - lưu sản phẩm vào session riêng để thanh toán
                if ($buyNow) {
                    $_SESSION['buy_now_item'] = [
                        'variant_id' => $variantId,
                        'quantity' => $quantity
                    ];
                    $this->redirect('cart/buyNow');
                    return;
                }
                
                if ($this->cartModel->addToCart($variantId, $quantity)) {
                    if (isset($_POST['ajax'])) {
                        $this->jsonResponse([
                            'success' => true,
                            'message' => 'Đã thêm vào giỏ hàng',
                            'cartCount' => $this->cartModel->getCartCount(),
                            'cart' => isset($_SESSION['cart']) ? $_SESSION['cart'] : []
                        ]);
                    } else {
                        $_SESSION['success'] = 'Đã thêm vào giỏ hàng';
                        $this->redirect('cart/index');
                    }
                } else {
                    if (isset($_POST['ajax'])) {
                        $this->jsonResponse([
                            'success' => false,
                            'message' => 'Không đủ hàng trong kho'
                        ], 400);
                    } else {
                        $_SESSION['error'] = 'Không đủ hàng trong kho';
                        $this->redirect('product/index');
                    }
                }
            }
        }
        $this->redirect('product/index');
    }
    
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $variantId = isset($_POST['variant_id']) ? (int)$_POST['variant_id'] : 0;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
            
            // Debug log
            error_log("Cart update: variantId=$variantId, quantity=$quantity");
            
            if ($variantId > 0) {
                $result = $this->cartModel->updateCart($variantId, $quantity);
                error_log("Cart update result: " . ($result ? 'true' : 'false'));
                
                if ($result) {
                    if (isset($_POST['ajax']) || isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                        $this->jsonResponse([
                            'success' => true,
                            'message' => 'Đã cập nhật giỏ hàng',
                            'cartCount' => $this->cartModel->getCartCount(),
                            'cartTotal' => $this->cartModel->getCartTotal(),
                            'cart' => isset($_SESSION['cart']) ? $_SESSION['cart'] : []
                        ]);
                        return;
                    }
                    $_SESSION['success'] = 'Đã cập nhật giỏ hàng';
                } else {
                    if (isset($_POST['ajax']) || isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                        $this->jsonResponse([
                            'success' => false,
                            'message' => 'Không đủ hàng trong kho'
                        ], 400);
                        return;
                    }
                    $_SESSION['error'] = 'Không đủ hàng trong kho';
                }
            } else {
                // Invalid variant ID
                if (isset($_POST['ajax']) || isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                    $this->jsonResponse([
                        'success' => false,
                        'message' => 'ID sản phẩm không hợp lệ'
                    ], 400);
                    return;
                }
            }
        }
        $this->redirect('cart/index');
    }
    
    public function remove($variantId) {
        if ($this->cartModel->removeFromCart($variantId)) {
            $_SESSION['success'] = 'Đã xóa sản phẩm khỏi giỏ hàng';
        }
        $this->redirect('cart/index');
    }
    
    public function removeMultiple() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['variant_ids'])) {
            $variantIds = $_POST['variant_ids'];
            $removedCount = 0;
            
            foreach ($variantIds as $variantId) {
                if ($this->cartModel->removeFromCart((int)$variantId)) {
                    $removedCount++;
                }
            }
            
            if ($removedCount > 0) {
                $_SESSION['success'] = 'Đã xóa ' . $removedCount . ' sản phẩm khỏi giỏ hàng';
                
                if (isset($_POST['ajax'])) {
                    $this->jsonResponse([
                        'success' => true,
                        'message' => 'Đã xóa ' . $removedCount . ' sản phẩm khỏi giỏ hàng',
                        'cartCount' => $this->cartModel->getCartCount(),
                        'cart' => isset($_SESSION['cart']) ? $_SESSION['cart'] : []
                    ]);
                    return;
                }
            } else {
                $_SESSION['error'] = 'Không thể xóa sản phẩm';
            }
        }
        $this->redirect('cart/index');
    }
    
    public function checkout() {
        $cartItems = $this->cartModel->getCartItems();
        
        if (empty($cartItems)) {
            $_SESSION['error'] = 'Giỏ hàng trống';
            $this->redirect('cart/index');
        }
        
        $data = [
            'cartItems' => $cartItems,
            'total' => $this->cartModel->getCartTotal(),
            'pageTitle' => 'Thanh Toán'
        ];
        
        $this->view('cart/checkout', $data);
    }
    
    // Mua ngay - chỉ thanh toán 1 sản phẩm
    public function buyNow() {
        if (!isset($_SESSION['customer_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để mua hàng';
            $this->redirect('auth/login');
            return;
        }
        
        if (!isset($_SESSION['buy_now_item'])) {
            $_SESSION['error'] = 'Không có sản phẩm để mua';
            $this->redirect('product/index');
            return;
        }
        
        $buyNowItem = $_SESSION['buy_now_item'];
        $variant = $this->productModel->getVariantById($buyNowItem['variant_id']);
        
        if (!$variant) {
            $_SESSION['error'] = 'Sản phẩm không tồn tại';
            unset($_SESSION['buy_now_item']);
            $this->redirect('product/index');
            return;
        }
        
        if ($variant['stock_quantity'] < $buyNowItem['quantity']) {
            $_SESSION['error'] = 'Không đủ hàng trong kho';
            unset($_SESSION['buy_now_item']);
            $this->redirect('product/index');
            return;
        }
        
        // Tạo cart item cho sản phẩm mua ngay
        $cartItems = [[
            'variant_id' => $variant['variant_id'],
            'product_name' => $variant['product_name'],
            'variant_name' => $variant['variant_name'] ?? '',
            'color' => $variant['color'],
            'storage' => $variant['storage'],
            'price' => $variant['price'],
            'quantity' => $buyNowItem['quantity'],
            'subtotal' => $variant['price'] * $buyNowItem['quantity'],
            'stock_quantity' => $variant['stock_quantity']
        ]];
        
        $total = $variant['price'] * $buyNowItem['quantity'];
        
        $data = [
            'cartItems' => $cartItems,
            'total' => $total,
            'isBuyNow' => true,
            'pageTitle' => 'Thanh Toán Nhanh'
        ];
        
        $this->view('cart/checkout', $data);
    }
    
    public function processOrder() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('cart/index');
        }
        
        // Kiểm tra xem là Mua Ngay hay thanh toán giỏ hàng
        $isBuyNow = isset($_POST['is_buy_now']) && $_POST['is_buy_now'] == '1';
        
        if ($isBuyNow && isset($_SESSION['buy_now_item'])) {
            // Xử lý Mua Ngay
            $buyNowItem = $_SESSION['buy_now_item'];
            $variant = $this->productModel->getVariantById($buyNowItem['variant_id']);
            
            if (!$variant) {
                $_SESSION['error'] = 'Sản phẩm không tồn tại';
                unset($_SESSION['buy_now_item']);
                $this->redirect('product/index');
                return;
            }
            
            $cartItems = [[
                'variant_id' => $variant['variant_id'],
                'price' => $variant['price'],
                'quantity' => $buyNowItem['quantity'],
                'subtotal' => $variant['price'] * $buyNowItem['quantity']
            ]];
            $total = $variant['price'] * $buyNowItem['quantity'];
        } else {
            // Xử lý thanh toán giỏ hàng bình thường
            $cartItems = $this->cartModel->getCartItems();
            if (empty($cartItems)) {
                $_SESSION['error'] = 'Giỏ hàng trống';
                $this->redirect('cart/index');
                return;
            }
            $total = $this->cartModel->getCartTotal();
        }
        
        // Lấy thông tin khách hàng
        $customerData = [
            'full_name' => $_POST['full_name'] ?? '',
            'phone_number' => $_POST['phone_number'] ?? '',
            'email' => $_POST['email'] ?? '',
            'address' => $_POST['address'] ?? '',
            'gender' => $_POST['gender'] ?? '',
            'date_of_birth' => $_POST['date_of_birth'] ?? null
        ];
        
        // Kiểm tra email đã tồn tại chưa
        $customer = $this->customerModel->getCustomerByEmail($customerData['email']);
        if ($customer) {
            $customerId = $customer['customer_id'];
        } else {
            $customerId = $this->customerModel->createCustomer($customerData);
        }
        
        if (!$customerId) {
            $_SESSION['error'] = 'Không thể tạo khách hàng';
            $this->redirect('cart/checkout');
        }
        
        // Xử lý mã giảm giá
        $discountAmount = 0;
        $couponId = null;
        $appliedCoupon = null;
        
        if (isset($_SESSION['applied_coupon'])) {
            $appliedCoupon = $_SESSION['applied_coupon'];
            $couponId = $appliedCoupon['coupon_id'];
            
            // Validate lại mã giảm giá
            $couponResult = $this->couponModel->validateCoupon($appliedCoupon['code'], $total, $customerId);
            if ($couponResult['valid']) {
                $discountAmount = $couponResult['discount_amount'];
            } else {
                // Mã không còn hợp lệ
                unset($_SESSION['applied_coupon']);
                $couponId = null;
            }
        }
        
        // Tính tổng sau giảm giá
        $finalTotal = $total - $discountAmount;
        if ($finalTotal < 0) $finalTotal = 0;
        
        // Tạo đơn hàng
        $paymentMethod = $_POST['payment_method'] ?? 'Tiền mặt';
        $note = $_POST['note'] ?? '';
        
        $orderId = $this->orderModel->createOrder($customerId, $finalTotal, $paymentMethod, $note, $couponId, $discountAmount);
        
        if ($orderId) {
            // Ghi nhận sử dụng mã giảm giá
            if ($couponId && $discountAmount > 0) {
                $this->couponModel->recordCouponUsage($couponId, $customerId, $orderId, $discountAmount);
                unset($_SESSION['applied_coupon']);
            }
            
            // Tạo chi tiết đơn hàng
            foreach ($cartItems as $item) {
                $this->orderModel->createOrderDetail(
                    $orderId,
                    $item['variant_id'],
                    $item['quantity'],
                    $item['price'],
                    0,
                    $item['subtotal']
                );
            }
            
            // Nếu thanh toán VNPay, chuyển hướng đến VNPay
            if ($paymentMethod === 'VNPay') {
                $_SESSION['pending_order_id'] = $orderId;
                if ($isBuyNow) {
                    unset($_SESSION['buy_now_item']);
                }
                $this->redirect('cart/vnpayPayment/' . $orderId);
                return;
            }
            
            // Xóa giỏ hàng hoặc buy_now session
            if ($isBuyNow) {
                unset($_SESSION['buy_now_item']);
            } else {
                $this->cartModel->clearCart();
            }
            
            $_SESSION['success'] = 'Đặt hàng thành công! Mã đơn hàng: #' . $orderId;
            $this->redirect('cart/orderSuccess/' . $orderId);
        } else {
            $_SESSION['error'] = 'Không thể tạo đơn hàng';
            $this->redirect('cart/checkout');
        }
    }
    
    public function vnpayPayment($orderId) {
        $order = $this->orderModel->getOrderById($orderId);
        
        if (!$order) {
            $_SESSION['error'] = 'Đơn hàng không tồn tại';
            $this->redirect('cart/index');
            return;
        }
        
        // Load VNPay config
        require_once 'vnpay_php/config.php';
        
        $vnp_TxnRef = $orderId;
        $vnp_OrderInfo = 'Thanh toán đơn hàng #' . $orderId;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $order['total_amount'] * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        
        header('Location: ' . $vnp_Url);
        die();
    }
    
    public function vnpayReturn() {
        // Load VNPay config
        require_once 'vnpay_php/config.php';
        
        $vnp_SecureHash = $_GET['vnp_SecureHash'] ?? '';
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        
        $orderId = $_GET['vnp_TxnRef'] ?? 0;
        $vnpResponseCode = $_GET['vnp_ResponseCode'] ?? '';
        
        if ($secureHash == $vnp_SecureHash) {
            if ($vnpResponseCode == '00') {
                // Thanh toán thành công
                $this->orderModel->updateOrderStatus($orderId, 2); // Đã thanh toán
                $this->cartModel->clearCart();
                unset($_SESSION['pending_order_id']);
                
                $_SESSION['success'] = 'Thanh toán thành công! Mã đơn hàng: #' . $orderId;
                $this->redirect('cart/orderSuccess/' . $orderId);
            } else {
                // Thanh toán thất bại
                $_SESSION['error'] = 'Thanh toán thất bại. Vui lòng thử lại.';
                $this->redirect('cart/checkout');
            }
        } else {
            $_SESSION['error'] = 'Chữ ký không hợp lệ';
            $this->redirect('cart/checkout');
        }
    }
    
    public function orderSuccess($orderId) {
        $order = $this->orderModel->getOrderById($orderId);
        $orderDetails = $this->orderModel->getOrderDetails($orderId);
        
        $data = [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'pageTitle' => 'Đặt Hàng Thành Công'
        ];
        
        $this->view('cart/order_success', $data);
    }
    
    // Lấy giỏ hàng hiện tại (để sync với localStorage)
    public function getCart() {
        if (!isset($_SESSION['customer_id'])) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Chưa đăng nhập'
            ], 401);
            return;
        }
        
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $this->jsonResponse([
            'success' => true,
            'cart' => $cart,
            'cartCount' => $this->cartModel->getCartCount()
        ]);
    }
    
    // Áp dụng mã giảm giá
    public function applyCoupon() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request'], 400);
            return;
        }
        
        $code = trim($_POST['coupon_code'] ?? '');
        
        if (empty($code)) {
            $this->jsonResponse(['success' => false, 'message' => 'Vui lòng nhập mã giảm giá']);
            return;
        }
        
        // Lấy tổng tiền giỏ hàng
        $isBuyNow = isset($_POST['is_buy_now']) && $_POST['is_buy_now'] == '1';
        
        if ($isBuyNow && isset($_SESSION['buy_now_item'])) {
            $buyNowItem = $_SESSION['buy_now_item'];
            $variant = $this->productModel->getVariantById($buyNowItem['variant_id']);
            $total = $variant ? $variant['price'] * $buyNowItem['quantity'] : 0;
        } else {
            $total = $this->cartModel->getCartTotal();
        }
        
        if ($total <= 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Giỏ hàng trống']);
            return;
        }
        
        // Validate mã giảm giá
        $customerId = $_SESSION['customer_id'] ?? null;
        $result = $this->couponModel->validateCoupon($code, $total, $customerId);
        
        if ($result['valid']) {
            // Lưu mã giảm giá vào session
            $_SESSION['applied_coupon'] = [
                'coupon_id' => $result['coupon']['coupon_id'],
                'code' => $result['coupon']['code'],
                'discount_amount' => $result['discount_amount'],
                'discount_type' => $result['coupon']['discount_type'],
                'discount_value' => $result['coupon']['discount_value']
            ];
            
            $this->jsonResponse([
                'success' => true,
                'message' => $result['message'],
                'discount_amount' => $result['discount_amount'],
                'discount_formatted' => number_format($result['discount_amount'], 0, ',', '.') . '₫',
                'new_total' => $total - $result['discount_amount'],
                'new_total_formatted' => number_format($total - $result['discount_amount'], 0, ',', '.') . '₫',
                'coupon' => [
                    'code' => $result['coupon']['code'],
                    'description' => $result['coupon']['description']
                ]
            ]);
        } else {
            $this->jsonResponse(['success' => false, 'message' => $result['message']]);
        }
    }
    
    // Xóa mã giảm giá đã áp dụng
    public function removeCoupon() {
        if (isset($_SESSION['applied_coupon'])) {
            unset($_SESSION['applied_coupon']);
        }
        
        if (isset($_POST['ajax']) || isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Đã xóa mã giảm giá'
            ]);
            return;
        }
        
        $_SESSION['success'] = 'Đã xóa mã giảm giá';
        $this->redirect('cart/checkout');
    }
    
    // Đồng bộ giỏ hàng từ localStorage lên session
    public function syncCart() {
        if (!isset($_SESSION['customer_id'])) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Chưa đăng nhập'
            ], 401);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart'])) {
            $cartData = json_decode($_POST['cart'], true);
            
            if (is_array($cartData)) {
                // Validate và merge với cart hiện tại
                $validCart = [];
                foreach ($cartData as $variantId => $quantity) {
                    $variantId = (int)$variantId;
                    $quantity = (int)$quantity;
                    
                    if ($variantId > 0 && $quantity > 0) {
                        // Kiểm tra tồn kho
                        $sql = "SELECT stock_quantity FROM Product_Variants WHERE variant_id = :variant_id";
                        $stmt = $this->cartModel->conn->prepare($sql);
                        $stmt->bindParam(':variant_id', $variantId);
                        $stmt->execute();
                        $variant = $stmt->fetch();
                        
                        if ($variant && $variant['stock_quantity'] >= $quantity) {
                            $validCart[$variantId] = $quantity;
                        } else if ($variant && $variant['stock_quantity'] > 0) {
                            // Điều chỉnh số lượng nếu vượt quá tồn kho
                            $validCart[$variantId] = $variant['stock_quantity'];
                        }
                    }
                }
                
                // Merge với cart hiện tại (ưu tiên số lượng lớn hơn)
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }
                
                foreach ($validCart as $variantId => $quantity) {
                    if (!isset($_SESSION['cart'][$variantId]) || $_SESSION['cart'][$variantId] < $quantity) {
                        $_SESSION['cart'][$variantId] = $quantity;
                    }
                }
                
                // Xóa các sản phẩm không còn trong localStorage
                foreach ($_SESSION['cart'] as $variantId => $quantity) {
                    if (!isset($validCart[$variantId])) {
                        // Giữ lại trong session nếu đang ở trang cart
                        // Chỉ xóa nếu không có trong localStorage
                    }
                }
                
                $this->jsonResponse([
                    'success' => true,
                    'cart' => $_SESSION['cart'],
                    'cartCount' => $this->cartModel->getCartCount(),
                    'message' => 'Đã đồng bộ giỏ hàng'
                ]);
                return;
            }
        }
        
        $this->jsonResponse([
            'success' => false,
            'message' => 'Dữ liệu không hợp lệ'
        ], 400);
    }
}
?>

