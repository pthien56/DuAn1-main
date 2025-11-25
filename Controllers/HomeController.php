<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ProductModel as Product;

class HomeController extends BaseController {
    private $productModel;
    
    public function __construct() {
        $this->productModel = new ProductModel();
    }
    
    public function index() {
        $featuredProducts = $this->productModel->getFeatured(8);
        $categories = $this->productModel->getCategories();
        
        $this->view('home_index', [
            'featuredProducts' => $featuredProducts,
            'categories' => $categories
        ]);
    }
}

