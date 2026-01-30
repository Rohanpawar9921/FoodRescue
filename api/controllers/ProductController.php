<?php

class ProductController extends BaseController {
    
    /**
     * Fetch products with optional category filter and pagination
     */
    public function fetch() {
        $data = $this->getRequestData();
        $category = $data['category'] ?? "";
        $page = isset($data['page']) ? intval($data['page']) : 1;
        $limit = isset($data['limit']) ? intval($data['limit']) : 12; // Default 12 products per page
        $isLoggedIn = isset($_SESSION['user_id']);
        
        // Ensure page is at least 1
        $page = max(1, $page);
        $offset = ($page - 1) * $limit;
        
        // Redis caching (optional) - including pagination in cache key
        $useRedis = false;
        try {
            $redis = new Redis();
            $redis->connect('127.0.0.1', 6379);
            $useRedis = true;
            
            $cacheKey = "products:category:{$category}:page:{$page}:limit:{$limit}:logged:".($isLoggedIn ? '1' : '0');
            $cachedData = $redis->get($cacheKey);
            
            if($cachedData !== false) {
                return json_decode($cachedData, true);
            }
        } catch (Error $e) {
            // Redis not available, continue without cache
            $useRedis = false;
        }
        
        // Get total count for pagination
        $countSql = "SELECT COUNT(*) as total FROM products";
        if($category != "") {
            $countSql .= " WHERE category_id = ?";
        }
        
        $countStmt = $this->db->prepare($countSql);
        if($category != "") {
            $countStmt->execute([intval($category)]);
        } else {
            $countStmt->execute();
        }
        $totalProducts = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPages = ceil($totalProducts / $limit);
        
        // Get products with pagination
        $sql = "SELECT products.*, categories.name as category_name
                FROM products 
                JOIN categories ON products.category_id = categories.id";
        
        if($category != "") {
            $sql .= " WHERE products.category_id = ?";
        }
        
        $sql .= " ORDER BY products.id DESC LIMIT ? OFFSET ?";
        
        $stmt = $this->db->prepare($sql);
        
        if($category != "") {
            $stmt->execute([intval($category), $limit, $offset]);
        } else {
            $stmt->execute([$limit, $offset]);
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
        
        // Prepare response with pagination metadata
        $response = [
            'products' => $products,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_products' => $totalProducts,
                'per_page' => $limit,
                'has_next' => $page < $totalPages,
                'has_prev' => $page > 1
            ]
        ];
        
        // Cache the result if Redis is available
        if ($useRedis && isset($redis)) {
            $redis->setex($cacheKey, 3600, json_encode($response));
        }
        
        return $response;
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
