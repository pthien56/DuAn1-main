<?php
// Các class đã được load từ index.php

class ReviewController extends BaseController {
    
    private $reviewModel;
    
    public function __construct() {
        $this->reviewModel = new ReviewModel();
    }
    
    public function create() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['customer_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để đánh giá sản phẩm';
            $this->redirect('auth/login');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
            $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 5;
            $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
            
            // Validation
            if ($productId <= 0) {
                $_SESSION['error'] = 'Sản phẩm không hợp lệ';
                $this->redirect('product/index');
                return;
            }
            
            if ($rating < 1 || $rating > 5) {
                $_SESSION['error'] = 'Đánh giá phải từ 1 đến 5 sao';
                $this->redirect('product/detail/' . $productId);
                return;
            }
            
            // Kiểm tra đã mua hàng chưa
            if (!$this->reviewModel->hasPurchased($productId, $_SESSION['customer_id'])) {
                $_SESSION['error'] = 'Bạn cần mua sản phẩm này trước khi đánh giá';
                $this->redirect('product/detail/' . $productId);
                return;
            }
            
            // Kiểm tra đã đánh giá chưa
            if ($this->reviewModel->hasReviewed($productId, $_SESSION['customer_id'])) {
                $_SESSION['error'] = 'Bạn đã đánh giá sản phẩm này rồi';
                $this->redirect('product/detail/' . $productId);
                return;
            }
            
            $data = [
                'product_id' => $productId,
                'customer_id' => $_SESSION['customer_id'],
                'rating' => $rating,
                'comment' => $comment
            ];
            
            if ($this->reviewModel->createReview($data)) {
                $_SESSION['success'] = 'Cảm ơn bạn đã đánh giá! Đánh giá của bạn đang chờ duyệt.';
            } else {
                $_SESSION['error'] = 'Không thể gửi đánh giá. Vui lòng thử lại.';
            }
        }
        
        $this->redirect('product/detail/' . $productId);
    }
}
?>

