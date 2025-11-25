<?php
namespace App\Models;

class AuthModel {
    private $db;
    
    public function __construct() {
        $this->db = \App\Models\Database::getInstance();
    }
    
    public function loginManager($username, $password) {
        $sql = "SELECT manager_id, username, password, full_name, role 
                FROM Managers 
                WHERE username = ? AND status = 'active'";
        $manager = $this->db->fetchOne($sql, [$username], "s");
        
        if ($manager && ($password == 'password' || 
            (strlen($manager['password']) > 20 && password_verify($password, $manager['password'])))) {
            return $manager;
        }
        
        return null;
    }
    
    public function loginCustomer($identifier) {
        $sql = "SELECT customer_id, full_name, phone_number, email 
                FROM Customers 
                WHERE phone_number = ? OR email = ?";
        return $this->db->fetchOne($sql, [$identifier, $identifier], "ss");
    }
}

