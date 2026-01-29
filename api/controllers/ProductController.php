<?php

class ProductController extends BaseController {
    
    /**
     * Fetch products with optional category filter
     */
    public function fetch() {
        $data = $this->getRequestData();
        $category = $data['category'] ?? "";
        $isLoggedIn = isset($_SESSION['user_id']);
        
        // Redis caching (optional)
        $useRedis = false;
        try {
            $redis = new Redis();
            $redis->connect('127.0.0.1', 6379);
            $useRedis = true;
            
            $cacheKey = "products:category:{$category}:logged:".($isLoggedIn ? '1' : '0');
            $cachedData = $redis->get($cacheKey);
            
            if($cachedData !== false) {
                return json_decode($cachedData, true);
            }
        } catch (Error $e) {
            // Redis not available, continue without cache
            $useRedis = false;
        }
        
        $sql = "SELECT products.*, categories.name as category_name
                FROM products 
                JOIN categories ON products.category_id = categories.id";
        
        if($category != "") {
            $sql .= " WHERE products.category_id = ?";
        }
        
        $stmt = $this->db->prepare($sql);
        
        if($category != "") {
            $stmt->execute([intval($category)]);
        } else {
            $stmt->execute();
        }
        
        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = [
                'id' => $row['id'],
                'name' => htmlspecialchars($row['name']),
                'price' => number_format($row['price'], 2),
                'category_name' => htmlspecialchars($row['category_name']),
                'category_id' => $row['category_id'],
                'is_logged_in' => $isLoggedIn
            ];
        }
        
        // Cache the result if Redis is available
        if ($useRedis && isset($redis)) {
            $redis->setex($cacheKey, 3600, json_encode($products));
        }
        
        return $products;
    }
    
    /**
     * Get single product by ID
     */
    public function get() {
        $data = $this->getRequestData();
        $productId = $data['id'] ?? null;
        
        if (!$productId) {
            throw new Exception("Product ID is required");
        }
        
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([intval($productId)]);
        
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$product) {
            throw new Exception("Product not found");
        }
        
        return $product;
    }
    
    /**
     * Add new product
     */
    public function add() {
        $data = $this->getRequestData();
        $this->validateRequired($data, ['name', 'price', 'category_id']);
        
        $sql = "INSERT INTO products (name, price, category_id)
                VALUES (?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['name'],
            $data['price'],
            intval($data['category_id'])
        ]);
        
        // Clear cache
        $this->clearProductCache();
        
        return [
            'message' => 'Product Added Successfully',
            'product_id' => $this->db->lastInsertId()
        ];
    }
    
    /**
     * Update existing product
     */
    public function update() {
        $data = $this->getRequestData();
        $this->validateRequired($data, ['id', 'name', 'price', 'category_id']);
        
        $sql = "UPDATE products 
                SET name = ?, price = ?, category_id = ?
                WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['name'],
            $data['price'],
            intval($data['category_id']),
            intval($data['id'])
        ]);
        
        // Clear cache
        $this->clearProductCache();
        
        return ['message' => 'Product Updated Successfully'];
    }
    
    /**
     * Delete product
     */
    public function delete() {
        $this->requireLogin();
        
        $data = $this->getRequestData();
        $productId = $data['product_id'] ?? $data['id'] ?? null;
        
        if (!$productId) {
            throw new Exception("Product ID is required");
        }
        
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([intval($productId)]);
        
        // Clear cache
        $this->clearProductCache();
        
        return ['message' => 'Product Deleted Successfully'];
    }
    
    /**
     * Clear product cache
     */
    private function clearProductCache() {
        try {
            $redis = new Redis();
            $redis->connect('127.0.0.1', 6379);
            $keys = $redis->keys('products:*');
            foreach ($keys as $key) {
                $redis->del($key);
            }
        } catch (Error $e) {
            // Redis not available, ignore
        }
    }
}
