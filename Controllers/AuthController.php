<?php
namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\CustomerModel;
use Exception;

class AuthController extends BaseController {
    private $authModel;
    private $customerModel;
    
    public function __construct() {
        $this->authModel = new AuthModel();
        $this->customerModel = new CustomerModel();
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($this->sanitize($_POST['username'] ?? ''));
            $password = $_POST['password'] ?? '';
            
            // Validation
            if (empty($username)) {
                $this->view('auth/login', ['error' => 'Vui lòng nhập tên đăng nhập, email hoặc số điện thoại!']);
                return;
            }
            
            if (empty($password)) {
                $this->view('auth/login', ['error' => 'Vui lòng nhập mật khẩu!']);
                return;
            }
            
            // Thử đăng nhập với tư cách admin trước
            $manager = $this->authModel->loginManager($username, $password);
            
            if ($manager) {
                $_SESSION['user_id'] = $manager['manager_id'];
                $_SESSION['username'] = $manager['username'];
                $_SESSION['full_name'] = $manager['full_name'];
                $_SESSION['user_role'] = $manager['role'];
                $_SESSION['user_type'] = 'admin';
                
                $this->redirect('/admin/dashboard.php');
                return;
            }
            
            // Nếu không phải admin, thử đăng nhập với tư cách khách hàng
            // Lưu ý: Customer không có password trong database, chỉ cần email/phone
            $customer = $this->authModel->loginCustomer($username);
            
            if ($customer) {
                // Customer không cần password, nhưng vẫn yêu cầu nhập để tránh nhầm lẫn
                // Có thể bỏ qua password check hoặc yêu cầu nhập bất kỳ gì
                $_SESSION['user_id'] = $customer['customer_id'];
                $_SESSION['username'] = $customer['phone_number'];
                $_SESSION['full_name'] = $customer['full_name'];
                $_SESSION['user_role'] = 'customer';
                $_SESSION['user_type'] = 'customer';
                
                $this->redirect('/index.php');
                return;
            }
            
            // Nếu cả hai đều thất bại
            $this->view('auth/login', ['error' => 'Thông tin đăng nhập không chính xác! Vui lòng kiểm tra lại.']);
        } else {
            $this->view('auth/login');
        }
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'full_name' => trim($this->sanitize($_POST['full_name'] ?? '')),
                'phone_number' => trim($this->sanitize($_POST['phone_number'] ?? '')),
                'email' => trim($this->sanitize($_POST['email'] ?? '')),
                'address' => trim($this->sanitize($_POST['address'] ?? '')),
                'gender' => $this->sanitize($_POST['gender'] ?? ''),
                'date_of_birth' => !empty($_POST['date_of_birth']) ? $_POST['date_of_birth'] : null
            ];
            
            // Validation
            $errors = [];
            
            if (empty($data['full_name'])) {
                $errors[] = 'Vui lòng nhập họ và tên!';
            } elseif (strlen($data['full_name']) < 2) {
                $errors[] = 'Họ và tên phải có ít nhất 2 ký tự!';
            }
            
            if (empty($data['phone_number'])) {
                $errors[] = 'Vui lòng nhập số điện thoại!';
            } elseif (!preg_match('/^[0-9]{10,11}$/', $data['phone_number'])) {
                $errors[] = 'Số điện thoại không hợp lệ! Vui lòng nhập 10-11 chữ số.';
            }
            
            if (empty($data['email'])) {
                $errors[] = 'Vui lòng nhập email!';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ!';
            }
            
            if (!empty($errors)) {
                $this->view('auth/register', ['error' => implode('<br>', $errors)]);
                return;
            }
            
            // Kiểm tra trùng lặp
            if ($this->customerModel->exists($data['phone_number'], $data['email'])) {
                $this->view('auth/register', ['error' => 'Số điện thoại hoặc email đã được sử dụng! Vui lòng sử dụng thông tin khác.']);
                return;
            }
            
            // Tạo tài khoản
            try {
                $this->customerModel->create($data);
                $this->view('auth/register', ['success' => 'Đăng ký thành công! Bạn có thể đăng nhập ngay bằng email hoặc số điện thoại.']);
            } catch (Exception $e) {
                $this->view('auth/register', ['error' => 'Có lỗi xảy ra khi đăng ký. Vui lòng thử lại sau!']);
            }
        } else {
            $this->view('auth/register');
        }
    }
    
    public function logout() {
        // Xóa tất cả session variables
        $_SESSION = array();
        
        // Xóa session cookie nếu có
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Hủy session
        session_destroy();
        
        $this->redirect('/index.php');
    }
}

