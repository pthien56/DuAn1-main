<?php
// Các class đã được load từ index.php

class CustomerController extends BaseController {
    
    private $customerModel;
    private $orderModel;
    
    public function __construct() {
        $this->customerModel = new CustomerModel();
        $this->orderModel = new OrderModel();
        $this->requireAuth();
    }
    
    protected function requireAuth() {
        if (!isset($_SESSION['customer_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để tiếp tục';
            $this->redirect('auth/login');
            return;
        }
        
        // Kiểm tra trạng thái khách hàng
        $customer = $this->customerModel->getCustomerById($_SESSION['customer_id']);
        if ($customer) {
            $status = $customer['status'] ?? 'active';
            if ($status === 'locked') {
                session_destroy();
                $_SESSION['error'] = 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ với quản trị viên để được hỗ trợ.';
                $this->redirect('auth/login');
                return;
            }
        }
    }
    
    public function profile() {
        $customer = $this->customerModel->getCustomerById($_SESSION['customer_id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'full_name' => $_POST['full_name'] ?? '',
                'phone_number' => $_POST['phone_number'] ?? '',
                'email' => $_POST['email'] ?? '',
                'address' => $_POST['address'] ?? '',
                'gender' => $_POST['gender'] ?? '',
                'date_of_birth' => $_POST['date_of_birth'] ?? null
            ];
            
            if ($this->customerModel->updateCustomer($_SESSION['customer_id'], $data)) {
                $_SESSION['success'] = 'Cập nhật thông tin thành công';
                $_SESSION['customer_name'] = $data['full_name'];
                $this->redirect('customer/profile');
            } else {
                $_SESSION['error'] = 'Cập nhật thông tin thất bại';
            }
        }
        
        $data = [
            'customer' => $customer,
            'pageTitle' => 'Thông Tin Tài Khoản'
        ];
        
        $this->view('customer/profile', $data);
    }
    
    public function orders() {
        $orders = $this->orderModel->getOrdersByCustomer($_SESSION['customer_id']);
        
        $data = [
            'orders' => $orders,
            'pageTitle' => 'Đơn Hàng Của Tôi'
        ];
        
        $this->view('customer/orders', $data);
    }
    
    public function orderDetail($orderId) {
        $order = $this->orderModel->getOrderById($orderId);
        
        if (!$order || $order['customer_id'] != $_SESSION['customer_id']) {
            $_SESSION['error'] = 'Đơn hàng không tồn tại';
            $this->redirect('customer/orders');
        }
        
        $orderDetails = $this->orderModel->getOrderDetails($orderId);
        
        $data = [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'pageTitle' => 'Chi Tiết Đơn Hàng #' . $orderId
        ];
        
        $this->view('customer/order_detail', $data);
    }
}
?>

