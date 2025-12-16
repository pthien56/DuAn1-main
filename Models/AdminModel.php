<?php
// BaseModel đã được load từ index.php

class AdminModel extends BaseModel {
    
    public function login($username, $password) {
        $sql = "SELECT * FROM Managers WHERE username = :username AND status = 'active'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $manager = $stmt->fetch();
        
        if ($manager && password_verify($password, $manager['password'])) {
            return $manager;
        }
        return false;
    }
    
    public function getManagerById($id) {
        $sql = "SELECT * FROM Managers WHERE manager_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function getAllManagers() {
        $sql = "SELECT * FROM Managers ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function createManager($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO Managers (username, password, full_name, phone_number, email, role, status) 
                VALUES (:username, :password, :full_name, :phone_number, :email, :role, :status)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
    
    public function updateManager($id, $data) {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $sql = "UPDATE Managers SET 
                    username = :username,
                    password = :password,
                    full_name = :full_name,
                    phone_number = :phone_number,
                    email = :email,
                    role = :role,
                    status = :status
                    WHERE manager_id = :id";
        } else {
            unset($data['password']);
            $sql = "UPDATE Managers SET 
                    username = :username,
                    full_name = :full_name,
                    phone_number = :phone_number,
                    email = :email,
                    role = :role,
                    status = :status
                    WHERE manager_id = :id";
        }
        $stmt = $this->conn->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }
    
    public function deleteManager($id) {
        $sql = "DELETE FROM Managers WHERE manager_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function getDashboardStats() {
        $stats = [];
        
        // Tổng số sản phẩm
        $sql = "SELECT COUNT(*) as total FROM Products";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stats['total_products'] = (int) $stmt->fetchColumn();
        
        // Tổng số đơn hàng
        $sql = "SELECT COUNT(*) as total FROM Orders";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stats['total_orders'] = (int) $stmt->fetchColumn();
        
        // Tổng số khách hàng
        $sql = "SELECT COUNT(*) as total FROM Customers";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stats['total_customers'] = (int) $stmt->fetchColumn();
        
        // Doanh thu tháng này
        $sql = "SELECT SUM(total_amount) as total FROM Orders 
                WHERE MONTH(order_date) = MONTH(CURRENT_DATE()) 
                AND YEAR(order_date) = YEAR(CURRENT_DATE())";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stats['revenue_month'] = $stmt->fetchColumn() ?? 0;
        
        // Đơn hàng mới hôm nay
        $sql = "SELECT COUNT(*) as total FROM Orders 
            WHERE DATE(order_date) = CURDATE()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stats['orders_today'] = (int) $stmt->fetchColumn();
        
        return $stats;
    }
}
?>

