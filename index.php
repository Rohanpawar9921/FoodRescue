<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ShopHub - Your Premium Shopping Destination</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideIn {
      from { opacity: 0; transform: translateX(-30px); }
      to { opacity: 1; transform: translateX(0); }
    }
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
    @keyframes shimmer {
      0% { background-position: -1000px 0; }
      100% { background-position: 1000px 0; }
    }
    .animate-fadeIn { animation: fadeIn 0.6s ease-out; }
    .animate-slideIn { animation: slideIn 0.8s ease-out; }
    .animate-float { animation: float 3s ease-in-out infinite; }
    .gradient-bg {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .shimmer {
      background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
      background-size: 1000px 100%;
      animation: shimmer 2s infinite;
    }
    .product-card {
      transition: all 0.3s ease;
    }
    .product-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .glass-effect {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
  </style>
</head>
<body class="bg-gray-50"><body class="bg-gray-50">

<!-- Navigation -->
<nav class="gradient-bg shadow-lg sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-14">
      <!-- Logo -->
      <a href="index.php" class="flex items-center space-x-2 animate-slideIn">
        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md">
          <i class="fas fa-shopping-bag text-purple-600 text-sm"></i>
        </div>
        <span class="text-white text-lg font-bold">ShopHub</span>
      </a>
      
      <!-- Navigation Links -->
      <div class="hidden md:flex items-center space-x-3">
        <a href="home.php" class="text-white hover:bg-white hover:text-purple-600 px-3 py-1.5 rounded-lg transition duration-300 flex items-center space-x-1.5 text-sm font-medium">
          <i class="fas fa-home text-xs"></i>
          <span>Home</span>
        </a>
        <?php if (isset($_SESSION['user_id'])): ?>
          <span class="glass-effect text-white px-3 py-1.5 rounded-full text-sm">
            <i class="fas fa-user-circle mr-1 text-xs"></i>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
          </span>
          <a href="admin.php" class="bg-white text-purple-600 hover:bg-purple-100 px-4 py-1.5 rounded-lg font-medium transition duration-300 flex items-center space-x-1.5 shadow-md text-sm">
            <i class="fas fa-plus-circle text-xs"></i>
            <span>Add Product</span>
          </a>
          <a href="php/logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded-lg font-medium transition duration-300 flex items-center space-x-1.5 text-sm">
            <i class="fas fa-sign-out-alt text-xs"></i>
            <span>Logout</span>
          </a>
        <?php else: ?>
          <a href="#" id="addProductLink" class="text-white hover:bg-white hover:text-purple-600 px-3 py-1.5 rounded-lg transition duration-300 text-sm font-medium">
            <i class="fas fa-plus-circle mr-1 text-xs"></i>Add Products
          </a>
          <a href="login.php" class="bg-white text-purple-600 hover:bg-purple-100 px-4 py-1.5 rounded-lg font-medium transition duration-300 shadow-md text-sm">
            <i class="fas fa-sign-in-alt mr-1 text-xs"></i>Login
          </a>
          <a href="signup.php" class="border-2 border-white text-white hover:bg-white hover:text-purple-600 px-4 py-1.5 rounded-lg font-medium transition duration-300 text-sm">
            <i class="fas fa-user-plus mr-1 text-xs"></i>Sign Up
          </a>
        <?php endif; ?>
      </div>
      
      <!-- Mobile Menu Button -->
      <button class="md:hidden text-white" id="mobileMenuBtn">
        <i class="fas fa-bars text-xl"></i>
      </button>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden pb-3">
      <a href="home.php" class="block text-white hover:bg-purple-700 px-3 py-2 rounded-lg mb-2 text-sm">
        <i class="fas fa-home mr-1.5 text-xs"></i>Home
      </a>
      <?php if (isset($_SESSION['user_id'])): ?>
        <span class="block text-white px-4 py-2 mb-2">
          <i class="fas fa-user-circle mr-2"></i><?php echo htmlspecialchars($_SESSION['username']); ?>
        </span>
        <a href="admin.php" class="block bg-white text-purple-600 px-4 py-2 rounded-lg mb-2 text-center">
          <i class="fas fa-plus-circle mr-2"></i>Add Product
        </a>
        <a href="php/logout.php" class="block bg-red-500 text-white px-4 py-2 rounded-lg text-center">
          <i class="fas fa-sign-out-alt mr-2"></i>Logout
        </a>
      <?php else: ?>
        <a href="login.php" class="block bg-white text-purple-600 px-4 py-2 rounded-lg mb-2 text-center">
          <i class="fas fa-sign-in-alt mr-2"></i>Login
        </a>
        <a href="signup.php" class="block border-2 border-white text-white px-4 py-2 rounded-lg text-center">
          <i class="fas fa-user-plus mr-2"></i>Sign Up
        </a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<div class="gradient-bg text-white py-16 md:py-20 relative overflow-hidden">
  <div class="absolute inset-0 opacity-10">
    <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-white rounded-full blur-3xl animate-float" style="animation-delay: 1s;"></div>
  </div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
      <!-- Left Side - Text Content -->
      <div class="animate-slideIn">
        <div class="inline-block bg-white bg-opacity-20 rounded-full px-3 py-1 mb-4 text-sm">
          <i class="fas fa-star mr-1"></i>Premium Quality
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">
          Discover Amazing Products
        </h1>
        <p class="text-base md:text-lg mb-6 text-purple-100 leading-relaxed">
          Browse our curated collection of premium electronics, books, and fashion. Quality products at unbeatable prices.
        </p>
        <div class="flex flex-col sm:flex-row gap-3">
          <button onclick="document.getElementById('products-section').scrollIntoView({behavior: 'smooth'})" class="bg-white text-purple-600 px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-purple-100 transition duration-300 shadow-lg inline-flex items-center justify-center">
            <i class="fas fa-shopping-cart mr-2 text-xs"></i>Start Shopping
          </button>
          <a href="#features" class="border-2 border-white text-white px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-white hover:text-purple-600 transition duration-300 inline-flex items-center justify-center">
            <i class="fas fa-info-circle mr-2 text-xs"></i>Learn More
          </a>
        </div>
      </div>
      
      <!-- Right Side - Visual Content -->
      <div class="hidden lg:flex items-center justify-center animate-fadeIn">
        <div class="relative">
          <div class="grid grid-cols-2 gap-4">
            <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl p-6 text-center border border-white border-opacity-20">
              <i class="fas fa-shopping-bag text-4xl mb-2"></i>
              <div class="text-2xl font-bold">500+</div>
              <div class="text-xs text-purple-100">Products</div>
            </div>
            <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl p-6 text-center border border-white border-opacity-20 mt-8">
              <i class="fas fa-users text-4xl mb-2"></i>
              <div class="text-2xl font-bold">10K+</div>
              <div class="text-xs text-purple-100">Customers</div>
            </div>
            <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl p-6 text-center border border-white border-opacity-20">
              <i class="fas fa-star text-4xl mb-2"></i>
              <div class="text-2xl font-bold">4.9</div>
              <div class="text-xs text-purple-100">Rating</div>
            </div>
            <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl p-6 text-center border border-white border-opacity-20 mt-8">
              <i class="fas fa-truck text-4xl mb-2"></i>
              <div class="text-2xl font-bold">Fast</div>
              <div class="text-xs text-purple-100">Delivery</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Features Section -->
<div id="features" class="py-16 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12 animate-fadeIn">
      <h2 class="text-3xl font-bold text-gray-800 mb-2">Why Choose ShopHub?</h2>
      <p class="text-base text-gray-600">Experience the best online shopping with our premium features</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="text-center p-6 rounded-xl bg-gradient-to-br from-purple-50 to-blue-50 hover:shadow-xl transition duration-300 animate-fadeIn">
        <div class="w-14 h-14 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-md">
          <i class="fas fa-truck text-white text-xl"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">Fast Delivery</h3>
        <p class="text-sm text-gray-600">Get your products delivered within 2-3 business days</p>
      </div>
      <div class="text-center p-6 rounded-xl bg-gradient-to-br from-pink-50 to-purple-50 hover:shadow-xl transition duration-300 animate-fadeIn" style="animation-delay: 0.2s;">
        <div class="w-14 h-14 bg-pink-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-md">
          <i class="fas fa-shield-alt text-white text-xl"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">Secure Payment</h3>
        <p class="text-sm text-gray-600">Shop with confidence using our encrypted payment gateway</p>
      </div>
      <div class="text-center p-6 rounded-xl bg-gradient-to-br from-blue-50 to-purple-50 hover:shadow-xl transition duration-300 animate-fadeIn" style="animation-delay: 0.4s;">
        <div class="w-14 h-14 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-md">
          <i class="fas fa-headset text-white text-xl"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">24/7 Support</h3>
        <p class="text-sm text-gray-600">Our dedicated customer service team is always here
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Features Section -->
<div id="features" class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16 animate-fadeIn">
      <h2 class="text-4xl font-bold text-gray-800 mb-4">Why Choose ShopHub?</h2>
      <p class="text-xl text-gray-600">Experience the best online shopping with our premium features</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-purple-50 to-blue-50 hover:shadow-2xl transition duration-300 animate-fadeIn">
        <div class="w-20 h-20 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
          <i class="fas fa-truck text-white text-3xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Fast Delivery</h3>
        <p class="text-gray-600">Get your products delivered within 2-3 business days with our express shipping</p>
      </div>
      <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-pink-50 to-purple-50 hover:shadow-2xl transition duration-300 animate-fadeIn" style="animation-delay: 0.2s;">
        <div class="w-20 h-20 bg-pink-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
          <i class="fas fa-shield-alt text-white text-3xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Secure Payment</h3>
        <p class="text-gray-600">Shop with confidence using our encrypted and secure payment gateway</p>
      </div>
      <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-blue-50 to-purple-50 hover:shadow-2xl transition duration-300 animate-fadeIn" style="animation-delay: 0.4s;">
        <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
          <i class="fas fa-headset text-white text-3xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-4">24/7 Support</h3>
        <p class="text-gray-600">Our dedicated customer service team is always here to help you</p>
      </div>
    </div>
  </div>
</div>

<!-- Filter Section -->
<div id="products-section" class="py-12 bg-gray-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 animate-fadeIn">
      <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
        <div class="flex items-center space-x-3">
          <i class="fas fa-filter text-purple-600 text-2xl"></i>
          <div>
            <h3 class="text-lg font-bold text-gray-800">Filter Products</h3>
            <p class="text-xs text-gray-600">Find exactly what you're looking for</p>
          </div>
        </div>
        <div class="flex items-center space-x-3">
          <label for="category" class="text-sm font-semibold text-gray-700">Category:</label>
          <select id="category" class="px-4 py-2 border-2 border-purple-300 rounded-lg focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none text-sm">
            <option value="">🌟 All Products</option>
            <option value="1">📱 Electronics</option>
            <option value="2">📚 Books</option>
            <option value="3">👔 Clothing</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Loader -->
    <div id="loader" class="hidden text-center py-12">
      <div class="inline-block animate-spin rounded-full h-10 w-10 border-t-4 border-b-4 border-purple-600"></div>
      <p class="text-sm text-gray-600 mt-2">Loading products...</p>
    </div>

    <!-- Products Grid -->
    <div id="products" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8"></div>
  </div>
</div>

<!-- Stats Section -->
<div class="py-12 gradient-bg text-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
      <div class="animate-fadeIn">
        <div class="text-3xl font-bold mb-1">10K+</div>
        <div class="text-sm text-purple-200">Happy Customers</div>
      </div>
      <div class="animate-fadeIn" style="animation-delay: 0.1s;">
        <div class="text-3xl font-bold mb-1">500+</div>
        <div class="text-sm text-purple-200">Premium Products</div>
      </div>
      <div class="animate-fadeIn" style="animation-delay: 0.2s;">
        <div class="text-3xl font-bold mb-1">98%</div>
        <div class="text-sm text-purple-200">Satisfaction Rate</div>
      </div>
      <div class="animate-fadeIn" style="animation-delay: 0.3s;">
        <div class="text-3xl font-bold mb-1">24/7</div>
        <div class="text-sm text-purple-200">Customer Support</div>
      </div>
    </div>
  </div>
</div>

<!-- Testimonials Section -->
<div class="py-12 bg-gray-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-10">
      <h2 class="text-3xl font-bold text-gray-800 mb-2">What Our Customers Say</h2>
      <p class="text-base text-gray-600">Join thousands of satisfied shoppers</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300">
        <div class="flex items-center mb-3">
          <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">A</div>
          <div class="ml-3">
            <div class="font-bold text-gray-800 text-sm">Alex Johnson</div>
            <div class="text-yellow-500 text-xs">★★★★★</div>
          </div>
        </div>
        <p class="text-gray-600 text-sm italic">"Amazing products and super fast delivery! The quality exceeded my expectations. Highly recommended!"</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300">
        <div class="flex items-center mb-3">
          <div class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center text-white font-bold text-sm">S</div>
          <div class="ml-3">
            <div class="font-bold text-gray-800 text-sm">Sarah Williams</div>
            <div class="text-yellow-500 text-xs">★★★★★</div>
          </div>
        </div>
        <p class="text-gray-600 text-sm italic">"Best online shopping experience ever! The customer service team was incredibly helpful and responsive."</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300">
        <div class="flex items-center mb-3">
          <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">M</div>
          <div class="ml-3">
            <div class="font-bold text-gray-800 text-sm">Michael Chen</div>
            <div class="text-yellow-500 text-xs">★★★★★</div>
          </div>
        </div>
        <p class="text-gray-600 text-sm italic">"Great variety of products and amazing deals. I'm a regular customer now and couldn't be happier!"</p>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
      <div>
        <div class="flex items-center space-x-2 mb-3">
          <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center">
            <i class="fas fa-shopping-bag text-white text-sm"></i>
          </div>
          <span class="text-lg font-bold">ShopHub</span>
        </div>
        <p class="text-gray-400 text-sm">Your trusted destination for premium products and exceptional service.</p>
      </div>
      <div>
        <h4 class="text-base font-bold mb-3">Quick Links</h4>
        <ul class="space-y-1 text-gray-400 text-sm">
          <li><a href="#" class="hover:text-white transition">About Us</a></li>
          <li><a href="#" class="hover:text-white transition">Contact</a></li>
          <li><a href="#" class="hover:text-white transition">FAQ</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-base font-bold mb-3">Categories</h4>
        <ul class="space-y-1 text-gray-400 text-sm">
          <li><a href="#" class="hover:text-white transition">Electronics</a></li>
          <li><a href="#" class="hover:text-white transition">Books</a></li>
          <li><a href="#" class="hover:text-white transition">Clothing</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-base font-bold mb-3">Connect With Us</h4>
        <div class="flex space-x-3">
          <a href="#" class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center hover:bg-purple-700 transition text-xs">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#" class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center hover:bg-purple-700 transition text-xs">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#" class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center hover:bg-purple-700 transition text-xs">
            <i class="fab fa-instagram"></i>
          </a>
        </div>
      </div>
    </div>
    <div class="border-t border-gray-800 pt-6 text-center text-gray-400 text-sm">
      <p>&copy; 2026 ShopHub. All rights reserved.</p>
    </div>
  </div>
</footer>

<!-- New OOP API Helper -->
<script src="js/api.js"></script>
<!-- Refactored App.js using new API -->
<script src="js/app-refactored.js"></script>

<script>
  // Prevent non-logged-in users from accessing admin page
  <?php if (!isset($_SESSION['user_id'])): ?>
  $(document).ready(function() {
    $("#addProductLink").click(function(e) {
      e.preventDefault();
      alert("Please login before adding products!");
      window.location.href = "login.php";
    });
  });
  <?php endif; ?>
</script>
</body>
</html>