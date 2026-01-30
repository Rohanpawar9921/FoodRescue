<!DOCTYPE html>
<html>
<head>
    <title>Edit Surplus Food Item - FoodRescue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-50 min-h-screen py-8 px-4">

<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-2xl p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
            <i class="fas fa-edit text-green-600"></i> Edit Surplus Food Item
        </h1>
    </div>

    <div id="loader" class="text-center py-8" style="display:block;">
        <i class="fas fa-spinner fa-spin text-4xl text-green-600 mb-4"></i>
        <p class="text-gray-600">Loading product...</p>
    </div>

    <form id="editProduct" class="space-y-6" style="display:none;"> 
        <input type="hidden" name="id" id="productId">
        
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-utensils text-green-600 mr-2"></i>Food Item Name
            </label>
            <input type="text" name="name" id="productName" placeholder="e.g., Fresh Croissants" required
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
        </div>
        
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-rupee-sign text-green-600 mr-2"></i>Discounted Price (INR)
            </label>
            <input type="number" name="price" id="productPrice" placeholder="0.00" step="0.01" required
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
        </div>
        
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-list text-green-600 mr-2"></i>Category
            </label>
            <select name="category_id" id="productCategory" required
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition bg-white">
                <option value="">Select Category</option>
                <option value="1">🍞 Bakery & Desserts</option>
                <option value="2">🥗 Vegetarian Meals</option>
                <option value="3">🍗 Non-Veg Meals</option>
            </select>
        </div>
        
        <button type="submit" 
                class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white py-3 rounded-lg font-semibold hover:from-green-700 hover:to-emerald-700 transition duration-300 flex items-center justify-center space-x-2 shadow-lg">
            <i class="fas fa-save"></i>
            <span>Update Food Item</span>
        </button>
    </form>

    <div id="msg" class="mt-6"></div>
    
    <div class="flex gap-3 mt-6">
        <a href="index.php" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-3 rounded-lg font-medium text-center transition duration-300 border-2 border-gray-300">
            <i class="fas fa-arrow-left mr-2"></i>Back to Catalog
        </a>
        <a href="admin.php" class="flex-1 bg-green-100 hover:bg-green-200 text-green-800 px-4 py-3 rounded-lg font-medium text-center transition duration-300 border-2 border-green-300">
            <i class="fas fa-plus-circle mr-2"></i>Add New Item
        </a>
    </div>
</div>

<!-- New OOP API Helper -->
<script src="../js/api.js"></script>
<script> 
    $(document).ready(function() {
        // Get product ID from URL
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get('id');
        
        if (!productId) {
            $("#loader").html("No product ID provided");
            return;
        }
        
        // Load product data using new API
        API.call('product', 'get', {id: productId})
            .then(function(product) {
                $("#productId").val(product.id);
                $("#productName").val(product.name);
                $("#productPrice").val(product.price);
                $("#productCategory").val(product.category_id);
                
                $("#loader").hide();
                $("#editProduct").show();
            })
            .catch(function(error) {
                $("#loader").html(`<p style="color: red;">Error: ${error}</p>`);
            });
        
        // Handle form submission using new API
        $("#editProduct").submit(function(e) {
            e.preventDefault();
            const formData = {
                id: $("#productId").val(),
                name: $("#productName").val(),
                price: $("#productPrice").val(),
                category_id: $("#productCategory").val()
            };
            
            API.call('product', 'update', formData)
                .then(function(result) {
                    $("#msg").html(`<p style="color: green;">${result.message}</p>`);
                    setTimeout(function() {
                        window.location.href = "index.php";
                    }, 1500);
                })
                .catch(function(error) {
                    $("#msg").html(`<p style="color: red;">Error: ${error}</p>`);
                });
        });
    });
</script>

</body>
</html>
