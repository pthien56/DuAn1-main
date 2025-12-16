<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

require_once __DIR__ . '/models/BaseModel.php';
require_once __DIR__ . '/models/AdminModel.php';
require_once __DIR__ . '/models/ProductModel.php';
require_once __DIR__ . '/models/OrderModel.php';
require_once __DIR__ . '/models/CartModel.php';
require_once __DIR__ . '/models/CustomerModel.php';
require_once __DIR__ . '/models/ContactModel.php';
require_once __DIR__ . '/models/ReviewModel.php';
require_once __DIR__ . '/models/CouponModel.php';
require_once __DIR__ . '/models/PostModel.php';

require_once __DIR__ . '/controllers/BaseController.php';
require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/CartController.php';
require_once __DIR__ . '/controllers/CustomerController.php';
require_once __DIR__ . '/controllers/PageController.php';
require_once __DIR__ . '/controllers/ReviewController.php';

$database = new Database();
$conn = $database->getConnection();

if (!$conn) {
    http_response_code(500);
    echo 'Không thể kết nối cơ sở dữ liệu.';
    exit;
}

// Global check for locked account
if (isset($_SESSION['user_id'])) {
    try {
        $checkLockSql = "SELECT is_locked FROM customers WHERE id = ?";
        $checkLockStmt = $conn->prepare($checkLockSql);
        $checkLockStmt->execute([$_SESSION['user_id']]);
        $checkLockUser = $checkLockStmt->fetch();
        
        if ($checkLockUser && $checkLockUser['is_locked'] == 1) {
            session_unset();
            session_destroy();
            
            // Start a new session to pass the error message
            session_start();
            $_SESSION['flash_error'] = "Tài khoản của bạn đã bị khóa do vi phạm cộng đồng";
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    } catch (PDOException $e) {
        // Silently handle if column doesn't exist
    }
}

// Hỗ trợ cả 2 kiểu URL:
// 1. Query string: ?controller=home&action=index
// 2. URL rewrite: home/index (qua $_GET['url'])
if (isset($_GET['url'])) {
    $url = rtrim($_GET['url'], '/');
    $urlParts = explode('/', $url);
    $controllerName = !empty($urlParts[0]) ? strtolower($urlParts[0]) : 'home';
    $action = !empty($urlParts[1]) ? $urlParts[1] : 'index';
    $params = array_slice($urlParts, 2);
} else {
    $controllerName = $_GET['controller'] ?? 'home';
    $action = $_GET['action'] ?? 'index';
    $params = [];
    if (isset($_GET['id'])) {
        $params[] = $_GET['id'];
    }
}
$controller = null;

switch ($controllerName) {
    case 'auth':
        $controller = new AuthController();
        break;
        
    case 'admin':
        $controller = new AdminController();
        break;

    case 'product':
        $controller = new ProductController();
        break;

    case 'cart':
        $controller = new CartController();
        break;

    case 'customer':
        $controller = new CustomerController();
        break;

    case 'review':
        $controller = new ReviewController();
        break;

    case 'page':
        $controller = new PageController();
        break;

    case 'home':
    default:
        $controller = new HomeController();
        break;
}

if (!method_exists($controller, $action)) {
    http_response_code(404);
    echo 'Không tìm thấy trang hoặc hành động (' . htmlspecialchars($controllerName . '/' . $action) . ').';
    exit;
}

// Gọi action với params nếu có
if (!empty($params)) {
    call_user_func_array([$controller, $action], $params);
} else {
    $controller->{$action}();
}
?>
