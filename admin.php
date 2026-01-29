<?php
include "php/auth_check.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - ShopHub Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-slideIn { animation: slideIn 0.5s ease-out; }
        .animate-fadeIn { animation: fadeIn 0.6s ease-out; }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-gray-50">

<!-- Navigation -->
<nav class="gradient-bg shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-14">
            <a href="index.php" class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md">
                    <i class="fas fa-shopping-bag text-purple-600 text-sm"></i>
                </div>
                <span class="text-white text-lg font-bold">ShopHub</span>
            </a>
            <div class="flex items-center space-x-3">
                <span class="text-white bg-white bg-opacity-20 px-3 py-1.5 rounded-full text-sm">
                    <i class="fas fa-user-circle mr-1 text-xs"></i><?php echo htmlspecialchars($_SESSION['username']); ?>
                </span>
                <a href="index.php" class="text-white hover:bg-white hover:text-purple-600 px-3 py-1.5 rounded-lg transition duration-300 text-sm font-medium">
                    <i class="fas fa-store mr-1 text-xs"></i>Catalog
                </a>
                <a href="php/logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded-lg transition duration-300 text-sm font-medium">
                    <i class="fas fa-sign-out-alt mr-1 text-xs"></i>Logout
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="gradient-bg text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-slideIn">
        <div class="inline-block bg-white bg-opacity-20 rounded-full px-3 py-1 mb-3 text-sm">
            <i class="fas fa-shield-alt mr-1 text-xs"></i>Admin Panel
        </div>
        <h1 class="text-3xl md:text-4xl font-bold mb-2">Add New Product</h1>
        <p class="text-base text-purple-100">Expand your catalog with amazing products</p>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Add Product Form -->
    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 animate-fadeIn">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                <i class="fas fa-plus text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Product Information</h2>
                <p class="text-gray-600 text-sm">Fill in the details below to add a new product</p>
            </div>
        </div>

        <form id="addProduct" class="space-y-4">
            <!-- Product Name -->
            <div class="group">
                <label for="productName" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-tag mr-2 text-purple-600 text-xs"></i>
                    Product Name
                </label>
                <input 
                    type="text" 
                    id="productName"
                    name="name" 
                    placeholder="Enter product name (e.g., iPhone 15 Pro)" 
                    required
                    class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none transition duration-300 text-sm">
            </div>

            <!-- Product Price -->
            <div class="group">
                <label for="productPrice" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-dollar-sign mr-2 text-green-600 text-xs"></i>
                    Product Price
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">$</span>
                    <input 
                        type="number" 
                        id="productPrice"
                        name="price" 
                        placeholder="0.00" 
                        step="0.01" 
                        min="0"
                        required
                        class="w-full pl-10 pr-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none transition duration-300 text-sm">
                </div>
            </div>

            <!-- Category Selection -->
            <div class="group">
                <label for="productCategory" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-list mr-2 text-blue-600 text-xs"></i>
                    Category
                </label>
                <select 
                    id="productCategory"
                    name="category_id" 
                    required
                    class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none transition duration-300 text-sm appearance-none bg-white cursor-pointer">
                    <option value="">Select a category</option>
                    <option value="1">📱 Electronics</option>
                    <option value="2">📚 Books</option>
                    <option value="3">👔 Clothing</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full gradient-bg text-white py-3 rounded-lg font-semibold text-sm hover:shadow-xl transform hover:-translate-y-0.5 transition duration-300 flex items-center justify-center space-x-2">
                <i class="fas fa-plus-circle text-base"></i>
                <span>Add Product to Catalog</span>
            </button>
        </form>

        <!-- Success/Error Message -->
        <div id="msg" class="mt-6"></div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 text-white shadow-md">
            <i class="fas fa-box text-2xl mb-2 opacity-80"></i>
            <div class="text-xl font-bold">Easy</div>
            <div class="text-purple-100 text-sm">Simple Form</div>
        </div>
        <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl p-4 text-white shadow-md">
            <i class="fas fa-bolt text-2xl mb-2 opacity-80"></i>
            <div class="text-xl font-bold">Fast</div>
            <div class="text-pink-100 text-sm">Instant Addition</div>
        </div>
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 text-white shadow-md">
            <i class="fas fa-shield-alt text-2xl mb-2 opacity-80"></i>
            <div class="text-xl font-bold">Secure</div>
            <div class="text-blue-100 text-sm">Protected Data</div>
        </div>
    </div>

    <!-- Navigation Links -->
    <div class="flex flex-col sm:flex-row gap-3 mt-6">
        <a href="home.php" class="flex-1 bg-white hover:bg-gray-50 text-gray-800 px-4 py-2.5 rounded-lg font-medium text-center transition duration-300 shadow-md border-2 border-gray-200 text-sm">
            <i class="fas fa-home mr-1 text-xs"></i>Go to Home
        </a>
        <a href="index.php" class="flex-1 bg-white hover:bg-gray-50 text-gray-800 px-4 py-2.5 rounded-lg font-medium text-center transition duration-300 shadow-md border-2 border-gray-200 text-sm">
            <i class="fas fa-arrow-left mr-1 text-xs"></i>Back to Catalog
        </a>
    </div>
</div>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-6 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-gray-400">&copy; 2026 ShopHub Admin Panel. Manage your products with ease.</p>
    </div>
</footer>

<!-- New OOP API Helper -->
<script src="js/api.js"></script>
<script> 
    $(document).ready(function() {
        $("#addProduct").submit(function(e) {
            e.preventDefault();
            
            const formData = {
                name: $("input[name='name']").val().trim(),
                price: $("input[name='price']").val(),
                category_id: $("select[name='category_id']").val()
            };
            
            if (!formData.name || !formData.price || !formData.category_id) {
                showMessage('error', 'Please fill in all fields!');
                return;
            }
            
            const submitBtn = $(this).find('button[type="submit"]');
            const originalContent = submitBtn.html();
            submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Adding Product...').prop('disabled', true);
            
            API.call('product', 'add', formData)
                .then(function(result) {
                    showMessage('success', result.message);
                    $("#addProduct")[0].reset();
                    submitBtn.html(originalContent).prop('disabled', false);
                    
                    setTimeout(() => {
                        const notification = $(\`
                            <div class="fixed top-24 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center space-x-3 z-50 animate-slideIn">
                                <i class="fas fa-check-circle text-2xl"></i>
                                <span class="font-semibold">Product added successfully! Redirecting...</span>
                            </div>
                        \`);
                        $('body').append(notification);
                        setTimeout(() => {
                            window.location.href = 'index.php';
                        }, 2000);
                    }, 500);
                })
                .catch(function(error) {
                    showMessage('error', error);
                    submitBtn.html(originalContent).prop('disabled', false);
                });
        });
        
        function showMessage(type, message) {
            const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
            const bgColor = type === 'success' ? 'green' : 'red';
            
            $("#msg").html(\`
                <div class="bg-\${bgColor}-50 border-2 border-\${bgColor}-500 text-\${bgColor}-800 px-6 py-4 rounded-lg flex items-center space-x-3 animate-slideIn">
                    <i class="fas fa-\${icon} text-2xl"></i>
                    <span class="font-semibold">\${message}</span>
                </div>
            \`);
            
            setTimeout(() => {
                $("#msg").fadeOut();
            }, 5000);
        }
    });
</script>

</body>
</html>
