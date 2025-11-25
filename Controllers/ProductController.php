<?php
namespace App\Controllers;

use App\Models\ProductModel;

class ProductController extends BaseController {
    private $productModel;
    
    public function __construct() {
        $this->productModel = new ProductModel();
    }
    
    public function index() {
        $filters = [
            'category_id' => $_GET['category'] ?? '',
            'brand' => $_GET['brand'] ?? '',
            'search' => $_GET['search'] ?? '',
            'sort' => $_GET['sort'] ?? 'newest'
        ];
        
        $products = $this->productModel->getAll($filters);
        $categories = $this->productModel->getCategories();
        $brands = $this->productModel->getBrands();
        
        $this->view('product_index', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'filters' => $filters
        ]);
    }
    
    public function detail() {
        $variant_id = $_GET['id'] ?? 0;
        
        if (!$variant_id) {
            $this->redirect('/products.php');
        }
        
        $product = $this->productModel->getById($variant_id);
        
        if (!$product) {
            $this->redirect('/products.php');
        }
        
        $otherVariants = $this->productModel->getOtherVariants($product['product_id'], $variant_id);
        
        // Get feedback
        $feedbackModel = new \App\Models\FeedbackModel();
        $feedbacks = $feedbackModel->getByVariantId($variant_id, 5);
        
        $this->view('product_detail', [
            'product' => $product,
            'otherVariants' => $otherVariants,
            'feedbacks' => $feedbacks
        ]);
    }
}

