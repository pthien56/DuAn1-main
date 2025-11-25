<?php
namespace App\Models;

class AdminModel {
    private $db;
    
    public function __construct() {
        $this->db = \App\Models\Database::getInstance();
    }
    
    public function getStatistics() {
        $stats = [];
        
        $result = $this->db->fetchOne("SELECT COUNT(*) as count FROM Product_Variants WHERE stock_quantity > 0");
        $stats['total_products'] = $result['count'] ?? 0;
        
        $result = $this->db->fetchOne("SELECT COUNT(*) as count FROM Orders");
        $stats['total_orders'] = $result['count'] ?? 0;
        
        $result = $this->db->fetchOne("SELECT SUM(total_amount) as total FROM Orders WHERE order_status_id IN (SELECT order_status_id FROM Order_Status WHERE status_name = 'Đã giao hàng')");
        $stats['total_revenue'] = $result['total'] ?? 0;
        
        $result = $this->db->fetchOne("SELECT COUNT(*) as count FROM Customers");
        $stats['total_customers'] = $result['count'] ?? 0;
        
        return $stats;
    }
    
    public function getRecentOrders($limit = 10) {
        $sql = "SELECT o.*, c.full_name, os.status_name 
                FROM Orders o 
                JOIN Customers c ON o.customer_id = c.customer_id 
                JOIN Order_Status os ON o.order_status_id = os.order_status_id 
                ORDER BY o.order_date DESC 
                LIMIT ?";
        return $this->db->fetchAll($sql, [$limit], "i");
    }
    
    public function getLowStockProducts($limit = 10, $threshold = 10) {
        $sql = "SELECT pv.*, p.product_name 
                FROM Product_Variants pv 
                JOIN Products p ON pv.product_id = p.product_id 
                WHERE pv.stock_quantity < ? 
                ORDER BY pv.stock_quantity ASC 
                LIMIT ?";
        return $this->db->fetchAll($sql, [$threshold, $limit], "ii");
    }
    
    public function getAllProducts() {
        $sql = "SELECT pv.*, p.product_name, p.brand, c.category_name 
                FROM Product_Variants pv 
                JOIN Products p ON pv.product_id = p.product_id 
                LEFT JOIN Categories c ON p.category_id = c.category_id 
                ORDER BY pv.created_at DESC";
        return $this->db->fetchAll($sql);
    }
    
    public function deleteProduct($variant_id) {
        $sql = "DELETE FROM Product_Variants WHERE variant_id = ?";
        return $this->db->delete($sql, [$variant_id], "i");
    }
}

