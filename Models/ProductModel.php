<?php
// BaseModel đã được load từ index.php

class ProductModel extends BaseModel {
    
    public function getAllProducts($limit = null, $offset = 0, $filters = [], $sort = 'newest') {
        try {
            $sql = "SELECT DISTINCT p.*, c.category_name, s.supplier_name,
                           (SELECT MIN(price) FROM Product_Variants WHERE product_id = p.product_id AND stock_quantity > 0) as min_price,
                           (SELECT MAX(price) FROM Product_Variants WHERE product_id = p.product_id AND stock_quantity > 0) as max_price
                    FROM Products p 
                    LEFT JOIN Categories c ON p.category_id = c.category_id 
                    LEFT JOIN Suppliers s ON p.supplier_id = s.supplier_id
                    LEFT JOIN Product_Variants pv ON p.product_id = pv.product_id
                    WHERE 1=1";
        
        $params = [];
        
        // Filter by category
        if (!empty($filters['category_id'])) {
            $sql .= " AND p.category_id = :category_id";
            $params[':category_id'] = $filters['category_id'];
        }
        
        // Filter by brand
        if (!empty($filters['brand'])) {
            $sql .= " AND p.brand = :brand";
            $params[':brand'] = $filters['brand'];
        }
        
        // Filter by price range
        if (!empty($filters['min_price'])) {
            $sql .= " AND (SELECT MIN(price) FROM Product_Variants WHERE product_id = p.product_id AND stock_quantity > 0) >= :min_price";
            $params[':min_price'] = $filters['min_price'];
        }
        if (!empty($filters['max_price'])) {
            $sql .= " AND (SELECT MIN(price) FROM Product_Variants WHERE product_id = p.product_id AND stock_quantity > 0) <= :max_price";
            $params[':max_price'] = $filters['max_price'];
        }
        
        // Filter by in stock only
        if (isset($filters['in_stock']) && $filters['in_stock']) {
            $sql .= " AND EXISTS (SELECT 1 FROM Product_Variants WHERE product_id = p.product_id AND stock_quantity > 0)";
        }
        
        // Group by product
        $sql .= " GROUP BY p.product_id";
        
        // Sort
        switch ($sort) {
            case 'price_asc':
                $sql .= " ORDER BY min_price ASC";
                break;
            case 'price_desc':
                $sql .= " ORDER BY min_price DESC";
                break;
            case 'name_asc':
                $sql .= " ORDER BY p.product_name ASC";
                break;
            case 'name_desc':
                $sql .= " ORDER BY p.product_name DESC";
                break;
            case 'newest':
            default:
                $sql .= " ORDER BY p.created_at DESC";
                break;
        }
        
        if ($limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }
        
        $stmt = $this->conn->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        if ($limit) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("ProductModel::getAllProducts Error: " . $e->getMessage());
            return [];
        }
    }
    
    public function getProductsCount($filters = []) {
        $sql = "SELECT COUNT(DISTINCT p.product_id) as total
                FROM Products p 
                LEFT JOIN Categories c ON p.category_id = c.category_id 
                LEFT JOIN Product_Variants pv ON p.product_id = pv.product_id
                WHERE 1=1";
        
        $params = [];
        
        if (!empty($filters['category_id'])) {
            $sql .= " AND p.category_id = :category_id";
            $params[':category_id'] = $filters['category_id'];
        }
        
        if (!empty($filters['brand'])) {
            $sql .= " AND p.brand = :brand";
            $params[':brand'] = $filters['brand'];
        }
        
        if (!empty($filters['min_price'])) {
            $sql .= " AND (SELECT MIN(price) FROM Product_Variants WHERE product_id = p.product_id AND stock_quantity > 0) >= :min_price";
            $params[':min_price'] = $filters['min_price'];
        }
        if (!empty($filters['max_price'])) {
            $sql .= " AND (SELECT MIN(price) FROM Product_Variants WHERE product_id = p.product_id AND stock_quantity > 0) <= :max_price";
            $params[':max_price'] = $filters['max_price'];
        }
        
        if (isset($filters['in_stock']) && $filters['in_stock']) {
            $sql .= " AND EXISTS (SELECT 1 FROM Product_Variants WHERE product_id = p.product_id AND stock_quantity > 0)";
        }
        
        $stmt = $this->conn->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
    
    public function getAllBrands() {
        $sql = "SELECT DISTINCT brand FROM Products WHERE brand IS NOT NULL AND brand != '' ORDER BY brand";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function getPriceRange() {
        $sql = "SELECT 
                    MIN(price) as min_price,
                    MAX(price) as max_price
                FROM Product_Variants 
                WHERE stock_quantity > 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function getProductById($id) {
        $sql = "SELECT p.*, c.category_name, s.supplier_name 
                FROM Products p 
                LEFT JOIN Categories c ON p.category_id = c.category_id 
                LEFT JOIN Suppliers s ON p.supplier_id = s.supplier_id 
                WHERE p.product_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function getProductVariants($productId) {
        $sql = "SELECT * FROM Product_Variants WHERE product_id = :product_id AND stock_quantity > 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getVariantById($variantId) {
        $sql = "SELECT pv.*, p.product_name, p.brand, p.description 
                FROM Product_Variants pv 
                JOIN Products p ON pv.product_id = p.product_id 
                WHERE pv.variant_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $variantId);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function searchProducts($keyword, $limit = null, $offset = 0, $filters = [], $sort = 'newest') {
        $sql = "SELECT DISTINCT p.*, c.category_name, s.supplier_name,
                       (SELECT MIN(price) FROM Product_Variants WHERE product_id = p.product_id AND stock_quantity > 0) as min_price,
                       (SELECT MAX(price) FROM Product_Variants WHERE product_id = p.product_id AND stock_quantity > 0) as max_price
                FROM Products p 
                LEFT JOIN Categories c ON p.category_id = c.category_id 
                LEFT JOIN Suppliers s ON p.supplier_id = s.supplier_id
                LEFT JOIN Product_Variants pv ON p.product_id = pv.product_id
                WHERE (p.product_name LIKE :keyword 
                   OR p.brand LIKE :keyword 
                   OR p.description LIKE :keyword)";
        
        $params = [':keyword' => "%$keyword%"];
        
        // Filter by category
        if (!empty($filters['category_id'])) {
            $sql .= " AND p.category_id = :category_id";
            $params[':category_id'] = $filters['category_id'];
        }
        
        // Filter by brand
        if (!empty($filters['brand'])) {
            $sql .= " AND p.brand = :brand";
            $params[':brand'] = $filters['brand'];
        }
        
        // Filter by price range
        if (!empty($filters['min_price'])) {
            $sql .= " AND (SELECT MIN(price) FROM Product_Variants WHERE product_id = p.product_id AND stock_quantity > 0) >= :min_price";
            $params[':min_price'] = $filters['min_price'];
        }
        if (!empty($filters['max_price'])) {
            $sql .= " AND (SELECT MIN(price) FROM Product_Variants WHERE product_id = p.product_id AND stock_quantity > 0) <= :max_price";
            $params[':max_price'] = $filters['max_price'];
        }
        
        // Filter by in stock only
        if (isset($filters['in_stock']) && $filters['in_stock']) {
            $sql .= " AND EXISTS (SELECT 1 FROM Product_Variants WHERE product_id = p.product_id AND stock_quantity > 0)";
        }
        
        // Group by product
        $sql .= " GROUP BY p.product_id";
        
        // Sort
        switch ($sort) {
            case 'price_asc':
                $sql .= " ORDER BY min_price ASC";
                break;
            case 'price_desc':
                $sql .= " ORDER BY min_price DESC";
                break;
            case 'name_asc':
                $sql .= " ORDER BY p.product_name ASC";
                break;
            case 'name_desc':
                $sql .= " ORDER BY p.product_name DESC";
                break;
            case 'newest':
            default:
                $sql .= " ORDER BY p.product_id DESC";
                break;
        }
        
        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $params[':limit'] = (int)$limit;
            $params[':offset'] = (int)$offset;
        }
        
        $stmt = $this->conn->prepare($sql);
        foreach ($params as $key => $value) {
            if ($key === ':limit' || $key === ':offset') {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value);
            }
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function searchProductsCount($keyword, $filters = []) {
        $sql = "SELECT COUNT(DISTINCT p.product_id) as total
                FROM Products p 
                LEFT JOIN Product_Variants pv ON p.product_id = pv.product_id
                WHERE (p.product_name LIKE :keyword 
                   OR p.brand LIKE :keyword 
                   OR p.description LIKE :keyword)";
        
        $params = [':keyword' => "%$keyword%"];
        
        // Filter by category
        if (!empty($filters['category_id'])) {
            $sql .= " AND p.category_id = :category_id";
            $params[':category_id'] = $filters['category_id'];
        }
        
        // Filter by brand
        if (!empty($filters['brand'])) {
            $sql .= " AND p.brand = :brand";
            $params[':brand'] = $filters['brand'];
        }
        
        // Filter by price range
        if (!empty($filters['min_price'])) {
            $sql .= " AND (SELECT MIN(price) FROM Product_Variants WHERE product_id = p.product_id AND stock_quantity > 0) >= :min_price";
            $params[':min_price'] = $filters['min_price'];
        }
        if (!empty($filters['max_price'])) {
            $sql .= " AND (SELECT MIN(price) FROM Product_Variants WHERE product_id = p.product_id AND stock_quantity > 0) <= :max_price";
            $params[':max_price'] = $filters['max_price'];
        }
        
        // Filter by in stock only
        if (isset($filters['in_stock']) && $filters['in_stock']) {
            $sql .= " AND EXISTS (SELECT 1 FROM Product_Variants WHERE product_id = p.product_id AND stock_quantity > 0)";
        }
        
        $stmt = $this->conn->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
    
    public function getProductsByCategory($categoryId) {
        $sql = "SELECT p.*, c.category_name 
                FROM Products p 
                LEFT JOIN Categories c ON p.category_id = c.category_id 
                WHERE p.category_id = :category_id 
                ORDER BY p.product_name";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getAllCategories() {
        $sql = "SELECT * FROM Categories ORDER BY category_name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getFeaturedProducts($limit = 8) {
        $sql = "SELECT p.*, pv.variant_id, pv.price, pv.color, pv.storage, 
                       MIN(pv.price) as min_price,
                       c.category_name
                FROM Products p 
                INNER JOIN Product_Variants pv ON p.product_id = pv.product_id 
                LEFT JOIN Categories c ON p.category_id = c.category_id 
                WHERE pv.stock_quantity > 0
                GROUP BY p.product_id 
                ORDER BY p.created_at DESC 
                LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getBestSellingProducts($limit = 8) {
        $sql = "SELECT p.*, pv.variant_id, pv.price, pv.color, pv.storage,
                       MIN(pv.price) as min_price,
                       COUNT(od.order_detail_id) as total_sold,
                       c.category_name
                FROM Products p 
                INNER JOIN Product_Variants pv ON p.product_id = pv.product_id 
                LEFT JOIN Order_Details od ON pv.variant_id = od.variant_id
                LEFT JOIN Categories c ON p.category_id = c.category_id 
                WHERE pv.stock_quantity >= 0
                GROUP BY p.product_id 
                ORDER BY total_sold DESC, p.created_at DESC 
                LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Admin functions
    public function createProduct($data) {
        $sql = "INSERT INTO Products (product_name, brand, description, category_id, supplier_id) 
                VALUES (:product_name, :brand, :description, :category_id, :supplier_id)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
    
    public function updateProduct($id, $data) {
        $sql = "UPDATE Products SET 
                product_name = :product_name,
                brand = :brand,
                description = :description,
                category_id = :category_id,
                supplier_id = :supplier_id
                WHERE product_id = :id";
        $stmt = $this->conn->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }
    
    public function deleteProduct($id) {
        $sql = "DELETE FROM Products WHERE product_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function createVariant($data) {
        $sql = "INSERT INTO Product_Variants 
                (product_id, variant_name, color, storage, price, stock_quantity, warranty_months) 
                VALUES (:product_id, :variant_name, :color, :storage, :price, :stock_quantity, :warranty_months)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
    
    public function updateVariant($id, $data) {
        $sql = "UPDATE Product_Variants SET 
                variant_name = :variant_name,
                color = :color,
                storage = :storage,
                price = :price,
                stock_quantity = :stock_quantity,
                warranty_months = :warranty_months
                WHERE variant_id = :id";
        $stmt = $this->conn->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }
    
    public function deleteVariant($id) {
        $sql = "DELETE FROM Product_Variants WHERE variant_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    // Category management
    public function getCategoryById($id) {
        $sql = "SELECT * FROM Categories WHERE category_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function createCategory($data) {
        $sql = "INSERT INTO Categories (category_name, description) VALUES (:category_name, :description)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
    
    public function updateCategory($id, $data) {
        $sql = "UPDATE Categories SET category_name = :category_name, description = :description WHERE category_id = :id";
        $stmt = $this->conn->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }
    
    public function deleteCategory($id) {
        // Kiểm tra xem có sản phẩm nào đang sử dụng category này không
        $checkSql = "SELECT COUNT(*) as count FROM Products WHERE category_id = :id";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':id', $id);
        $checkStmt->execute();
        $result = $checkStmt->fetch();
        
        if ($result['count'] > 0) {
            return false; // Không thể xóa vì đang có sản phẩm sử dụng
        }
        
        $sql = "DELETE FROM Categories WHERE category_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>

