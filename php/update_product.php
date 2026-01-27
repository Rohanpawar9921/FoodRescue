<?php

include "db.php";

$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? null;
$price = $_POST['price'] ?? null;
$category = $_POST['category_id'] ?? null;

if (!$id || !$name || !$price || !$category) {
    die("All fields are required");
}

try {
    $sql = "UPDATE products 
            SET name = ?, price = ?, category_id = ?
            WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name, $price, intval($category), intval($id)]);
    
    echo "Product Updated Successfully";
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
