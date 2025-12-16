<?php
class CouponModel extends BaseModel {
    
    /**
     * Lấy mã giảm giá theo code
     */
    public function getCouponByCode($code) {
        $sql = "SELECT * FROM coupons WHERE code = :code";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Lấy mã giảm giá theo ID
     */
    public function getCouponById($id) {
        $sql = "SELECT * FROM coupons WHERE coupon_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Kiểm tra mã giảm giá có hợp lệ không
     */
    public function validateCoupon($code, $orderTotal, $customerId = null) {
        $coupon = $this->getCouponByCode($code);
        
        if (!$coupon) {
            return ['valid' => false, 'message' => 'Mã giảm giá không tồn tại'];
        }
        
        // Kiểm tra trạng thái active
        if (!$coupon['is_active']) {
            return ['valid' => false, 'message' => 'Mã giảm giá đã bị vô hiệu hóa'];
        }
        
        // Kiểm tra ngày bắt đầu
        if ($coupon['start_date'] && strtotime($coupon['start_date']) > time()) {
            return ['valid' => false, 'message' => 'Mã giảm giá chưa có hiệu lực'];
        }
        
        // Kiểm tra ngày hết hạn
        if ($coupon['end_date'] && strtotime($coupon['end_date']) < time()) {
            return ['valid' => false, 'message' => 'Mã giảm giá đã hết hạn'];
        }
        
        // Kiểm tra giới hạn sử dụng
        if ($coupon['usage_limit'] !== null && $coupon['used_count'] >= $coupon['usage_limit']) {
            return ['valid' => false, 'message' => 'Mã giảm giá đã hết lượt sử dụng'];
        }
        
        // Kiểm tra giá trị đơn hàng tối thiểu
        if ($coupon['min_order_amount'] > 0 && $orderTotal < $coupon['min_order_amount']) {
            return [
                'valid' => false, 
                'message' => 'Đơn hàng tối thiểu ' . number_format($coupon['min_order_amount'], 0, ',', '.') . '₫ để sử dụng mã này'
            ];
        }
        
        // Kiểm tra khách hàng đã sử dụng mã này chưa (nếu có customer_id)
        if ($customerId) {
            $used = $this->checkCustomerUsedCoupon($coupon['coupon_id'], $customerId);
            if ($used) {
                return ['valid' => false, 'message' => 'Bạn đã sử dụng mã giảm giá này rồi'];
            }
        }
        
        // Tính số tiền giảm
        $discountAmount = $this->calculateDiscount($coupon, $orderTotal);
        
        return [
            'valid' => true,
            'coupon' => $coupon,
            'discount_amount' => $discountAmount,
            'message' => 'Áp dụng mã giảm giá thành công'
        ];
    }
    
    /**
     * Tính số tiền giảm giá
     */
    public function calculateDiscount($coupon, $orderTotal) {
        $discount = 0;
        
        if ($coupon['discount_type'] === 'percentage') {
            $discount = $orderTotal * ($coupon['discount_value'] / 100);
            
            // Áp dụng giới hạn giảm tối đa
            if ($coupon['max_discount_amount'] !== null && $discount > $coupon['max_discount_amount']) {
                $discount = $coupon['max_discount_amount'];
            }
        } else {
            // Fixed amount
            $discount = $coupon['discount_value'];
        }
        
        // Không giảm quá tổng đơn hàng
        if ($discount > $orderTotal) {
            $discount = $orderTotal;
        }
        
        return $discount;
    }
    
    /**
     * Kiểm tra khách hàng đã sử dụng mã chưa
     */
    public function checkCustomerUsedCoupon($couponId, $customerId) {
        $sql = "SELECT COUNT(*) as count FROM coupon_usage 
                WHERE coupon_id = :coupon_id AND customer_id = :customer_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':coupon_id', $couponId);
        $stmt->bindParam(':customer_id', $customerId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
    
    /**
     * Ghi nhận sử dụng mã giảm giá
     */
    public function recordCouponUsage($couponId, $customerId, $orderId, $discountAmount) {
        try {
            $this->conn->beginTransaction();
            
            // Thêm vào bảng coupon_usage
            $sql = "INSERT INTO coupon_usage (coupon_id, customer_id, order_id, discount_amount) 
                    VALUES (:coupon_id, :customer_id, :order_id, :discount_amount)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':coupon_id', $couponId);
            $stmt->bindParam(':customer_id', $customerId);
            $stmt->bindParam(':order_id', $orderId);
            $stmt->bindParam(':discount_amount', $discountAmount);
            $stmt->execute();
            
            // Tăng số lần sử dụng
            $sql = "UPDATE coupons SET used_count = used_count + 1 WHERE coupon_id = :coupon_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':coupon_id', $couponId);
            $stmt->execute();
            
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
    
    /**
     * Lấy tất cả mã giảm giá (cho admin)
     */
    public function getAllCoupons($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM coupons ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Đếm tổng số mã giảm giá
     */
    public function countCoupons() {
        $sql = "SELECT COUNT(*) as total FROM coupons";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
    /**
     * Tạo mã giảm giá mới
     */
    public function createCoupon($data) {
        $sql = "INSERT INTO coupons (code, description, discount_type, discount_value, 
                min_order_amount, max_discount_amount, usage_limit, start_date, end_date, is_active) 
                VALUES (:code, :description, :discount_type, :discount_value, 
                :min_order_amount, :max_discount_amount, :usage_limit, :start_date, :end_date, :is_active)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':code', $data['code']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':discount_type', $data['discount_type']);
        $stmt->bindParam(':discount_value', $data['discount_value']);
        $stmt->bindParam(':min_order_amount', $data['min_order_amount']);
        $stmt->bindParam(':max_discount_amount', $data['max_discount_amount']);
        $stmt->bindParam(':usage_limit', $data['usage_limit']);
        $stmt->bindParam(':start_date', $data['start_date']);
        $stmt->bindParam(':end_date', $data['end_date']);
        $stmt->bindParam(':is_active', $data['is_active']);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }
    
    /**
     * Cập nhật mã giảm giá
     */
    public function updateCoupon($id, $data) {
        $sql = "UPDATE coupons SET 
                code = :code, 
                description = :description, 
                discount_type = :discount_type, 
                discount_value = :discount_value,
                min_order_amount = :min_order_amount, 
                max_discount_amount = :max_discount_amount, 
                usage_limit = :usage_limit, 
                start_date = :start_date, 
                end_date = :end_date, 
                is_active = :is_active 
                WHERE coupon_id = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':code', $data['code']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':discount_type', $data['discount_type']);
        $stmt->bindParam(':discount_value', $data['discount_value']);
        $stmt->bindParam(':min_order_amount', $data['min_order_amount']);
        $stmt->bindParam(':max_discount_amount', $data['max_discount_amount']);
        $stmt->bindParam(':usage_limit', $data['usage_limit']);
        $stmt->bindParam(':start_date', $data['start_date']);
        $stmt->bindParam(':end_date', $data['end_date']);
        $stmt->bindParam(':is_active', $data['is_active']);
        
        return $stmt->execute();
    }
    
    /**
     * Xóa mã giảm giá
     */
    public function deleteCoupon($id) {
        $sql = "DELETE FROM coupons WHERE coupon_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    /**
     * Bật/tắt mã giảm giá
     */
    public function toggleCouponStatus($id) {
        $sql = "UPDATE coupons SET is_active = NOT is_active WHERE coupon_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
