<?php

include "db.php";

$productId = $_GET['id'] ?? null;

if (!$productId) {
    die("Product ID is required");
}

try {
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([intval($productId)]);
    
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        die("Product not found");
    }
    
    echo json_encode($product);
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
