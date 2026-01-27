<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container">
    <h1>➕ Add New Product</h1>

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