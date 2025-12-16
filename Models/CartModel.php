<?php
// BaseModel đã được load từ index.php

class CartModel extends BaseModel {
    
    public function getCartItems() {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            return [];
        }
        
        $cartItems = [];
        foreach ($_SESSION['cart'] as $variantId => $quantity) {
            $sql = "SELECT pv.*, p.product_id, p.product_name, p.brand, p.description, 
                           pv.variant_name, pv.color, pv.storage
                    FROM Product_Variants pv 
                    JOIN Products p ON pv.product_id = p.product_id 
                    WHERE pv.variant_id = :variant_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':variant_id', $variantId);
            $stmt->execute();
            $item = $stmt->fetch();
            
            if ($item) {
                // Điều chỉnh số lượng nếu vượt quá tồn kho
                if ($item['stock_quantity'] < $quantity) {
                    $quantity = $item['stock_quantity'];
                    $_SESSION['cart'][$variantId] = $quantity;
                }
                
                // Chỉ thêm vào danh sách nếu còn hàng
                if ($quantity > 0) {
                    $item['quantity'] = $quantity;
                    $item['subtotal'] = $item['price'] * $quantity;
                    $cartItems[] = $item;
                } else {
                    // Xóa khỏi giỏ hàng nếu hết hàng
                    unset($_SESSION['cart'][$variantId]);
                }
            } else {
                // Xóa khỏi giỏ hàng nếu sản phẩm không tồn tại
                unset($_SESSION['cart'][$variantId]);
            }
        }
        
        return $cartItems;
    }
    
    public function addToCart($variantId, $quantity = 1) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Kiểm tra tồn kho
        $sql = "SELECT stock_quantity FROM Product_Variants WHERE variant_id = :variant_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':variant_id', $variantId);
        $stmt->execute();
        $variant = $stmt->fetch();
        
        if (!$variant || $variant['stock_quantity'] < $quantity) {
            return false;
        }
        
        if (isset($_SESSION['cart'][$variantId])) {
            $newQuantity = $_SESSION['cart'][$variantId] + $quantity;
            if ($newQuantity > $variant['stock_quantity']) {
                return false;
            }
            $_SESSION['cart'][$variantId] = $newQuantity;
        } else {
            $_SESSION['cart'][$variantId] = $quantity;
        }
        
        return true;
    }
    
    public function updateCart($variantId, $quantity) {
        if (!isset($_SESSION['cart'])) {
            return false;
        }
        
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$variantId]);
            return true;
        }
        
        // Kiểm tra tồn kho
        $sql = "SELECT stock_quantity FROM Product_Variants WHERE variant_id = :variant_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':variant_id', $variantId);
        $stmt->execute();
        $variant = $stmt->fetch();
        
        if (!$variant || $variant['stock_quantity'] < $quantity) {
            return false;
        }
        
        $_SESSION['cart'][$variantId] = $quantity;
        return true;
    }
    
    public function removeFromCart($variantId) {
        if (isset($_SESSION['cart'][$variantId])) {
            unset($_SESSION['cart'][$variantId]);
            return true;
        }
        return false;
    }
    
    public function clearCart() {
        $_SESSION['cart'] = [];
        return true;
    }
    
    public function getCartTotal() {
        $items = $this->getCartItems();
        $total = 0;
        foreach ($items as $item) {
            $total += $item['subtotal'];
        }
        return $total;
    }
    
    public function getCartCount() {
        if (!isset($_SESSION['cart'])) {
            return 0;
        }
        return array_sum($_SESSION['cart']);
    }
}
?>

