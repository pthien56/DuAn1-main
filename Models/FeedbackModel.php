<?php
namespace App\Models;

class FeedbackModel {
    private $db;
    
    public function __construct() {
        $this->db = \App\Models\Database::getInstance();
    }
    
    public function getByVariantId($variant_id, $limit = 5) {
        $sql = "SELECT cf.*, c.full_name 
                FROM Customer_Feedback cf 
                JOIN Customers c ON cf.customer_id = c.customer_id 
                WHERE cf.variant_id = ? 
                ORDER BY cf.feedback_date DESC 
                LIMIT ?";
        return $this->db->fetchAll($sql, [$variant_id, $limit], "ii");
    }
}

