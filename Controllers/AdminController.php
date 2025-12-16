<?php
// Các class đã được load từ index.php

class AdminController extends BaseController {
    
    private $adminModel;
    private $productModel;
    private $customerModel;
    private $orderModel;
    private $reviewModel;
    private $couponModel;
    private $postModel;
    
    public function __construct() {
        $this->checkAuth();
        $this->adminModel = new AdminModel();
        $this->productModel = new ProductModel();
        $this->customerModel = new CustomerModel();
        $this->orderModel = new OrderModel();
        $this->reviewModel = new ReviewModel();
        $this->couponModel = new CouponModel();
        $this->postModel = new PostModel();
    }
    
    private function checkAuth() {
        if (!isset($_SESSION['admin_id'])) {
            $this->redirect('auth/login');
        }
    }
    
    public function dashboard() {
        $stats = $this->adminModel->getDashboardStats();
        $recentOrders = $this->orderModel->getAllOrders(5);
        
        $data = [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'pageTitle' => 'Dashboard'
        ];
        
        $this->view('admin/dashboard', $data, true);
    }
    
    // Quản lý sản phẩm
    public function products() {
        $products = $this->productModel->getAllProducts();
        $categories = $this->productModel->getAllCategories();
        
        $data = [
            'products' => $products,
            'categories' => $categories,
            'pageTitle' => 'Quản Lý Sản Phẩm'
        ];
        
        $this->view('admin/products/index', $data, true);
    }
    
    public function productCreate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'product_name' => $_POST['product_name'],
                'brand' => $_POST['brand'],
                'description' => $_POST['description'],
                'category_id' => $_POST['category_id'] ?: null,
                'supplier_id' => $_POST['supplier_id'] ?: null
            ];
            
            if ($this->productModel->createProduct($data)) {
                $_SESSION['success'] = 'Tạo sản phẩm thành công';
                $this->redirect('admin/products');
            } else {
                $_SESSION['error'] = 'Không thể tạo sản phẩm';
            }
        }
        
        $categories = $this->productModel->getAllCategories();
        $data = [
            'categories' => $categories,
            'pageTitle' => 'Thêm Sản Phẩm'
        ];
        
        $this->view('admin/products/create', $data, true);
    }
    
    public function productEdit($id) {
        $product = $this->productModel->getProductById($id);
        
        if (!$product) {
            $this->redirect('admin/products');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'product_name' => $_POST['product_name'],
                'brand' => $_POST['brand'],
                'description' => $_POST['description'],
                'category_id' => $_POST['category_id'] ?: null,
                'supplier_id' => $_POST['supplier_id'] ?: null
            ];
            
            if ($this->productModel->updateProduct($id, $data)) {
                $_SESSION['success'] = 'Cập nhật sản phẩm thành công';
                $this->redirect('admin/products');
            } else {
                $_SESSION['error'] = 'Không thể cập nhật sản phẩm';
            }
        }
        
        $variants = $this->productModel->getProductVariants($id);
        $categories = $this->productModel->getAllCategories();
        
        $data = [
            'product' => $product,
            'variants' => $variants,
            'categories' => $categories,
            'pageTitle' => 'Sửa Sản Phẩm'
        ];
        
        $this->view('admin/products/edit', $data, true);
    }
    
    public function productDelete($id) {
        if ($this->productModel->deleteProduct($id)) {
            $_SESSION['success'] = 'Xóa sản phẩm thành công';
        } else {
            $_SESSION['error'] = 'Không thể xóa sản phẩm';
        }
        $this->redirect('admin/products');
    }
    
    public function productUploadImage($id) {
        $product = $this->productModel->getProductById($id);
        
        if (!$product) {
            $_SESSION['error'] = 'Sản phẩm không tồn tại';
            $this->redirect('admin/products');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['product_image'])) {
            $file = $_FILES['product_image'];
            
            // Kiểm tra lỗi upload
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['error'] = 'Lỗi khi upload file';
                $this->redirect('admin/productEdit/' . $id);
            }
            
            // Kiểm tra loại file
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);
            
            if (!in_array($mimeType, $allowedTypes)) {
                $_SESSION['error'] = 'Chỉ chấp nhận file ảnh JPG, JPEG hoặc PNG';
                $this->redirect('admin/productEdit/' . $id);
            }
            
            // Tạo thư mục nếu chưa tồn tại
            $uploadDir = __DIR__ . '/../public/data/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Tên file = tên sản phẩm + .jpg
            $fileName = $product['product_name'] . '.jpg';
            $targetPath = $uploadDir . $fileName;
            
            // Chuyển đổi PNG sang JPG nếu cần
            if ($mimeType === 'image/png') {
                $image = imagecreatefrompng($file['tmp_name']);
                imagejpeg($image, $targetPath, 90);
                imagedestroy($image);
            } else {
                // Di chuyển file
                if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $_SESSION['error'] = 'Không thể lưu file';
                    $this->redirect('admin/productEdit/' . $id);
                }
            }
            
            $_SESSION['success'] = 'Upload ảnh thành công!';
            $this->redirect('admin/productEdit/' . $id);
        }
        
        $this->redirect('admin/productEdit/' . $id);
    }
    
    public function variantCreate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'product_id' => $_POST['product_id'],
                'variant_name' => $_POST['variant_name'],
                'color' => $_POST['color'],
                'storage' => $_POST['storage'],
                'price' => $_POST['price'],
                'stock_quantity' => $_POST['stock_quantity'],
                'warranty_months' => $_POST['warranty_months']
            ];
            
            if ($this->productModel->createVariant($data)) {
                $_SESSION['success'] = 'Tạo biến thể thành công';
                $this->redirect('admin/productEdit/' . $data['product_id']);
            } else {
                $_SESSION['error'] = 'Không thể tạo biến thể';
            }
        }
        $this->redirect('admin/products');
    }
    
    public function variantEdit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'variant_name' => $_POST['variant_name'],
                'color' => $_POST['color'],
                'storage' => $_POST['storage'],
                'price' => $_POST['price'],
                'stock_quantity' => $_POST['stock_quantity'],
                'warranty_months' => $_POST['warranty_months']
            ];
            
            $variant = $this->productModel->getVariantById($id);
            
            if ($this->productModel->updateVariant($id, $data)) {
                $_SESSION['success'] = 'Cập nhật biến thể thành công';
                $this->redirect('admin/productEdit/' . $variant['product_id']);
            } else {
                $_SESSION['error'] = 'Không thể cập nhật biến thể';
            }
        }
        $this->redirect('admin/products');
    }
    
    public function variantDelete($id) {
        $variant = $this->productModel->getVariantById($id);
        if ($this->productModel->deleteVariant($id)) {
            $_SESSION['success'] = 'Xóa biến thể thành công';
            $this->redirect('admin/productEdit/' . $variant['product_id']);
        } else {
            $_SESSION['error'] = 'Không thể xóa biến thể';
        }
        $this->redirect('admin/products');
    }
    
    // Quản lý khách hàng
    public function customers() {
        $search = $_GET['search'] ?? '';
        $statusFilter = $_GET['status'] ?? '';
        
        $customers = $this->customerModel->getAllCustomers();
        
        // Filter by search
        if (!empty($search)) {
            $customers = array_filter($customers, function($customer) use ($search) {
                return stripos($customer['full_name'], $search) !== false 
                    || stripos($customer['email'], $search) !== false
                    || stripos($customer['phone_number'], $search) !== false;
            });
        }
        
        // Filter by status
        if (!empty($statusFilter)) {
            $customers = array_filter($customers, function($customer) use ($statusFilter) {
                $status = $customer['status'] ?? 'active';
                return $status === $statusFilter;
            });
        }
        
        // Reset array keys
        $customers = array_values($customers);
        
        $data = [
            'customers' => $customers,
            'search' => $search,
            'statusFilter' => $statusFilter,
            'pageTitle' => 'Quản Lý Khách Hàng'
        ];
        
        $this->view('admin/customers/index', $data, true);
    }
    
    public function customerToggleStatus($id) {
        $customer = $this->customerModel->getCustomerById($id);
        if (!$customer) {
            $_SESSION['error'] = 'Không tìm thấy khách hàng';
            $this->redirect('admin/customers');
            return;
        }
        
        if ($this->customerModel->toggleCustomerStatus($id)) {
            $newStatus = ($customer['status'] ?? 'active') == 'active' ? 'khóa' : 'mở khóa';
            $_SESSION['success'] = 'Đã ' . $newStatus . ' khách hàng ' . htmlspecialchars($customer['full_name']) . ' thành công';
        } else {
            $_SESSION['error'] = 'Không thể cập nhật trạng thái khách hàng';
        }
        
        // Preserve filters
        $queryParams = [];
        if (!empty($_GET['search'])) {
            $queryParams['search'] = $_GET['search'];
        }
        if (!empty($_GET['status'])) {
            $queryParams['status'] = $_GET['status'];
        }
        
        $redirectUrl = 'admin/customers';
        if (!empty($queryParams)) {
            $redirectUrl .= '?' . http_build_query($queryParams);
        }
        
        $this->redirect($redirectUrl);
    }
    
    // Quản lý đơn hàng
    public function orders() {
        $orders = $this->orderModel->getAllOrders();
        
        $data = [
            'orders' => $orders,
            'pageTitle' => 'Quản Lý Đơn Hàng'
        ];
        
        $this->view('admin/orders/index', $data, true);
    }
    
    public function orderDetail($id) {
        $order = $this->orderModel->getOrderById($id);
        $orderDetails = $this->orderModel->getOrderDetails($id);
        $statuses = $this->orderModel->getAllOrderStatuses();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $statusId = $_POST['status_id'];
            if ($this->orderModel->updateOrderStatus($id, $statusId)) {
                $_SESSION['success'] = 'Cập nhật trạng thái đơn hàng thành công';
                $this->redirect('admin/orderDetail/' . $id);
            }
        }
        
        $data = [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'statuses' => $statuses,
            'pageTitle' => 'Chi Tiết Đơn Hàng'
        ];
        
        $this->view('admin/orders/detail', $data, true);
    }
    
    // Quản lý danh mục
    public function categories() {
        $categories = $this->productModel->getAllCategories();
        
        $data = [
            'categories' => $categories,
            'pageTitle' => 'Quản Lý Danh Mục'
        ];
        
        $this->view('admin/categories/index', $data, true);
    }
    
    public function categoryCreate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'category_name' => $_POST['category_name'],
                'description' => $_POST['description'] ?? ''
            ];
            
            if ($this->productModel->createCategory($data)) {
                $_SESSION['success'] = 'Tạo danh mục thành công';
                $this->redirect('admin/categories');
            } else {
                $_SESSION['error'] = 'Không thể tạo danh mục';
            }
        }
        
        $data = [
            'pageTitle' => 'Thêm Danh Mục'
        ];
        
        $this->view('admin/categories/create', $data, true);
    }
    
    public function categoryEdit($id) {
        $category = $this->productModel->getCategoryById($id);
        
        if (!$category) {
            $this->redirect('admin/categories');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'category_name' => $_POST['category_name'],
                'description' => $_POST['description'] ?? ''
            ];
            
            if ($this->productModel->updateCategory($id, $data)) {
                $_SESSION['success'] = 'Cập nhật danh mục thành công';
                $this->redirect('admin/categories');
            } else {
                $_SESSION['error'] = 'Không thể cập nhật danh mục';
            }
        }
        
        $data = [
            'category' => $category,
            'pageTitle' => 'Sửa Danh Mục'
        ];
        
        $this->view('admin/categories/edit', $data, true);
    }
    
    public function categoryUploadImage($id) {
        $category = $this->productModel->getCategoryById($id);
        
        if (!$category) {
            $_SESSION['error'] = 'Danh mục không tồn tại';
            $this->redirect('admin/categories');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['category_image'])) {
            $file = $_FILES['category_image'];
            
            // Kiểm tra lỗi upload
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['error'] = 'Lỗi khi upload file';
                $this->redirect('admin/categoryEdit/' . $id);
            }
            
            // Kiểm tra loại file
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);
            
            if (!in_array($mimeType, $allowedTypes)) {
                $_SESSION['error'] = 'Chỉ chấp nhận file ảnh JPG, JPEG hoặc PNG';
                $this->redirect('admin/categoryEdit/' . $id);
            }
            
            // Tạo thư mục nếu chưa tồn tại
            $uploadDir = __DIR__ . '/../public/images/categories/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Tạo tên file từ tên danh mục (chuyển thành chữ thường, thay khoảng trắng bằng dấu gạch dưới)
            $categoryImageName = str_replace(' ', '_', strtolower($category['category_name']));
            $fileName = $categoryImageName . '.jpg';
            $targetPath = $uploadDir . $fileName;
            
            // Chuyển đổi PNG sang JPG nếu cần
            if ($mimeType === 'image/png' && function_exists('imagecreatefrompng')) {
                $image = imagecreatefrompng($file['tmp_name']);
                imagejpeg($image, $targetPath, 90);
                imagedestroy($image);
            } else {
                // Di chuyển file
                if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $_SESSION['error'] = 'Không thể lưu file ảnh';
                    $this->redirect('admin/categoryEdit/' . $id);
                }
            }
            
            $_SESSION['success'] = 'Upload ảnh danh mục thành công';
            $this->redirect('admin/categoryEdit/' . $id);
        }
        
        $this->redirect('admin/categories');
    }
    
    public function categoryDelete($id) {
        if ($this->productModel->deleteCategory($id)) {
            $_SESSION['success'] = 'Xóa danh mục thành công';
        } else {
            $_SESSION['error'] = 'Không thể xóa danh mục (có thể đang được sử dụng bởi sản phẩm)';
        }
        $this->redirect('admin/categories');
    }
    
    // Quản lý đánh giá
    public function reviews() {
        $statusFilter = $_GET['status'] ?? '';
        $reviews = $this->reviewModel->getAllReviews();
        
        // Filter by status
        if (!empty($statusFilter)) {
            $reviews = array_filter($reviews, function($review) use ($statusFilter) {
                $status = $review['status'] ?? 'pending';
                return $status === $statusFilter;
            });
            $reviews = array_values($reviews);
        }
        
        $data = [
            'reviews' => $reviews,
            'statusFilter' => $statusFilter,
            'pageTitle' => 'Quản Lý Đánh Giá'
        ];
        
        $this->view('admin/reviews/index', $data, true);
    }
    
    public function reviewApprove($id) {
        if ($this->reviewModel->updateReviewStatus($id, 'approved')) {
            $_SESSION['success'] = 'Đã duyệt đánh giá';
        } else {
            $_SESSION['error'] = 'Không thể duyệt đánh giá';
        }
        $this->redirect('admin/reviews');
    }
    
    public function reviewReject($id) {
        if ($this->reviewModel->updateReviewStatus($id, 'rejected')) {
            $_SESSION['success'] = 'Đã từ chối đánh giá';
        } else {
            $_SESSION['error'] = 'Không thể từ chối đánh giá';
        }
        $this->redirect('admin/reviews');
    }
    
    public function reviewDelete($id) {
        if ($this->reviewModel->deleteReview($id)) {
            $_SESSION['success'] = 'Đã xóa đánh giá';
        } else {
            $_SESSION['error'] = 'Không thể xóa đánh giá';
        }
        $this->redirect('admin/reviews');
    }
    
    // Quản lý mã giảm giá
    public function coupons() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        
        $coupons = $this->couponModel->getAllCoupons($page, $limit);
        $totalCoupons = $this->couponModel->countCoupons();
        $totalPages = ceil($totalCoupons / $limit);
        
        $data = [
            'coupons' => $coupons,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'pageTitle' => 'Quản Lý Mã Giảm Giá'
        ];
        
        $this->view('admin/coupons/index', $data, true);
    }
    
    public function couponCreate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'code' => strtoupper(trim($_POST['code'])),
                'description' => $_POST['description'] ?? '',
                'discount_type' => $_POST['discount_type'],
                'discount_value' => (float)$_POST['discount_value'],
                'min_order_amount' => !empty($_POST['min_order_amount']) ? (float)$_POST['min_order_amount'] : 0,
                'max_discount_amount' => !empty($_POST['max_discount_amount']) ? (float)$_POST['max_discount_amount'] : null,
                'usage_limit' => !empty($_POST['usage_limit']) ? (int)$_POST['usage_limit'] : null,
                'start_date' => !empty($_POST['start_date']) ? $_POST['start_date'] : null,
                'end_date' => !empty($_POST['end_date']) ? $_POST['end_date'] : null,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];
            
            // Validate
            if (empty($data['code'])) {
                $_SESSION['error'] = 'Vui lòng nhập mã giảm giá';
                $this->redirect('admin/couponCreate');
                return;
            }
            
            if ($data['discount_value'] <= 0) {
                $_SESSION['error'] = 'Giá trị giảm giá phải lớn hơn 0';
                $this->redirect('admin/couponCreate');
                return;
            }
            
            // Check duplicate code
            $existing = $this->couponModel->getCouponByCode($data['code']);
            if ($existing) {
                $_SESSION['error'] = 'Mã giảm giá đã tồn tại';
                $this->redirect('admin/couponCreate');
                return;
            }
            
            if ($this->couponModel->createCoupon($data)) {
                $_SESSION['success'] = 'Tạo mã giảm giá thành công';
                $this->redirect('admin/coupons');
            } else {
                $_SESSION['error'] = 'Không thể tạo mã giảm giá';
            }
        }
        
        $data = [
            'pageTitle' => 'Thêm Mã Giảm Giá'
        ];
        
        $this->view('admin/coupons/create', $data, true);
    }
    
    public function couponEdit($id) {
        $coupon = $this->couponModel->getCouponById($id);
        
        if (!$coupon) {
            $_SESSION['error'] = 'Mã giảm giá không tồn tại';
            $this->redirect('admin/coupons');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'code' => strtoupper(trim($_POST['code'])),
                'description' => $_POST['description'] ?? '',
                'discount_type' => $_POST['discount_type'],
                'discount_value' => (float)$_POST['discount_value'],
                'min_order_amount' => !empty($_POST['min_order_amount']) ? (float)$_POST['min_order_amount'] : 0,
                'max_discount_amount' => !empty($_POST['max_discount_amount']) ? (float)$_POST['max_discount_amount'] : null,
                'usage_limit' => !empty($_POST['usage_limit']) ? (int)$_POST['usage_limit'] : null,
                'start_date' => !empty($_POST['start_date']) ? $_POST['start_date'] : null,
                'end_date' => !empty($_POST['end_date']) ? $_POST['end_date'] : null,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];
            
            // Check duplicate code (exclude current)
            $existing = $this->couponModel->getCouponByCode($data['code']);
            if ($existing && $existing['coupon_id'] != $id) {
                $_SESSION['error'] = 'Mã giảm giá đã tồn tại';
                $this->redirect('admin/couponEdit/' . $id);
                return;
            }
            
            if ($this->couponModel->updateCoupon($id, $data)) {
                $_SESSION['success'] = 'Cập nhật mã giảm giá thành công';
                $this->redirect('admin/coupons');
            } else {
                $_SESSION['error'] = 'Không thể cập nhật mã giảm giá';
            }
        }
        
        $data = [
            'coupon' => $coupon,
            'pageTitle' => 'Sửa Mã Giảm Giá'
        ];
        
        $this->view('admin/coupons/edit', $data, true);
    }
    
    public function couponDelete($id) {
        if ($this->couponModel->deleteCoupon($id)) {
            $_SESSION['success'] = 'Xóa mã giảm giá thành công';
        } else {
            $_SESSION['error'] = 'Không thể xóa mã giảm giá';
        }
        $this->redirect('admin/coupons');
    }
    
    public function couponToggle($id) {
        if ($this->couponModel->toggleCouponStatus($id)) {
            $_SESSION['success'] = 'Cập nhật trạng thái thành công';
        } else {
            $_SESSION['error'] = 'Không thể cập nhật trạng thái';
        }
        $this->redirect('admin/coupons');
    }
    
    // ========== QUẢN LÝ BÀI VIẾT ==========
    
    public function posts() {
        $statusFilter = $_GET['status'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $posts = $this->postModel->getAllPosts($statusFilter ?: null, $limit, $offset);
        $totalPosts = $this->postModel->countPosts($statusFilter ?: null);
        $totalPages = ceil($totalPosts / $limit);
        $categories = $this->postModel->getAllCategories();
        
        $data = [
            'posts' => $posts,
            'categories' => $categories,
            'statusFilter' => $statusFilter,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'pageTitle' => 'Quản Lý Bài Viết'
        ];
        
        $this->view('admin/posts/index', $data, true);
    }
    
    public function postCreate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $slug = !empty($_POST['slug']) ? trim($_POST['slug']) : $this->postModel->generateSlug($title);
            
            // Xử lý upload thumbnail
            $thumbnail = null;
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
                $thumbnail = $this->uploadPostThumbnail($_FILES['thumbnail'], $slug);
            }
            
            $data = [
                'title' => $title,
                'slug' => $slug,
                'excerpt' => trim($_POST['excerpt'] ?? ''),
                'content' => $_POST['content'] ?? '',
                'thumbnail' => $thumbnail,
                'category_id' => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
                'author_id' => $_SESSION['admin_id'],
                'status' => $_POST['status'] ?? 'draft',
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                'published_at' => $_POST['status'] === 'published' ? date('Y-m-d H:i:s') : null
            ];
            
            if (empty($data['title'])) {
                $_SESSION['error'] = 'Vui lòng nhập tiêu đề bài viết';
                $this->redirect('admin/postCreate');
                return;
            }
            
            if ($this->postModel->slugExists($data['slug'])) {
                $data['slug'] = $this->postModel->generateSlug($data['title']);
            }
            
            if ($this->postModel->createPost($data)) {
                $_SESSION['success'] = 'Tạo bài viết thành công';
                $this->redirect('admin/posts');
            } else {
                $_SESSION['error'] = 'Không thể tạo bài viết';
            }
        }
        
        $categories = $this->postModel->getAllCategories();
        $data = [
            'categories' => $categories,
            'pageTitle' => 'Thêm Bài Viết'
        ];
        
        $this->view('admin/posts/create', $data, true);
    }
    
    public function postEdit($id) {
        $post = $this->postModel->getPostById($id);
        
        if (!$post) {
            $_SESSION['error'] = 'Bài viết không tồn tại';
            $this->redirect('admin/posts');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $slug = !empty($_POST['slug']) ? trim($_POST['slug']) : $this->postModel->generateSlug($title);
            
            // Xử lý upload thumbnail mới
            $thumbnail = $post['thumbnail'];
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
                $thumbnail = $this->uploadPostThumbnail($_FILES['thumbnail'], $slug);
            }
            
            $data = [
                'title' => $title,
                'slug' => $slug,
                'excerpt' => trim($_POST['excerpt'] ?? ''),
                'content' => $_POST['content'] ?? '',
                'thumbnail' => $thumbnail,
                'category_id' => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
                'status' => $_POST['status'] ?? 'draft',
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                'published_at' => $_POST['status'] === 'published' && !$post['published_at'] ? date('Y-m-d H:i:s') : $post['published_at']
            ];
            
            if ($this->postModel->slugExists($data['slug'], $id)) {
                $_SESSION['error'] = 'Slug đã tồn tại';
                $this->redirect('admin/postEdit/' . $id);
                return;
            }
            
            if ($this->postModel->updatePost($id, $data)) {
                $_SESSION['success'] = 'Cập nhật bài viết thành công';
                $this->redirect('admin/posts');
            } else {
                $_SESSION['error'] = 'Không thể cập nhật bài viết';
            }
        }
        
        $categories = $this->postModel->getAllCategories();
        $data = [
            'post' => $post,
            'categories' => $categories,
            'pageTitle' => 'Sửa Bài Viết'
        ];
        
        $this->view('admin/posts/edit', $data, true);
    }
    
    public function postDelete($id) {
        if ($this->postModel->deletePost($id)) {
            $_SESSION['success'] = 'Xóa bài viết thành công';
        } else {
            $_SESSION['error'] = 'Không thể xóa bài viết';
        }
        $this->redirect('admin/posts');
    }
    
    private function uploadPostThumbnail($file, $slug) {
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mimeType, $allowedTypes)) {
            return null;
        }
        
        $uploadDir = __DIR__ . '/../public/images/posts/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = $slug . '-' . time() . '.' . $extension;
        $targetPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return 'public/images/posts/' . $fileName;
        }
        
        return null;
    }
    
    // ========== DANH MỤC BÀI VIẾT ==========
    
    public function postCategories() {
        $categories = $this->postModel->getAllCategories();
        
        $data = [
            'categories' => $categories,
            'pageTitle' => 'Danh Mục Bài Viết'
        ];
        
        $this->view('admin/posts/categories', $data, true);
    }
    
    public function postCategoryCreate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $slug = !empty($_POST['slug']) ? trim($_POST['slug']) : $this->postModel->generateSlug($name);
            
            $data = [
                'name' => $name,
                'slug' => $slug,
                'description' => trim($_POST['description'] ?? '')
            ];
            
            if ($this->postModel->createCategory($data)) {
                $_SESSION['success'] = 'Tạo danh mục thành công';
            } else {
                $_SESSION['error'] = 'Không thể tạo danh mục';
            }
        }
        $this->redirect('admin/postCategories');
    }
    
    public function postCategoryEdit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $slug = !empty($_POST['slug']) ? trim($_POST['slug']) : $this->postModel->generateSlug($name);
            
            $data = [
                'name' => $name,
                'slug' => $slug,
                'description' => trim($_POST['description'] ?? '')
            ];
            
            if ($this->postModel->updateCategory($id, $data)) {
                $_SESSION['success'] = 'Cập nhật danh mục thành công';
            } else {
                $_SESSION['error'] = 'Không thể cập nhật danh mục';
            }
        }
        $this->redirect('admin/postCategories');
    }
    
    public function postCategoryDelete($id) {
        if ($this->postModel->deleteCategory($id)) {
            $_SESSION['success'] = 'Xóa danh mục thành công';
        } else {
            $_SESSION['error'] = 'Không thể xóa danh mục';
        }
        $this->redirect('admin/postCategories');
    }
}
?>

