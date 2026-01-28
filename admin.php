<?php
include "php/auth_check.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .user-info {
            font-size: 14px;
            color: #666;
            margin-right: 10px;
        }
        .logout-btn {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }
        .logout-btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header-bar">
        <h1>➕ Add New Product</h1>
        <div>
            <span class="user-info">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="php/logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <form id="addProduct"> 
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="number" name="price" placeholder="Price" step="0.01" required>
        <select name="category_id" required>
            <option value="">Select Category</option>
            <option value="1">Electronics</option>
            <option value="2">Books</option>
            <option value="3">Clothing</option>
        </select>
        <button type="submit">Add Product</button>
    </form>

    <div id="msg"></div>
    <div class="nav-actions">
        <a href="index.php" class="nav-link">Back to catalog</a>
    </div>
</div>

<script> 
    $("#addProduct").submit(function(e) {
        e.preventDefault();
        $.post("php/add_product.php", $(this).serialize(), function(res) {
            $("#msg").html(res);
            $("#addProduct")[0].reset();
        });
    });
</script>

</body>
</html>