<?php

include "db.php";

$category = $_GET['category'] ?? "";

$sql = "select products.*, categories.name as category_name
        from products 
        join categories on products.category_id = categories.id";

if($category != "") {
    $sql .= " where products.category_id = ?";
}

try {
    $stmt = $conn->prepare($sql);
    
    if($category != "") {
        $stmt->execute([intval($category)]);
    } else {
        $stmt->execute();
    }
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class=\"product-card\">
            <div class=\"product-info\">
                <strong>{$row['name']}</strong> - ₹{$row['price']} - <span class=\"category-badge\">{$row['category_name']}</span>
            </div>
            <div class=\"product-actions\">
                <button class=\"edit-product\" data-id=\"{$row['id']}\">Edit</button>
                <button class=\"delete-product delete-btn\" data-id=\"{$row['id']}\">Delete</button>
            </div>
        </div>";
    }
} catch(PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>