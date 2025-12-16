<?php
// Các class đã được load từ index.php

class ProductController extends BaseController {
    
    private $productModel;
    private $reviewModel;
    
    public function __construct() {
        $this->productModel = new ProductModel();
        $this->reviewModel = new ReviewModel();
    }
    
    public function index() {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 9;
        $offset = ($page - 1) * $limit;
        
        // Get filters
        $filters = [];
        if (!empty($_GET['category_id'])) {
            $filters['category_id'] = (int)$_GET['category_id'];
        }
        if (!empty($_GET['brand'])) {
            $filters['brand'] = $_GET['brand'];
        }
        if (!empty($_GET['min_price'])) {
            $filters['min_price'] = (int)$_GET['min_price'];
        }
        if (!empty($_GET['max_price'])) {
            $filters['max_price'] = (int)$_GET['max_price'];
        }
        if (isset($_GET['in_stock']) && $_GET['in_stock'] == '1') {
            $filters['in_stock'] = true;
        }
        
        // Get sort
        $sort = $_GET['sort'] ?? 'newest';
        $allowedSorts = ['newest', 'price_asc', 'price_desc', 'name_asc', 'name_desc'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'newest';
        }
        
        // Get products
        $products = $this->productModel->getAllProducts($limit, $offset, $filters, $sort);
        $totalProducts = $this->productModel->getProductsCount($filters);
        $totalPages = ceil($totalProducts / $limit);
        
        // Get filter options
        $categories = $this->productModel->getAllCategories();
        $brands = $this->productModel->getAllBrands();
        $priceRange = $this->productModel->getPriceRange();
        
        // Process products to add min_price
        foreach ($products as &$product) {
            $variants = $this->productModel->getProductVariants($product['product_id']);
            if ($variants) {
                $prices = array_column($variants, 'price');
                $product['min_price'] = min($prices);
                $product['max_price'] = max($prices);
            } else {
                $product['min_price'] = 0;
                $product['max_price'] = 0;
            }
        }
        
        $data = [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'priceRange' => $priceRange,
            'filters' => $filters,
            'sort' => $sort,
            'page' => $page,
            'totalPages' => $totalPages,
            'totalProducts' => $totalProducts,
            'pageTitle' => 'Sản Phẩm'
        ];
        
        $this->view('products/index', $data);
    }
    
    public function detail($id) {
        $product = $this->productModel->getProductById($id);
        
        if (!$product) {
            $this->redirect('product/index');
        }
        
        $variants = $this->productModel->getProductVariants($id);
        
        // Get reviews
        $reviews = $this->reviewModel->getReviewsByProduct($id);
        $reviewStats = $this->reviewModel->getReviewStats($id);
        
        // Check if current user has reviewed and purchased
        $hasReviewed = false;
        $hasPurchased = false;
        if (isset($_SESSION['customer_id'])) {
            $hasReviewed = $this->reviewModel->hasReviewed($id, $_SESSION['customer_id']);
            $hasPurchased = $this->reviewModel->hasPurchased($id, $_SESSION['customer_id']);
        }
        
        $data = [
            'product' => $product,
            'variants' => $variants,
            'reviews' => $reviews,
            'reviewStats' => $reviewStats,
            'hasReviewed' => $hasReviewed,
            'hasPurchased' => $hasPurchased,
            'pageTitle' => $product['product_name']
        ];
        
        $this->view('products/detail', $data);
    }
    
    public function search() {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        
        if (empty($keyword)) {
            $this->redirect('product/index');
        }
        
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;
        
        // Get filters
        $filters = [];
        if (!empty($_GET['category_id'])) {
            $filters['category_id'] = (int)$_GET['category_id'];
        }
        if (!empty($_GET['brand'])) {
            $filters['brand'] = $_GET['brand'];
        }
        if (!empty($_GET['min_price'])) {
            $filters['min_price'] = (int)$_GET['min_price'];
        }
        if (!empty($_GET['max_price'])) {
            $filters['max_price'] = (int)$_GET['max_price'];
        }
        if (isset($_GET['in_stock']) && $_GET['in_stock'] == '1') {
            $filters['in_stock'] = true;
        }
        
        // Get sort
        $sort = $_GET['sort'] ?? 'newest';
        $allowedSorts = ['newest', 'price_asc', 'price_desc', 'name_asc', 'name_desc'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'newest';
        }
        
        // Get products
        $products = $this->productModel->searchProducts($keyword, $limit, $offset, $filters, $sort);
        $totalProducts = $this->productModel->searchProductsCount($keyword, $filters);
        $totalPages = ceil($totalProducts / $limit);
        
        // Get filter options
        $categories = $this->productModel->getAllCategories();
        $brands = $this->productModel->getAllBrands();
        $priceRange = $this->productModel->getPriceRange();
        
        // Process products to add min_price, max_price, discount_percent, old_price
        foreach ($products as &$product) {
            if (!isset($product['min_price']) || $product['min_price'] == 0) {
                $variants = $this->productModel->getProductVariants($product['product_id']);
                if ($variants) {
                    $prices = array_column($variants, 'price');
                    $product['min_price'] = min($prices);
                    $product['max_price'] = max($prices);
                }
            }
            
            if (!isset($product['discount_percent'])) {
                $product['discount_percent'] = rand(5, 15);
            }
            if (!isset($product['old_price']) && $product['min_price'] > 0) {
                $product['old_price'] = round($product['min_price'] / (1 - $product['discount_percent'] / 100));
            }
        }
        
        $data = [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'priceRange' => $priceRange,
            'filters' => $filters,
            'sort' => $sort,
            'keyword' => $keyword,
            'page' => $page,
            'totalPages' => $totalPages,
            'totalProducts' => $totalProducts,
            'pageTitle' => 'Tìm kiếm: ' . $keyword
        ];
        
        $this->view('products/search', $data);
    }
    
    public function category($id) {
        $products = $this->productModel->getProductsByCategory($id);
        $categories = $this->productModel->getAllCategories();
        
        $data = [
            'products' => $products,
            'categories' => $categories,
            'categoryId' => $id,
            'pageTitle' => 'Danh Mục'
        ];
        
        $this->view('products/category', $data);
    }
    
    public function filterAjax() {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 9;
        $offset = ($page - 1) * $limit;
        
        // Get filters
        $filters = [];
        if (!empty($_GET['category_id'])) {
            $filters['category_id'] = (int)$_GET['category_id'];
        }
        if (!empty($_GET['brand'])) {
            $filters['brand'] = $_GET['brand'];
        }
        if (!empty($_GET['min_price'])) {
            $filters['min_price'] = (int)$_GET['min_price'];
        }
        if (!empty($_GET['max_price'])) {
            $filters['max_price'] = (int)$_GET['max_price'];
        }
        if (isset($_GET['in_stock']) && $_GET['in_stock'] == '1') {
            $filters['in_stock'] = true;
        }
        
        // Get sort
        $sort = $_GET['sort'] ?? 'newest';
        $allowedSorts = ['newest', 'price_asc', 'price_desc', 'name_asc', 'name_desc'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'newest';
        }
        
        // Get products
        $products = $this->productModel->getAllProducts($limit, $offset, $filters, $sort);
        $totalProducts = $this->productModel->getProductsCount($filters);
        $totalPages = ceil($totalProducts / $limit);
        
        // Generate HTML for products
        ob_start();
        if (empty($products)) {
            echo '<div class="col-12">
                    <div class="alert alert-info text-center py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        <h4>Không tìm thấy sản phẩm</h4>
                        <p class="text-muted">Vui lòng thử lại với bộ lọc khác.</p>
                    </div>
                  </div>';
        } else {
            foreach ($products as $product) {
                $variants = $this->productModel->getProductVariants($product['product_id']);
                if ($variants) {
                    $prices = array_column($variants, 'price');
                    $product['min_price'] = min($prices);
                    $product['max_price'] = max($prices);
                    $product['discount_percent'] = rand(5, 20);
                    $product['old_price'] = round($product['min_price'] / (1 - $product['discount_percent'] / 100));
                }
                
                echo '<div class="col-lg-4 col-md-6 col-6">';
                include 'views/products/product_card_home.php';
                echo '</div>';
            }
        }
        $html = ob_get_clean();
        
        // Generate pagination HTML
        ob_start();
        if ($totalPages > 1) {
            echo '<nav aria-label="Page navigation" class="mt-5"><ul class="pagination justify-content-center">';
            
            if ($page > 1) {
                echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">&laquo;</a></li>';
            }
            
            $startPage = max(1, $page - 2);
            $endPage = min($totalPages, $page + 2);
            
            for ($i = $startPage; $i <= $endPage; $i++) {
                $activeClass = ($i == $page) ? 'active' : '';
                echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
            }
            
            if ($page < $totalPages) {
                echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">&raquo;</a></li>';
            }
            
            echo '</ul></nav>';
        }
        $pagination = ob_get_clean();
        
        $this->jsonResponse([
            'success' => true,
            'html' => $html,
            'count' => count($products),
            'total' => $totalProducts,
            'pagination' => $pagination,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }
}
?>

