<?php
session_start();

include "db.php";

// Add error handling for Redis
try {
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    $useRedis = true;
} catch (Error $e) {
    // Redis extension not installed, continue without caching
    $useRedis = false;
}

$category = $_GET['category'] ?? "";
$isLoggedIn = isset($_SESSION['user_id']);

// Only use cache if Redis is available
if ($useRedis) {
    $cacheKey = "products:category:{$category}:logged:".($isLoggedIn ? '1' : '0');
    $cachedData = $redis->get($cacheKey);
    
    if($cachedData !== false) {
        echo $cachedData;
        exit;
    }
}

$sql = "SELECT products.*, categories.name as category_name
        FROM products 
        JOIN categories ON products.category_id = categories.id";

if($category != "") {
    $sql .= " WHERE products.category_id = ?";
}

$output = "";
try {
    $stmt = $conn->prepare($sql);
    
    if($category != "") {
        $stmt->execute([intval($category)]);
    } else {
        $stmt->execute();
    }
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $output .= "<div class=\"product-card\">
            <div class=\"product-info\">
                <strong>{$row['name']}</strong> - ₹{$row['price']} - <span class=\"category-badge\">{$row['category_name']}</span>
            </div>";
        
        if ($isLoggedIn) {
            $output .= "<div class=\"product-actions\">
                <button class=\"edit-product\" data-id=\"{$row['id']}\">Edit</button>
                <button class=\"delete-product delete-btn\" data-id=\"{$row['id']}\">Delete</button>
            </div>";
        }
        
        $output .= "</div>";
    }
    
    // Store in cache only if Redis is available
    if ($useRedis) {
        $redis->setex($cacheKey, 300, $output);
    }
    
    echo $output;
} catch(PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>