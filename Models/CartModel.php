<?php
namespace App\Models;

class CartModel {
    private $db;
    
    public function __construct() {
        $this->db = \App\Models\Database::getInstance();
    }
    
    public function getCartItems($cart) {
        $items = [];
        foreach ($cart as $variant_id => $quantity) {
            $sql = "SELECT pv.*, p.product_name, p.brand 
                    FROM Product_Variants pv 
                    JOIN Products p ON pv.product_id = p.product_id 
                    WHERE pv.variant_id = ?";
            $product = $this->db->fetchOne($sql, [$variant_id], "i");
            
            if ($product) {
                $product['cart_quantity'] = $quantity;
                $product['subtotal'] = $product['price'] * $quantity;
                $items[] = $product;
            }
        }
        return $items;
    }
    
    public function calculateTotal($items) {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['subtotal'];
        }
        return $total;
    }
}

