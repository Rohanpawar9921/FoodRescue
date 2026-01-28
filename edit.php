<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
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
        <h1>✏️ Edit Product</h1>
        <div>
            <span class="user_info">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!!</span>
        </div>
    </div>

    <div id="loader" style="display:block;">Loading product...</div>

    <form id="editProduct" style="display:none;"> 
        <input type="hidden" name="id" id="productId">
        <input type="text" name="name" id="productName" placeholder="Product Name" required>
        <input type="number" name="price" id="productPrice" placeholder="Price" step="0.01" required>
        <select name="category_id" id="productCategory" required>
            <option value="">Select Category</option>
            <option value="1">Electronics</option>
            <option value="2">Books</option>
            <option value="3">Clothing</option>
        </select>
        <button type="submit">Update Product</button>
    </form>

    <div id="msg"></div>
    <div class="nav-actions">
        <a href="index.php" class="nav-link">Back to catalog</a>
    </div>
</div>

<script> 
    $(document).ready(function() {
        // Get product ID from URL
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get('id');
        
        if (!productId) {
            $("#loader").html("No product ID provided");
            return;
        }
        
        // Load product data
        $.get("php/get_product.php", {id: productId}, function(response) {
            try {
                const product = JSON.parse(response);
                
                $("#productId").val(product.id);
                $("#productName").val(product.name);
                $("#productPrice").val(product.price);
                $("#productCategory").val(product.category_id);
                
                $("#loader").hide();
                $("#editProduct").show();
            } catch(e) {
                $("#loader").html("Error loading product: " + response);
            }
        }).fail(function() {
            $("#loader").html("Failed to load product");
        });
        
        // Handle form submission
        $("#editProduct").submit(function(e) {
            e.preventDefault();
            $.post("php/update_product.php", $(this).serialize(), function(res) {
                $("#msg").html(res);
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 1500);
            });
        });
    });
</script>

</body>
</html>
