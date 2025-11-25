<?php
namespace App\Models;

class OrderModel {
    private $db;
    
    public function __construct() {
        $this->db = \App\Models\Database::getInstance();
    }
    
    public function create($data) {
        $sql = "INSERT INTO Orders (customer_id, employee_id, total_amount, order_status_id, payment_method, note) 
                VALUES (?, ?, ?, ?, ?, ?)";
        return $this->db->insert($sql, [
            $data['customer_id'],
            $data['employee_id'],
            $data['total_amount'],
            $data['order_status_id'],
            $data['payment_method'],
            $data['note'] ?? ''
        ], "iidiss");
    }
    
    public function createDetail($order_id, $items) {
        foreach ($items as $item) {
            $sql = "INSERT INTO Order_Details (order_id, variant_id, quantity, unit_price, discount, subtotal) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $this->db->insert($sql, [
                $order_id,
                $item['variant_id'],
                $item['quantity'],
                $item['price'],
                $item['discount'] ?? 0,
                $item['subtotal']
            ], "iiiddd");
        }
    }
    
    public function getByCustomerId($customer_id) {
        $sql = "SELECT o.*, os.status_name 
                FROM Orders o 
                JOIN Order_Status os ON o.order_status_id = os.order_status_id 
                WHERE o.customer_id = ? 
                ORDER BY o.order_date DESC";
        return $this->db->fetchAll($sql, [$customer_id], "i");
    }
    
    public function getById($order_id) {
        $sql = "SELECT o.*, c.full_name, c.phone_number, c.email, c.address, os.status_name 
                FROM Orders o 
                JOIN Customers c ON o.customer_id = c.customer_id 
                JOIN Order_Status os ON o.order_status_id = os.order_status_id 
                WHERE o.order_id = ?";
        return $this->db->fetchOne($sql, [$order_id], "i");
    }
    
    public function getDetails($order_id) {
        $sql = "SELECT od.*, pv.variant_name, p.product_name, p.brand 
                FROM Order_Details od 
                JOIN Product_Variants pv ON od.variant_id = pv.variant_id 
                JOIN Products p ON pv.product_id = p.product_id 
                WHERE od.order_id = ?";
        return $this->db->fetchAll($sql, [$order_id], "i");
    }
    
    public function getAll() {
        $sql = "SELECT o.*, c.full_name, os.status_name 
                FROM Orders o 
                JOIN Customers c ON o.customer_id = c.customer_id 
                JOIN Order_Status os ON o.order_status_id = os.order_status_id 
                ORDER BY o.order_date DESC";
        return $this->db->fetchAll($sql);
    }
    
    public function updateStatus($order_id, $status_id) {
        $sql = "UPDATE Orders SET order_status_id = ? WHERE order_id = ?";
        return $this->db->update($sql, [$status_id, $order_id], "ii");
    }
    
    public function getStatuses() {
        $sql = "SELECT * FROM Order_Status";
        return $this->db->fetchAll($sql);
    }
    
    public function getDefaultStatus() {
        $sql = "SELECT order_status_id FROM Order_Status WHERE status_name = 'Chờ xác nhận' LIMIT 1";
        $result = $this->db->fetchOne($sql);
        return $result['order_status_id'] ?? 1;
    }
}

