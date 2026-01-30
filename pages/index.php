<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodRescue - Fight Food Waste, Feed Communities</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="../js/cookie-consent.js"></script>
  <style>
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes slideIn { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    @keyframes pulse-green { 0%, 100% { opacity: 1; } 50% { opacity: 0.6; } }
    .animate-fadeIn { animation: fadeIn 0.6s ease-out; }
    .animate-slideIn { animation: slideIn 0.8s ease-out; }
    .animate-float { animation: float 3s ease-in-out infinite; }
    .animate-pulse-green { animation: pulse-green 2s ease-in-out infinite; }
    .gradient-bg { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .gradient-eco { background: linear-gradient(135deg, #34d399 0%, #10b981 50%, #059669 100%); }
    .food-card { transition: all 0.3s ease; }
    .food-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(16, 185, 129, 0.2); }
    .glass-effect { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
    .urgent-badge { animation: pulse-green 2s ease-in-out infinite; }
    .leaf-pattern { background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 30c10-10 20-15 20-15s-5 10-15 20c-10 10-20 15-20 15s5-10 15-20z' fill='%2310b981' fill-opacity='0.05'/%3E%3C/svg%3E"); }
    
    /* Interactive Cards Animation */
    #interactive-cards-container {
      position: relative;
      width: 100%;
      height: 450px;
    }
    .interactive-card {
      position: absolute;
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      border-radius: 12px;
      padding: 16px;
      cursor: pointer;
      transition: all 0.15s ease-out;
      will-change: transform;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .interactive-card:hover {
      background: rgba(255, 255, 255, 0.2);
      border-color: rgba(255, 255, 255, 0.5);
    }
    .card-icon {
      font-size: 24px;
      margin-bottom: 8px;
      display: block;
    }
    .card-title {
      font-size: 16px;
      font-weight: 700;
      margin-bottom: 4px;
    }
    .card-value {
      font-size: 20px;
      font-weight: 800;
    }
    .card-subtitle {
      font-size: 11px;
      color: rgba(255, 255, 255, 0.8);
    }
  </style>
</head>
<body class="bg-green-50 leaf-pattern">

<nav class="gradient-bg shadow-lg sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-14">
      <a href="index.php" class="flex items-center space-x-2 animate-slideIn">
        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md">
          <i class="fas fa-leaf text-green-600 text-sm"></i>
        </div>
        <span class="text-white text-lg font-bold">FoodRescue</span>
      </a>
      
      <div class="hidden md:flex items-center space-x-3">
        <a href="home.php" class="text-white hover:bg-white hover:text-green-600 px-3 py-1.5 rounded-lg transition duration-300 flex items-center space-x-1.5 text-sm font-medium">
          <i class="fas fa-home text-xs"></i><span>Home</span>
        </a>
        <?php if (isset($_SESSION['user_id'])): ?>
          <span class="glass-effect text-white px-3 py-1.5 rounded-full text-sm">
            <i class="fas fa-user-circle mr-1 text-xs"></i>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
          </span>
          <a href="admin.php" class="bg-white text-green-600 hover:bg-green-100 px-4 py-1.5 rounded-lg font-medium transition duration-300 flex items-center space-x-1.5 shadow-md text-sm">
            <i class="fas fa-plus-circle text-xs"></i><span>List Surplus Food</span>
          </a>
          <a href="../php/logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded-lg font-medium transition duration-300 flex items-center space-x-1.5 text-sm">
            <i class="fas fa-sign-out-alt text-xs"></i><span>Logout</span>
          </a>
        <?php else: ?>
          <a href="#" id="addProductLink" class="text-white hover:bg-white hover:text-green-600 px-3 py-1.5 rounded-lg transition duration-300 text-sm font-medium">
            <i class="fas fa-plus-circle mr-1 text-xs"></i>List Food
          </a>
          <a href="login.php" class="bg-white text-green-600 hover:bg-green-100 px-4 py-1.5 rounded-lg font-medium transition duration-300 shadow-md text-sm">
            <i class="fas fa-sign-in-alt mr-1 text-xs"></i>Login
          </a>
          <a href="signup.php" class="border-2 border-white text-white hover:bg-white hover:text-green-600 px-4 py-1.5 rounded-lg font-medium transition duration-300 text-sm">
            <i class="fas fa-user-plus mr-1 text-xs"></i>Sign Up
          </a>
        <?php endif; ?>
      </div>
      
      <button class="md:hidden text-white" id="mobileMenuBtn"><i class="fas fa-bars text-xl"></i></button>
    </div>
    
    <div id="mobileMenu" class="hidden md:hidden pb-3">
      <a href="home.php" class="block text-white hover:bg-green-700 px-3 py-2 rounded-lg mb-2 text-sm">
        <i class="fas fa-home mr-1.5 text-xs"></i>Home
      </a>
      <?php if (isset($_SESSION['user_id'])): ?>
        <span class="block text-white px-4 py-2 mb-2"><i class="fas fa-user-circle mr-2"></i><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <a href="admin.php" class="block bg-white text-green-600 px-4 py-2 rounded-lg mb-2 text-center"><i class="fas fa-plus-circle mr-2"></i>List Surplus Food</a>
        <a href="../php/logout.php" class="block bg-red-500 text-white px-4 py-2 rounded-lg text-center"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
      <?php else: ?>
        <a href="login.php" class="block bg-white text-green-600 px-4 py-2 rounded-lg mb-2 text-center"><i class="fas fa-sign-in-alt mr-2"></i>Login</a>
        <a href="signup.php" class="block border-2 border-white text-white px-4 py-2 rounded-lg text-center"><i class="fas fa-user-plus mr-2"></i>Sign Up</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<div class="gradient-eco text-white py-16 md:py-20 relative overflow-hidden">
  <div class="absolute inset-0 opacity-10">
    <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-white rounded-full blur-3xl animate-float" style="animation-delay: 1s;"></div>
  </div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
      <div class="animate-slideIn">
        <div class="inline-block bg-white bg-opacity-20 rounded-full px-3 py-1 mb-4 text-sm"><i class="fas fa-seedling mr-1"></i>Zero Waste Mission</div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">Save Food. Save Money. Save Planet.</h1>
        <p class="text-base md:text-lg mb-6 text-green-100 leading-relaxed">🍕 Rescue surplus food from local restaurants & bakeries at 70% off!<br>🌍 Fight food waste while helping your community.<br>⏰ Pick up today before it goes to waste.</p>
        <div class="flex flex-col sm:flex-row gap-3">
          <button onclick="document.getElementById('foods-section').scrollIntoView({behavior: 'smooth'})" class="bg-white text-green-600 px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-green-100 transition duration-300 shadow-lg inline-flex items-center justify-center">
            <i class="fas fa-utensils mr-2 text-xs"></i>Browse Available Food
          </button>
          <a href="#impact" class="border-2 border-white text-white px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-white hover:text-green-600 transition duration-300 inline-flex items-center justify-center">
            <i class="fas fa-heart mr-2 text-xs"></i>Our Impact
          </a>
        </div>
        <div class="mt-8 grid grid-cols-3 gap-4">
          <div class="text-center"><div class="text-2xl font-bold">2.5K+</div><div class="text-xs text-green-100">Meals Saved</div></div>
          <div class="text-center"><div class="text-2xl font-bold">850kg</div><div class="text-xs text-green-100">Waste Prevented</div></div>
          <div class="text-center"><div class="text-2xl font-bold">Today</div><div class="text-xs text-green-100 urgent-badge">🔥 12 Available</div></div>
        </div>
      </div>
      <div class="hidden lg:flex items-center justify-center animate-fadeIn">
        <div id="interactive-cards-container" class="relative w-full max-w-lg">
          <!-- Cards will be dynamically created here -->
        </div>
      </div>
    </div>
  </div>
</div>

<div class="py-16 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12 animate-fadeIn">
      <h2 class="text-3xl font-bold text-gray-800 mb-2">How FoodRescue Works</h2>
      <p class="text-base text-gray-600">From surplus to saved in 3 simple steps</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="text-center p-6 rounded-xl bg-gradient-to-br from-green-50 to-emerald-50 hover:shadow-xl transition duration-300 animate-fadeIn">
        <div class="w-14 h-14 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-md"><i class="fas fa-search text-white text-xl"></i></div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">1. Browse Nearby</h3>
        <p class="text-sm text-gray-600">See what surplus food is available from restaurants & bakeries near you</p>
      </div>
      <div class="text-center p-6 rounded-xl bg-gradient-to-br from-emerald-50 to-teal-50 hover:shadow-xl transition duration-300 animate-fadeIn" style="animation-delay: 0.2s;">
        <div class="w-14 h-14 bg-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-md"><i class="fas fa-hand-pointer text-white text-xl"></i></div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">2. Claim Your Meal</h3>
        <p class="text-sm text-gray-600">Reserve food at massive discounts before the pickup deadline</p>
      </div>
      <div class="text-center p-6 rounded-xl bg-gradient-to-br from-teal-50 to-green-50 hover:shadow-xl transition duration-300 animate-fadeIn" style="animation-delay: 0.4s;">
        <div class="w-14 h-14 bg-teal-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-md"><i class="fas fa-shopping-bag text-white text-xl"></i></div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">3. Pick Up & Enjoy</h3>
        <p class="text-sm text-gray-600">Collect your food and feel good about fighting waste</p>
      </div>
    </div>
  </div>
</div>

<div id="foods-section" class="py-12 bg-green-50 leaf-pattern">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 animate-fadeIn">
      <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
        <div class="flex items-center space-x-3">
          <i class="fas fa-filter text-green-600 text-2xl"></i>
          <div><h3 class="text-lg font-bold text-gray-800">Available Food Near You</h3><p class="text-xs text-gray-600">🕐 All items must be picked up today!</p></div>
        </div>
        <div class="flex items-center space-x-3">
          <label for="category" class="text-sm font-semibold text-gray-700">Filter by Type:</label>
          <select id="category" class="px-4 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-200 focus:border-green-500 outline-none text-sm">
            <option value="">🌟 All Food</option>
            <option value="1">🥐 Bakery & Desserts</option>
            <option value="2">🥗 Vegetarian Meals</option>
            <option value="3">🍗 Non-Veg Meals</option>
          </select>
        </div>
      </div>
    </div>
    <div id="loader" class="hidden text-center py-12">
      <div class="inline-block animate-spin rounded-full h-10 w-10 border-t-4 border-b-4 border-green-600"></div>
      <p class="text-sm text-gray-600 mt-2">Loading available food...</p>
    </div>
    <div id="products" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8"></div>
  </div>
</div>

<div id="impact" class="py-12 gradient-eco text-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-8"><h2 class="text-3xl font-bold mb-2">Our Community Impact</h2><p class="text-green-100">Together, we're making a difference</p></div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
      <div class="animate-fadeIn"><div class="text-3xl font-bold mb-1">2,500+</div><div class="text-sm text-green-200">Meals Rescued</div></div>
      <div class="animate-fadeIn" style="animation-delay: 0.1s;"><div class="text-3xl font-bold mb-1">850kg</div><div class="text-sm text-green-200">Food Waste Prevented</div></div>
      <div class="animate-fadeIn" style="animation-delay: 0.2s;"><div class="text-3xl font-bold mb-1">$12K+</div><div class="text-sm text-green-200">Money Saved</div></div>
      <div class="animate-fadeIn" style="animation-delay: 0.3s;"><div class="text-3xl font-bold mb-1">500+</div><div class="text-sm text-green-200">Partner Businesses</div></div>
    </div>
  </div>
</div>

<div class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-10"><h2 class="text-3xl font-bold text-gray-800 mb-2">Community Stories</h2><p class="text-base text-gray-600">What food rescuers are saying</p></div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-l-4 border-green-500">
        <div class="flex items-center mb-3">
          <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-sm">P</div>
          <div class="ml-3"><div class="font-bold text-gray-800 text-sm">Priya Sharma</div><div class="text-green-500 text-xs">★★★★★ Rescued 45 meals</div></div>
        </div>
        <p class="text-gray-600 text-sm italic">"As a student, FoodRescue helps me eat well while staying on budget. Plus, I'm helping the environment!"</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-l-4 border-emerald-500">
        <div class="flex items-center mb-3">
          <div class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center text-white font-bold text-sm">R</div>
          <div class="ml-3"><div class="font-bold text-gray-800 text-sm">Rahul's Bakery</div><div class="text-emerald-500 text-xs">★★★★★ Partner Business</div></div>
        </div>
        <p class="text-gray-600 text-sm italic">"Instead of throwing away unsold items, we now help families. FoodRescue is a win-win for everyone!"</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-l-4 border-teal-500">
        <div class="flex items-center mb-3">
          <div class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold text-sm">A</div>
          <div class="ml-3"><div class="font-bold text-gray-800 text-sm">Amit Kumar</div><div class="text-teal-500 text-xs">★★★★★ Rescued 78 meals</div></div>
        </div>
        <p class="text-gray-600 text-sm italic">"Love getting fresh bakery items at 70% off! It's become my daily routine. Highly recommended!"</p>
      </div>
    </div>
  </div>
</div>

<div class="py-16 gradient-bg text-white">
  <div class="max-w-4xl mx-auto px-4 text-center">
    <h2 class="text-3xl md:text-4xl font-bold mb-4">Are You a Restaurant or Bakery?</h2>
    <p class="text-lg mb-8 text-green-100">Join our network and turn surplus into savings. Help your community while reducing waste.</p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
      <a href="signup.php" class="bg-white text-green-600 px-8 py-3 rounded-lg font-bold text-lg hover:bg-green-100 transition duration-300 shadow-lg inline-flex items-center justify-center"><i class="fas fa-store mr-2"></i>Become a Partner</a>
      <a href="#foods-section" class="border-2 border-white text-white px-8 py-3 rounded-lg font-bold text-lg hover:bg-white hover:text-green-600 transition duration-300 inline-flex items-center justify-center"><i class="fas fa-utensils mr-2"></i>Rescue Food Now</a>
    </div>
  </div>
</div>

<footer class="bg-gray-900 text-white py-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
      <div>
        <div class="flex items-center space-x-2 mb-3">
          <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center"><i class="fas fa-leaf text-white text-sm"></i></div>
          <span class="text-lg font-bold">FoodRescue</span>
        </div>
        <p class="text-gray-400 text-sm">Fighting food waste, one meal at a time. Join our zero-waste mission today.</p>
        <div class="mt-4"><span class="text-xs text-green-400">🌱 850kg waste prevented</span></div>
      </div>
      <div><h4 class="text-base font-bold mb-3">Quick Links</h4><ul class="space-y-1 text-gray-400 text-sm">
        <li><a href="#" class="hover:text-white transition">About Us</a></li><li><a href="#" class="hover:text-white transition">How It Works</a></li>
        <li><a href="#" class="hover:text-white transition">Contact</a></li><li><a href="#" class="hover:text-white transition">FAQ</a></li></ul>
      </div>
      <div><h4 class="text-base font-bold mb-3">For Businesses</h4><ul class="space-y-1 text-gray-400 text-sm">
        <li><a href="#" class="hover:text-white transition">Become a Partner</a></li><li><a href="#" class="hover:text-white transition">Success Stories</a></li>
        <li><a href="#" class="hover:text-white transition">Resources</a></li></ul>
      </div>
      <div><h4 class="text-base font-bold mb-3">Connect With Us</h4>
        <div class="flex space-x-3 mb-4">
          <a href="#" class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center hover:bg-green-700 transition text-xs"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center hover:bg-green-700 transition text-xs"><i class="fab fa-twitter"></i></a>
          <a href="#" class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center hover:bg-green-700 transition text-xs"><i class="fab fa-instagram"></i></a>
        </div>
        <p class="text-gray-400 text-xs">📧 hello@foodrescue.com<br>📞 +91 98765 43210</p>
      </div>
    </div>
    <div class="border-t border-gray-800 pt-6 text-center text-gray-400 text-sm"><p>&copy; 2026 FoodRescue. All rights reserved. | Made with 💚 for a sustainable future</p></div>
  </div>
</footer>

<script src="../js/api.js"></script>
<script src="../js/app-refactored.js"></script>
<script>
<?php if (!isset($_SESSION['user_id'])): ?>
$(document).ready(function() {
  $("#addProductLink").click(function(e) { e.preventDefault(); alert("Please login to list surplus food!"); window.location.href = "login.php"; });
});
<?php endif; ?>

// Interactive Cards Animation
(function() {
  const container = document.getElementById('interactive-cards-container');
  if (!container) return;
  
  const cards = [];
  const cardData = [
    { icon: '🍕', title: 'Pizza', value: '15', subtitle: 'available today' },
    { icon: '🥐', title: 'Bakery', value: '23', subtitle: 'fresh items' },
    { icon: '🥗', title: 'Salads', value: '12', subtitle: 'healthy options' },
    { icon: '🍜', title: 'Meals', value: '18', subtitle: 'hot & ready' },
    { icon: '🍰', title: 'Desserts', value: '9', subtitle: 'sweet treats' },
    { icon: '☕', title: 'Drinks', value: '14', subtitle: 'beverages' },
    { icon: '🥪', title: 'Sandwiches', value: '11', subtitle: 'quick bites' },
    { icon: '🍱', title: 'Combos', value: '8', subtitle: 'meal deals' },
    { icon: '🌮', title: 'Wraps', value: '7', subtitle: 'on the go' },
    { icon: '🍝', title: 'Pasta', value: '13', subtitle: 'Italian fare' },
    { icon: '🍔', title: 'Burgers', value: '10', subtitle: 'grill items' },
    { icon: '🥟', title: 'Snacks', value: '16', subtitle: 'light bites' },
    { icon: '🍲', title: 'Soups', value: '6', subtitle: 'warm bowls' },
    { icon: '🍩', title: 'Donuts', value: '20', subtitle: 'glazed fresh' },
    { icon: '🥙', title: 'Kebabs', value: '5', subtitle: 'grilled meat' }
  ];
  
  // Create cards with varied sizes and positions
  cardData.forEach((data, index) => {
    const card = document.createElement('div');
    card.className = 'interactive-card';
    
    // Vary card sizes
    const widths = [120, 110, 130, 115];
    const heights = [100, 95, 110, 105];
    const width = widths[index % widths.length];
    const height = heights[index % heights.length];
    
    card.style.width = width + 'px';
    card.style.height = height + 'px';
    
    // Initial scattered positions in a grid-like pattern
    const cols = 4;
    const rows = Math.ceil(cardData.length / cols);
    const col = index % cols;
    const row = Math.floor(index / cols);
    
    // Add some randomness to positions
    const baseX = col * 130 + Math.random() * 20;
    const baseY = row * 115 + Math.random() * 20;
    
    card.style.left = baseX + 'px';
    card.style.top = baseY + 'px';
    
    // Card content
    card.innerHTML = `
      <div class="card-icon">${data.icon}</div>
      <div class="card-title">${data.title}</div>
      <div class="card-value">${data.value}</div>
      <div class="card-subtitle">${data.subtitle}</div>
    `;
    
    container.appendChild(card);
    
    // Store card data for animations
    cards.push({
      element: card,
      originalX: baseX,
      originalY: baseY,
      currentX: baseX,
      currentY: baseY,
      velocityX: 0,
      velocityY: 0,
      isExploding: false,
      avoidanceRadius: 80
    });
  });
  
  let mouseX = 0;
  let mouseY = 0;
  let isMouseInContainer = false;
  
  // Track mouse position
  container.addEventListener('mousemove', (e) => {
    const rect = container.getBoundingClientRect();
    mouseX = e.clientX - rect.left;
    mouseY = e.clientY - rect.top;
    isMouseInContainer = true;
  });
  
  container.addEventListener('mouseleave', () => {
    isMouseInContainer = false;
  });
  
  // Click to explode
  container.addEventListener('click', (e) => {
    const rect = container.getBoundingClientRect();
    const clickX = e.clientX - rect.left;
    const clickY = e.clientY - rect.top;
    
    cards.forEach(card => {
      const cardCenterX = card.currentX + card.element.offsetWidth / 2;
      const cardCenterY = card.currentY + card.element.offsetHeight / 2;
      
      const dx = cardCenterX - clickX;
      const dy = cardCenterY - clickY;
      const distance = Math.sqrt(dx * dx + dy * dy);
      
      // Explosion force - closer cards get more force
      const force = Math.max(20, 100 / (distance + 10));
      card.velocityX = (dx / distance) * force * (0.5 + Math.random());
      card.velocityY = (dy / distance) * force * (0.5 + Math.random());
      card.isExploding = true;
      
      // Add spin effect
      card.element.style.transition = 'transform 0.3s ease-out';
      card.element.style.transform = `rotate(${Math.random() * 360}deg)`;
    });
  });
  
  // Animation loop
  function animate() {
    cards.forEach(card => {
      if (card.isExploding) {
        // Apply explosion velocity
        card.currentX += card.velocityX;
        card.currentY += card.velocityY;
        
        // Friction/damping
        card.velocityX *= 0.92;
        card.velocityY *= 0.92;
        
        // Spring force back to original position
        const springForce = 0.03;
        card.velocityX += (card.originalX - card.currentX) * springForce;
        card.velocityY += (card.originalY - card.currentY) * springForce;
        
        // Check if settled
        const totalVelocity = Math.abs(card.velocityX) + Math.abs(card.velocityY);
        if (totalVelocity < 0.5) {
          card.isExploding = false;
          card.currentX = card.originalX;
          card.currentY = card.originalY;
          card.element.style.transform = 'rotate(0deg)';
        }
      } else if (isMouseInContainer) {
        // Cursor avoidance effect
        const cardCenterX = card.currentX + card.element.offsetWidth / 2;
        const cardCenterY = card.currentY + card.element.offsetHeight / 2;
        
        const dx = cardCenterX - mouseX;
        const dy = cardCenterY - mouseY;
        const distance = Math.sqrt(dx * dx + dy * dy);
        
        if (distance < card.avoidanceRadius) {
          // Move away from cursor
          const avoidForce = (1 - distance / card.avoidanceRadius) * 2;
          card.velocityX += (dx / distance) * avoidForce;
          card.velocityY += (dy / distance) * avoidForce;
        }
        
        // Always pull back towards original position
        const returnForce = 0.05;
        card.velocityX += (card.originalX - card.currentX) * returnForce;
        card.velocityY += (card.originalY - card.currentY) * returnForce;
        
        // Apply velocity
        card.currentX += card.velocityX;
        card.currentY += card.velocityY;
        
        // Damping
        card.velocityX *= 0.85;
        card.velocityY *= 0.85;
      } else {
        // Return to original position smoothly when mouse leaves
        const returnForce = 0.08;
        card.velocityX += (card.originalX - card.currentX) * returnForce;
        card.velocityY += (card.originalY - card.currentY) * returnForce;
        
        card.currentX += card.velocityX;
        card.currentY += card.velocityY;
        
        card.velocityX *= 0.9;
        card.velocityY *= 0.9;
        
        // Snap to position if close enough
        if (Math.abs(card.currentX - card.originalX) < 1 && 
            Math.abs(card.currentY - card.originalY) < 1) {
          card.currentX = card.originalX;
          card.currentY = card.originalY;
          card.velocityX = 0;
          card.velocityY = 0;
        }
      }
      
      // Update position
      card.element.style.left = card.currentX + 'px';
      card.element.style.top = card.currentY + 'px';
    });
    
    requestAnimationFrame(animate);
  }
  
  // Start animation
  animate();
})();
</script>

<div id="cookieConsentBanner" class="fixed bottom-0 left-0 right-0 bg-white shadow-2xl border-t-4 border-green-600 z-50 hidden">
  <div class="max-w-7xl mx-auto p-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
      <div class="flex items-start space-x-4 flex-1">
        <div class="text-4xl">🍪</div>
        <div><h3 class="text-xl font-bold text-gray-800 mb-2">We Value Your Privacy</h3>
          <p class="text-gray-600 text-sm">We use cookies to enhance your food rescue experience and show you nearby available meals. By clicking "Accept All", you consent to our use of cookies. <a href="#" onclick="CookieConsent.showSettingsModal(); return false;" class="text-green-600 hover:underline font-semibold">Learn more</a></p>
        </div>
      </div>
      <div class="flex flex-wrap gap-3 items-center">
        <button id="customizeCookies" class="px-4 py-2 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:border-green-600 hover:text-green-600 transition whitespace-nowrap"><i class="fas fa-cog mr-2"></i>Customize</button>
        <button id="rejectCookies" class="px-4 py-2 border-2 border-red-500 text-red-500 rounded-lg font-semibold hover:bg-red-500 hover:text-white transition whitespace-nowrap"><i class="fas fa-times mr-2"></i>Reject All</button>
        <button id="acceptCookies" class="px-6 py-2 gradient-bg text-white rounded-lg font-semibold hover:opacity-90 transition whitespace-nowrap"><i class="fas fa-check mr-2"></i>Accept All</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>
