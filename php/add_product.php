<?php
include "db.php";

$name = $_POST['name'];
$price = $_POST['price'];
$category = $_POST['category_id'];

try {
    $sql = "INSERT INTO products (name, price, category_id)
            VALUES (?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name, $price, intval($category)]);
    
    echo "Product Added Successfully";
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>