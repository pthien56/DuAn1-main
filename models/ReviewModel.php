<?php
// BaseModel đã được load từ index.php

class ReviewModel extends BaseModel {
    
    public function createReview($data) {
        $sql = "INSERT INTO Product_Reviews (product_id, customer_id, rating, comment, status, created_at) 
                VALUES (:product_id, :customer_id, :rating, :comment, 'pending', NOW())";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $data['product_id']);
        $stmt->bindParam(':customer_id', $data['customer_id']);
        $stmt->bindParam(':rating', $data['rating']);
        $stmt->bindParam(':comment', $data['comment']);
        
        return $stmt->execute();
    }
    
    public function getReviewsByProduct($productId, $limit = null, $offset = 0) {
        $sql = "SELECT r.*, c.full_name, c.email 
                FROM Product_Reviews r
                LEFT JOIN Customers c ON r.customer_id = c.customer_id
                WHERE r.product_id = :product_id AND r.status = 'approved'
                ORDER BY r.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $productId);
        
        if ($limit) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getReviewStats($productId) {
        $sql = "SELECT 
                    COUNT(*) as total_reviews,
                    AVG(rating) as average_rating,
                    SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as rating_5,
                    SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as rating_4,
                    SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as rating_3,
                    SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as rating_2,
                    SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as rating_1
                FROM Product_Reviews 
                WHERE product_id = :product_id AND status = 'approved'";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function hasReviewed($productId, $customerId) {
        $sql = "SELECT COUNT(*) as count FROM Product_Reviews 
                WHERE product_id = :product_id AND customer_id = :customer_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $productId);
        $stmt->bindParam(':customer_id', $customerId);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }
    
    public function hasPurchased($productId, $customerId) {
        // Kiểm tra khách hàng đã mua sản phẩm này chưa (đơn hàng đã giao thành công)
        $sql = "SELECT COUNT(*) as count 
                FROM Orders o
                INNER JOIN Order_Details od ON o.order_id = od.order_id
                INNER JOIN Product_Variants pv ON od.variant_id = pv.variant_id
                WHERE o.customer_id = :customer_id 
                AND pv.product_id = :product_id
                AND o.order_status_id IN (2, 5)"; // 2 = Đã xác nhận, 5 = Đã giao hàng
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':customer_id', $customerId);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }
    
    public function getAllReviews($limit = null, $offset = 0) {
        $sql = "SELECT r.*, c.full_name, c.email, p.product_name 
                FROM Product_Reviews r
                LEFT JOIN Customers c ON r.customer_id = c.customer_id
                LEFT JOIN Products p ON r.product_id = p.product_id
                ORDER BY r.created_at DESC";
        
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
    
    public function updateReviewStatus($reviewId, $status) {
        $sql = "UPDATE Product_Reviews SET status = :status WHERE review_id = :review_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':review_id', $reviewId);
        return $stmt->execute();
    }
    
    public function deleteReview($reviewId) {
        $sql = "DELETE FROM Product_Reviews WHERE review_id = :review_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':review_id', $reviewId);
        return $stmt->execute();
    }
    
    public function getReviewById($reviewId) {
        $sql = "SELECT r.*, c.full_name, c.email, p.product_name 
                FROM Product_Reviews r
                LEFT JOIN Customers c ON r.customer_id = c.customer_id
                LEFT JOIN Products p ON r.product_id = p.product_id
                WHERE r.review_id = :review_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':review_id', $reviewId);
        $stmt->execute();
        return $stmt->fetch();
    }
}
?>

