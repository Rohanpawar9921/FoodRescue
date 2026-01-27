<?php

include "db.php";
$productId = $_POST['product_id'];
try {
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([intval($productId)]);
    
    echo "Product Deleted Successfully";
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}