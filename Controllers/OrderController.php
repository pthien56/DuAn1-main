<?php
namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\CartModel;
use App\Models\CustomerModel;
use App\Models\PaymentModel;
use App\Models\ProductModel;

class OrderController extends BaseController {
    private $orderModel;
    private $cartModel;
    private $customerModel;
    private $paymentModel;
    private $productModel;
    
    public function __construct() {
        $this->orderModel = new OrderModel();
        $this->cartModel = new CartModel();
        $this->customerModel = new CustomerModel();
        $this->paymentModel = new PaymentModel();
        $this->productModel = new ProductModel();
    }
    
    public function checkout() {
        // Yêu cầu đăng nhập
        $this->requireCustomer();
        
        if (empty($_SESSION['cart'])) {
            $this->redirect('cart.php');
        }
        
        $customer_id = $_SESSION['user_id'];
        $customer = $this->customerModel->getById($customer_id);
        
        if (!$customer) {
            $this->redirect('auth/login.php');
        }
        
        $cartItems = $this->cartModel->getCartItems($_SESSION['cart']);
        $total = $this->cartModel->calculateTotal($cartItems);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $payment_method = $this->sanitize($_POST['payment_method'] ?? '');
            $note = $this->sanitize($_POST['note'] ?? '');
            $shipping_address = $this->sanitize($_POST['shipping_address'] ?? $customer['address']);
            
            if (empty($cartItems)) {
                $this->view('order/checkout', [
                    'customer' => $customer,
                    'cartItems' => $cartItems,
                    'total' => $total,
                    'error' => 'Giỏ hàng trống!'
                ]);
                return;
            }
            
            // Get default employee
            $employeeModel = new \App\Models\EmployeeModel();
            $employee_id = $employeeModel->getDefaultEmployeeId();
            
            if (!$employee_id) {
                $this->view('order/checkout', [
                    'customer' => $customer,
                    'cartItems' => $cartItems,
                    'total' => $total,
                    'error' => 'Lỗi hệ thống. Vui lòng thử lại sau!'
                ]);
                return;
            }
            
            $order_status_id = $this->orderModel->getDefaultStatus();
            
            // Create order
            $order_id = $this->orderModel->create([
                'customer_id' => $customer_id,
                'employee_id' => $employee_id,
                'total_amount' => $total,
                'order_status_id' => $order_status_id,
                'payment_method' => $payment_method,
                'note' => $note
            ]);
            
            if (!$order_id) {
                $this->view('order/checkout', [
                    'customer' => $customer,
                    'cartItems' => $cartItems,
                    'total' => $total,
                    'error' => 'Không thể tạo đơn hàng. Vui lòng thử lại!'
                ]);
                return;
            }
            
            // Create order details and update stock
            $orderItems = [];
            foreach ($cartItems as $item) {
                // Kiểm tra lại stock trước khi tạo đơn
                $product = $this->productModel->getById($item['variant_id']);
                if (!$product || $product['stock_quantity'] < $item['cart_quantity']) {
                    // Xóa đơn hàng đã tạo
                    $this->orderModel->delete("DELETE FROM Orders WHERE order_id = ?", [$order_id], "i");
                    $this->view('order/checkout', [
                        'customer' => $customer,
                        'cartItems' => $cartItems,
                        'total' => $total,
                        'error' => 'Một số sản phẩm đã hết hàng. Vui lòng kiểm tra lại giỏ hàng!'
                    ]);
                    return;
                }
                
                $orderItems[] = [
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['cart_quantity'],
                    'price' => $item['price'],
                    'discount' => 0,
                    'subtotal' => $item['subtotal']
                ];
                
                $this->productModel->updateStock($item['variant_id'], $item['cart_quantity']);
            }
            
            $this->orderModel->createDetail($order_id, $orderItems);
            
            // Create payment
            $payment_status_id = ($payment_method == 'Tiền mặt' || $payment_method == 'Chuyển khoản') ? 2 : 1;
            $this->paymentModel->create([
                'order_id' => $order_id,
                'amount' => $total,
                'payment_method' => $payment_method,
                'payment_status_id' => $payment_status_id,
                'note' => $note
            ]);
            
            // Clear cart
            $_SESSION['cart'] = [];
            
            $this->view('order/checkout', [
                'customer' => $customer,
                'cartItems' => [],
                'total' => 0,
                'success' => "Đặt hàng thành công! Mã đơn hàng: #$order_id"
            ]);
            return;
        }
        
        $this->view('order/checkout', [
            'customer' => $customer,
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }
    
    public function index() {
        $this->requireCustomer();
        
        $customer_id = $_SESSION['user_id'];
        $orders = $this->orderModel->getByCustomerId($customer_id);
        
        $this->view('order/index', [
            'orders' => $orders
        ]);
    }
    
    public function detail() {
        $this->requireCustomer();
        
        $order_id = $_GET['id'] ?? 0;
        $customer_id = $_SESSION['user_id'];
        
        if (!$order_id) {
            $this->redirect('orders.php');
        }
        
        $order = $this->orderModel->getById($order_id);
        
        if (!$order || $order['customer_id'] != $customer_id) {
            $this->redirect('orders.php');
        }
        
        $orderDetails = $this->orderModel->getDetails($order_id);
        $payment = $this->paymentModel->getByOrderId($order_id);
        
        $this->view('order/detail', [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'payment' => $payment
        ]);
    }
}