<?php
namespace App\Models;

class EmployeeModel {
    private $db;
    
    public function __construct() {
        $this->db = \App\Models\Database::getInstance();
    }
    
    public function getDefaultEmployeeId() {
        $result = $this->db->fetchOne("SELECT employee_id FROM Employees LIMIT 1");
        return $result['employee_id'] ?? null;
    }
}

