<?php
namespace App\Models;

class ProductModel {
    private $db;
    
    public function __construct() {
        $this->db = \App\Models\Database::getInstance();
    }
    
    public function getAll($filters = []) {
        $where = ["pv.stock_quantity > 0"];
        $params = [];
        $types = "";
        
        if (!empty($filters['category_id'])) {
            $where[] = "p.category_id = ?";
            $params[] = $filters['category_id'];
            $types .= "i";
        }
        
        if (!empty($filters['brand'])) {
            $where[] = "p.brand = ?";
            $params[] = $filters['brand'];
            $types .= "s";
        }
        
        if (!empty($filters['search'])) {
            $where[] = "(p.product_name LIKE ? OR p.brand LIKE ? OR p.description LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
            $types .= "sss";
        }
        
        $whereClause = implode(" AND ", $where);
        
        $orderBy = "pv.created_at DESC";
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'price_asc':
                    $orderBy = "pv.price ASC";
                    break;
                case 'price_desc':
                    $orderBy = "pv.price DESC";
                    break;
                case 'name':
                    $orderBy = "p.product_name ASC";
                    break;
            }
        }
        
        $sql = "SELECT pv.*, p.product_name, p.brand, p.description, c.category_name 
                FROM Product_Variants pv 
                JOIN Products p ON pv.product_id = p.product_id 
                LEFT JOIN Categories c ON p.category_id = c.category_id 
                WHERE $whereClause 
                ORDER BY $orderBy";
        
        return $this->db->fetchAll($sql, $params, $types);
    }
    
    public function getById($variant_id) {
        $sql = "SELECT pv.*, p.product_name, p.brand, p.description, c.category_name 
                FROM Product_Variants pv 
                JOIN Products p ON pv.product_id = p.product_id 
                LEFT JOIN Categories c ON p.category_id = c.category_id 
                WHERE pv.variant_id = ?";
        return $this->db->fetchOne($sql, [$variant_id], "i");
    }
    
    public function getFeatured($limit = 8) {
        $sql = "SELECT pv.*, p.product_name, p.brand, p.description, c.category_name 
                FROM Product_Variants pv 
                JOIN Products p ON pv.product_id = p.product_id 
                LEFT JOIN Categories c ON p.category_id = c.category_id 
                WHERE pv.stock_quantity > 0 
                ORDER BY pv.created_at DESC 
                LIMIT ?";
        return $this->db->fetchAll($sql, [$limit], "i");
    }
    
    public function getOtherVariants($product_id, $current_variant_id) {
        $sql = "SELECT * FROM Product_Variants 
                WHERE product_id = ? 
                AND variant_id != ?";
        return $this->db->fetchAll($sql, [$product_id, $current_variant_id], "ii");
    }
    
    public function getCategories() {
        $sql = "SELECT * FROM Categories";
        return $this->db->fetchAll($sql);
    }
    
    public function getBrands() {
        $sql = "SELECT DISTINCT brand FROM Products WHERE brand IS NOT NULL ORDER BY brand";
        return $this->db->fetchAll($sql);
    }
    
    public function updateStock($variant_id, $quantity) {
        $sql = "UPDATE Product_Variants SET stock_quantity = stock_quantity - ? WHERE variant_id = ?";
        return $this->db->update($sql, [$quantity, $variant_id], "ii");
    }
}