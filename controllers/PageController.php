<?php
// Các class đã được load từ index.php

class PageController extends BaseController {
    
    private $contactModel;
    private $customerModel;
    
    public function __construct() {
        $this->contactModel = new ContactModel();
        $this->customerModel = new CustomerModel();
    }
    
    public function about() {
        $data = ['pageTitle' => 'Giới Thiệu'];
        $this->view('pages/about', $data);
    }
    
    public function contact() {
        // Lấy thông tin khách hàng nếu đã đăng nhập
        $customer = null;
        if (isset($_SESSION['customer_id'])) {
            $customer = $this->customerModel->getCustomerById($_SESSION['customer_id']);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate input
            $name = trim($_POST['name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $subject = trim($_POST['subject'] ?? '');
            $message = trim($_POST['message'] ?? '');
            
            $errors = [];
            
            if (empty($name)) {
                $errors[] = 'Vui lòng nhập họ và tên';
            }
            
            if (empty($phone)) {
                $errors[] = 'Vui lòng nhập số điện thoại';
            } elseif (!preg_match('/^[0-9]{10,11}$/', $phone)) {
                $errors[] = 'Số điện thoại không hợp lệ';
            }
            
            if (empty($email)) {
                $errors[] = 'Vui lòng nhập email';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ';
            }
            
            if (empty($subject)) {
                $errors[] = 'Vui lòng chọn chủ đề';
            }
            
            if (empty($message)) {
                $errors[] = 'Vui lòng nhập nội dung tin nhắn';
            }
            
            if (empty($errors)) {
                try {
                    $contactData = [
                        'name' => $name,
                        'phone' => $phone,
                        'email' => $email,
                        'subject' => $subject,
                        'message' => $message
                    ];
                    
                    if ($this->contactModel->createContact($contactData)) {
                        $_SESSION['success'] = 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.';
                    } else {
                        $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại sau.';
                    }
                } catch (Exception $e) {
                    $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại sau.';
                }
            } else {
                $_SESSION['error'] = implode('<br>', $errors);
            }
            
            $this->redirect('page/contact');
        }
        
        $data = [
            'pageTitle' => 'Liên Hệ',
            'customer' => $customer
        ];
        $this->view('pages/contact', $data);
    }
}
?>

