<?php
namespace App\Models;

class CustomerModel {
    private $db;
    
    public function __construct() {
        $this->db = \App\Models\Database::getInstance();
    }
    
    public function create($data) {
        $sql = "INSERT INTO Customers (full_name, phone_number, email, address, gender, date_of_birth) 
                VALUES (?, ?, ?, ?, ?, ?)";
        return $this->db->insert($sql, [
            $data['full_name'],
            $data['phone_number'],
            $data['email'],
            $data['address'] ?? '',
            $data['gender'] ?? '',
            $data['date_of_birth'] ?? null
        ], "ssssss");
    }
    
    public function findByPhoneOrEmail($identifier) {
        $sql = "SELECT * FROM Customers WHERE phone_number = ? OR email = ?";
        return $this->db->fetchOne($sql, [$identifier, $identifier], "ss");
    }
    
    public function getById($customer_id) {
        $sql = "SELECT * FROM Customers WHERE customer_id = ?";
        return $this->db->fetchOne($sql, [$customer_id], "i");
    }
    
    public function exists($phone_number, $email) {
        $sql = "SELECT customer_id FROM Customers WHERE phone_number = ? OR email = ?";
        $result = $this->db->fetchOne($sql, [$phone_number, $email], "ss");
        return $result !== null;
    }
}

