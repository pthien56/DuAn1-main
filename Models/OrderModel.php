<?php
// BaseModel đã được load từ index.php

class OrderModel extends BaseModel {
    
    public function createOrder($customerId, $totalAmount, $paymentMethod, $note = '', $couponId = null, $discountAmount = 0) {
        $sql = "INSERT INTO Orders (customer_id, total_amount, payment_method, note, order_status_id, coupon_id, discount_amount) 
                VALUES (:customer_id, :total_amount, :payment_method, :note, 1, :coupon_id, :discount_amount)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':customer_id', $customerId);
        $stmt->bindParam(':total_amount', $totalAmount);
        $stmt->bindParam(':payment_method', $paymentMethod);
        $stmt->bindParam(':note', $note);
        $stmt->bindParam(':coupon_id', $couponId);
        $stmt->bindParam(':discount_amount', $discountAmount);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }
    
    public function createOrderDetail($orderId, $variantId, $quantity, $unitPrice, $discount, $subtotal) {
        $sql = "INSERT INTO Order_Details 
                (order_id, variant_id, quantity, unit_price, discount, subtotal) 
                VALUES (:order_id, :variant_id, :quantity, :unit_price, :discount, :subtotal)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->bindParam(':variant_id', $variantId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':unit_price', $unitPrice);
        $stmt->bindParam(':discount', $discount);
        $stmt->bindParam(':subtotal', $subtotal);
        
        if ($stmt->execute()) {
            // Cập nhật số lượng tồn kho
            $this->updateStock($variantId, -$quantity);
            return true;
        }
        return false;
    }
    
    public function updateStock($variantId, $quantity) {
        $sql = "UPDATE Product_Variants SET stock_quantity = stock_quantity + :quantity WHERE variant_id = :variant_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':variant_id', $variantId);
        return $stmt->execute();
    }
    
    public function getOrderById($id) {
        $sql = "SELECT o.*, c.full_name as customer_name, c.phone_number, c.email, c.address,
                       os.status_name
                FROM Orders o 
                LEFT JOIN Customers c ON o.customer_id = c.customer_id 
                LEFT JOIN Order_Status os ON o.order_status_id = os.order_status_id 
                WHERE o.order_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function getOrderDetails($orderId) {
        $sql = "SELECT od.*, pv.variant_name, pv.color, pv.storage, p.product_name, p.brand
                FROM Order_Details od 
                JOIN Product_Variants pv ON od.variant_id = pv.variant_id 
                JOIN Products p ON pv.product_id = p.product_id 
                WHERE od.order_id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getOrdersByCustomer($customerId) {
        $sql = "SELECT o.*, os.status_name 
                FROM Orders o 
                LEFT JOIN Order_Status os ON o.order_status_id = os.order_status_id 
                WHERE o.customer_id = :customer_id 
                ORDER BY o.order_date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':customer_id', $customerId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getAllOrders($limit = null, $offset = 0) {
        $sql = "SELECT o.*, c.full_name as customer_name, os.status_name 
                FROM Orders o 
                LEFT JOIN Customers c ON o.customer_id = c.customer_id 
                LEFT JOIN Order_Status os ON o.order_status_id = os.order_status_id 
                ORDER BY o.order_date DESC";
        if ($limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }
        $stmt = $this->conn->prepare($sql);
        if ($limit) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function updateOrderStatus($orderId, $statusId) {
        $sql = "UPDATE Orders SET order_status_id = :status_id WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status_id', $statusId);
        $stmt->bindParam(':order_id', $orderId);
        return $stmt->execute();
    }
    
    public function getAllOrderStatuses() {
        $sql = "SELECT * FROM Order_Status ORDER BY order_status_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>

