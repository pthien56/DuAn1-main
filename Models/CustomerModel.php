<?php
// BaseModel đã được load từ index.php

class CustomerModel extends BaseModel {
    
    public function createCustomer($data) {
        // Đảm bảo cột password tồn tại
        $this->ensurePasswordColumn();
        
        $sql = "INSERT INTO Customers (full_name, phone_number, email, address, gender, date_of_birth, password) 
                VALUES (:full_name, :phone_number, :email, :address, :gender, :date_of_birth, :password)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute($data)) {
            return $this->conn->lastInsertId();
        }
        return false;
    }
    
    private static $passwordColumnChecked = false;
    
    private function ensurePasswordColumn() {
        // Chỉ kiểm tra 1 lần trong mỗi request
        if (self::$passwordColumnChecked) {
            return;
        }
        self::$passwordColumnChecked = true;
        
        try {
            $checkColumn = $this->conn->query("SHOW COLUMNS FROM Customers LIKE 'password'");
            if ($checkColumn && $checkColumn->rowCount() == 0) {
                $this->conn->exec("ALTER TABLE Customers ADD COLUMN password VARCHAR(255) AFTER email");
            }
        } catch (PDOException $e) {
            // Bỏ qua lỗi nếu cột đã tồn tại
        }
    }
    
    public function getCustomerById($id) {
        $sql = "SELECT * FROM Customers WHERE customer_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function getCustomerByEmail($email) {
        // Đảm bảo cột password tồn tại
        $this->ensurePasswordColumn();
        
        $sql = "SELECT * FROM Customers WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function getAllCustomers($limit = null, $offset = 0) {
        $sql = "SELECT * FROM Customers ORDER BY created_at DESC";
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
    
    public function updateCustomer($id, $data) {
        $sql = "UPDATE Customers SET 
                full_name = :full_name,
                phone_number = :phone_number,
                email = :email,
                address = :address,
                gender = :gender,
                date_of_birth = :date_of_birth
                WHERE customer_id = :id";
        $stmt = $this->conn->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }
    
    public function deleteCustomer($id) {
        $sql = "DELETE FROM Customers WHERE customer_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function toggleCustomerStatus($id) {
        // Kiểm tra xem bảng có cột status không, nếu không thì tạo
        try {
            $checkColumn = $this->conn->query("SHOW COLUMNS FROM Customers LIKE 'status'");
            if ($checkColumn->rowCount() == 0) {
                $this->conn->exec("ALTER TABLE Customers ADD COLUMN status VARCHAR(20) DEFAULT 'active'");
            }
        } catch (Exception $e) {
            // Column đã tồn tại hoặc có lỗi
        }
        
        // Lấy trạng thái hiện tại
        $customer = $this->getCustomerById($id);
        if (!$customer) {
            return false;
        }
        
        $currentStatus = $customer['status'] ?? 'active';
        $newStatus = ($currentStatus == 'active' || $currentStatus == null) ? 'locked' : 'active';
        
        $sql = "UPDATE Customers SET status = :status WHERE customer_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $newStatus);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>

