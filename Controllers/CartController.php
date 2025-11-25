<?php
namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductModel;

class CartController extends BaseController {
    private $cartModel;
    private $productModel;
    
    public function __construct() {
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
        
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }
    
    public function index() {
        // Không yêu cầu đăng nhập để xem giỏ hàng
        // Chỉ yêu cầu khi checkout
        
        $cartItems = $this->cartModel->getCartItems($_SESSION['cart'] ?? []);
        $total = $this->cartModel->calculateTotal($cartItems);
        
        $this->view('cart/index', [
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }
    
    public function add() {
        $variant_id = intval($_POST['variant_id'] ?? 0);
        $quantity = intval($_POST['quantity'] ?? 1);
        
        if ($variant_id > 0) {
            // Kiểm tra stock
            $product = $this->productModel->getById($variant_id);
            if (!$product || $product['stock_quantity'] <= 0) {
                $this->json([
                    'success' => false,
                    'message' => 'Sản phẩm đã hết hàng'
                ]);
                return;
            }
            
            $currentQuantity = $_SESSION['cart'][$variant_id] ?? 0;
            $newQuantity = $currentQuantity + $quantity;
            
            if ($newQuantity > $product['stock_quantity']) {
                $this->json([
                    'success' => false,
                    'message' => 'Số lượng vượt quá tồn kho. Tồn kho còn lại: ' . $product['stock_quantity']
                ]);
                return;
            }
            
            $_SESSION['cart'][$variant_id] = $newQuantity;
            
            $this->json([
                'success' => true,
                'message' => 'Đã thêm vào giỏ hàng',
                'cart_count' => count($_SESSION['cart'])
            ]);
        } else {
            $this->json([
                'success' => false,
                'message' => 'ID sản phẩm không hợp lệ'
            ]);
        }
    }
    
    public function update() {
        $variant_id = intval($_POST['variant_id'] ?? 0);
        $quantity = intval($_POST['quantity'] ?? 0);
        
        if ($variant_id > 0) {
            // Kiểm tra stock
            $product = $this->productModel->getById($variant_id);
            if (!$product) {
                $this->json([
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại'
                ]);
                return;
            }
            
            if ($quantity > 0) {
                if ($quantity > $product['stock_quantity']) {
                    $this->json([
                        'success' => false,
                        'message' => 'Số lượng vượt quá tồn kho. Tồn kho còn lại: ' . $product['stock_quantity']
                    ]);
                    return;
                }
                $_SESSION['cart'][$variant_id] = $quantity;
            } else {
                unset($_SESSION['cart'][$variant_id]);
            }
            
            $this->json([
                'success' => true,
                'message' => 'Đã cập nhật giỏ hàng',
                'cart_count' => count($_SESSION['cart'])
            ]);
        } else {
            $this->json([
                'success' => false,
                'message' => 'ID sản phẩm không hợp lệ'
            ]);
        }
    }
    
    public function remove() {
        $variant_id = intval($_POST['variant_id'] ?? 0);
        
        if ($variant_id > 0 && isset($_SESSION['cart'][$variant_id])) {
            unset($_SESSION['cart'][$variant_id]);
            $this->json([
                'success' => true,
                'message' => 'Đã xóa khỏi giỏ hàng',
                'cart_count' => count($_SESSION['cart'])
            ]);
        } else {
            $this->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại trong giỏ hàng'
            ]);
        }
    }
    
    public function get() {
        $this->json([
            'success' => true,
            'cart' => $_SESSION['cart'] ?? [],
            'cart_count' => count($_SESSION['cart'] ?? [])
        ]);
    }
}