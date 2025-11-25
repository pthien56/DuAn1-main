<?php
namespace App\Models;

class PaymentModel {
    private $db;
    
    public function __construct() {
        $this->db = \App\Models\Database::getInstance();
    }
    
    public function create($data) {
        $sql = "INSERT INTO Payments (order_id, amount, payment_method, payment_status_id, transaction_code, note) 
                VALUES (?, ?, ?, ?, ?, ?)";
        return $this->db->insert($sql, [
            $data['order_id'],
            $data['amount'],
            $data['payment_method'],
            $data['payment_status_id'],
            $data['transaction_code'] ?? '',
            $data['note'] ?? ''
        ], "idssss");
    }
    
    public function getByOrderId($order_id) {
        $sql = "SELECT p.*, ps.status_name as payment_status_name 
                FROM Payments p 
                JOIN Payment_Status ps ON p.payment_status_id = ps.payment_status_id 
                WHERE p.order_id = ?";
        return $this->db->fetchOne($sql, [$order_id], "i");
    }
}

