<?php
namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\OrderModel;
use App\Models\ProductModel;

class AdminController extends BaseController {
    private $adminModel;
    private $orderModel;
    private $productModel;
    
    public function __construct() {
        $this->requireAdmin();
        $this->adminModel = new AdminModel();
        $this->orderModel = new OrderModel();
        $this->productModel = new ProductModel();
    }
    
    public function dashboard() {
        $stats = $this->adminModel->getStatistics();
        $recentOrders = $this->adminModel->getRecentOrders(10);
        $lowStock = $this->adminModel->getLowStockProducts(10);
        
        $this->view('admin_dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'lowStock' => $lowStock
        ]);
    }
    
    public function products() {
        if (isset($_GET['delete'])) {
            $variant_id = intval($_GET['delete']);
            $this->adminModel->deleteProduct($variant_id);
            $this->redirect('/admin/products.php');
        }
        
        $products = $this->adminModel->getAllProducts();
        
        $this->view('admin_products', [
            'products' => $products
        ]);
    }
    
    public function orders() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
            $order_id = intval($_POST['order_id']);
            $status_id = intval($_POST['status_id']);
            $this->orderModel->updateStatus($order_id, $status_id);
            $this->redirect('/admin/orders.php');
        }
        
        $orders = $this->orderModel->getAll();
        $statuses = $this->orderModel->getStatuses();
        
        $this->view('admin_orders', [
            'orders' => $orders,
            'statuses' => $statuses
        ]);
    }
    
    public function orderDetail() {
        $order_id = $_GET['id'] ?? 0;
        
        if (!$order_id) {
            $this->redirect('/admin/orders.php');
        }
        
        $order = $this->orderModel->getById($order_id);
        
        if (!$order) {
            $this->redirect('/admin/orders.php');
        }
        
        $orderDetails = $this->orderModel->getDetails($order_id);
        
        $this->view('admin_order_detail', [
            'order' => $order,
            'orderDetails' => $orderDetails
        ]);
    }
}

