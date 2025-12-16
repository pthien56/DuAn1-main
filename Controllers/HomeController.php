<?php
// Các class đã được load từ index.php

class HomeController extends BaseController {
    
    private $productModel;
    
    public function __construct() {
        $this->productModel = new ProductModel();
    }
    
    public function index() {
        // Lấy filters từ query string
        $filters = [];
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        // Filter theo brand
        if (!empty($_GET['brand'])) {
            $filters['brand'] = $_GET['brand'];
        }
        
        // Filter theo category (điện thoại hoặc tablet)
        // Mặc định: category_id = 1 (Điện thoại) nếu không có category_id
        if (!empty($_GET['category_id'])) {
            $filters['category_id'] = (int)$_GET['category_id'];
        } else {
            // Mặc định hiển thị điện thoại (category_id = 1)
            $filters['category_id'] = 1;
        }
        
        // Filter chỉ sản phẩm còn hàng
        $filters['in_stock'] = true;
        
        // Lấy sản phẩm
        $allProducts = $this->productModel->getAllProducts($limit, $offset, $filters, 'newest');
        $totalProducts = $this->productModel->getProductsCount($filters);
        $totalPages = ceil($totalProducts / $limit);
        
        // Tính toán giá và discount cho mỗi sản phẩm
        foreach ($allProducts as &$product) {
            $variants = $this->productModel->getProductVariants($product['product_id']);
            if ($variants) {
                $prices = array_column($variants, 'price');
                $product['min_price'] = min($prices);
                $product['max_price'] = max($prices);
                
                // Tính discount giả định (có thể lấy từ database)
                if ($product['min_price'] > 0) {
                    $discountPercent = rand(5, 15); // Random 5-15%
                    $product['old_price'] = round($product['min_price'] / (1 - $discountPercent / 100));
                    $product['discount_percent'] = $discountPercent;
                }
            }
        }
        
        $categories = $this->productModel->getAllCategories();
        $brands = $this->productModel->getAllBrands();
        
        $data = [
            'allProducts' => $allProducts,
            'categories' => $categories,
            'brands' => $brands,
            'filters' => $filters,
            'page' => $page,
            'totalPages' => $totalPages,
            'totalProducts' => $totalProducts,
            'pageTitle' => 'Trang Chủ'
        ];
        
        $this->view('home/index', $data);
    }
}
?>

