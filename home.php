<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopHub - Modern E-Commerce Platform</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        
        /* Navigation */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 28px;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }
        
        .nav-links {
            display: flex;
            gap: 30px;
            list-style: none;
            align-items: center;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s;
        }
        
        .nav-links a:hover {
            opacity: 0.8;
        }
        
        .btn-primary {
            background: white;
            color: #667eea;
            padding: 10px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.3s;
        }
        
        .btn-primary:hover {
            transform: scale(1.05);
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 20px;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            animation: fadeInUp 1s;
        }
        
        .hero p {
            font-size: 20px;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        
        .hero-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-large {
            padding: 15px 40px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
            transition: transform 0.3s;
            display: inline-block;
        }
        
        .btn-white {
            background: white;
            color: #667eea;
        }
        
        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .btn-large:hover {
            transform: scale(1.05);
        }
        
        /* Features Section */
        .section {
            padding: 80px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .section-title {
            text-align: center;
            font-size: 36px;
            margin-bottom: 50px;
            color: #333;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }
        
        .feature-card {
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            font-size: 50px;
            margin-bottom: 20px;
        }
        
        .feature-card h3 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #667eea;
        }
        
        .feature-card p {
            color: #666;
            line-height: 1.8;
        }
        
        /* Categories Section */
        .categories {
            background: #f8f9fa;
        }
        
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .category-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            cursor: pointer;
        }
        
        .category-card:hover {
            transform: scale(1.05);
        }
        
        .category-image {
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 80px;
        }
        
        .category-content {
            padding: 25px;
            text-align: center;
        }
        
        .category-content h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }
        
        .category-content p {
            color: #666;
        }
        
        /* Stats Section */
        .stats {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            text-align: center;
        }
        
        .stat-item h2 {
            font-size: 48px;
            margin-bottom: 10px;
        }
        
        .stat-item p {
            font-size: 18px;
            opacity: 0.9;
        }
        
        /* CTA Section */
        .cta {
            background: #f8f9fa;
            text-align: center;
        }
        
        .cta h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }
        
        .cta p {
            font-size: 18px;
            margin-bottom: 30px;
            color: #666;
        }
        
        /* Footer */
        .footer {
            background: #2c3e50;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .footer-links a {
            color: white;
            text-decoration: none;
            opacity: 0.8;
            transition: opacity 0.3s;
        }
        
        .footer-links a:hover {
            opacity: 1;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 32px;
            }
            
            .nav-links {
                gap: 15px;
                font-size: 14px;
            }
            
            .section-title {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="home.php" class="logo">🛍️ ShopHub</a>
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="index.php">Products</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#categories">Categories</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="admin.php">Admin</a></li>
                    <li><span>Hi, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span></li>
                    <li><a href="php/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="btn-primary">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Welcome to ShopHub</h1>
        <p>Your one-stop destination for all your shopping needs</p>
        <div class="hero-buttons">
            <a href="index.php" class="btn-large btn-white">Browse Products</a>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="signup.php" class="btn-large btn-outline">Sign Up Free</a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section" id="features">
        <h2 class="section-title">Why Choose ShopHub?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🚚</div>
                <h3>Fast Delivery</h3>
                <p>Get your products delivered to your doorstep within 24-48 hours across the country.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <h3>Secure Payments</h3>
                <p>Shop with confidence using our secure payment gateway and encryption technology.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💯</div>
                <h3>Quality Guaranteed</h3>
                <p>Every product is carefully vetted to ensure the highest quality standards.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎁</div>
                <h3>Great Deals</h3>
                <p>Enjoy exclusive discounts, seasonal offers, and special promotions regularly.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📞</div>
                <h3>24/7 Support</h3>
                <p>Our customer support team is always ready to help you with any queries.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">↩️</div>
                <h3>Easy Returns</h3>
                <p>Not satisfied? Return products hassle-free within 30 days of purchase.</p>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="section categories" id="categories">
        <h2 class="section-title">Shop by Category</h2>
        <div class="category-grid">
            <div class="category-card" onclick="window.location.href='index.php?category=1'">
                <div class="category-image">📱</div>
                <div class="category-content">
                    <h3>Electronics</h3>
                    <p>Latest gadgets, phones, laptops and more</p>
                </div>
            </div>
            <div class="category-card" onclick="window.location.href='index.php?category=2'">
                <div class="category-image">📚</div>
                <div class="category-content">
                    <h3>Books</h3>
                    <p>Bestsellers, textbooks, novels and magazines</p>
                </div>
            </div>
            <div class="category-card" onclick="window.location.href='index.php?category=3'">
                <div class="category-image">👔</div>
                <div class="category-content">
                    <h3>Clothing</h3>
                    <p>Fashion trends, apparel and accessories</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="section stats">
        <h2 class="section-title">Our Success Story</h2>
        <div class="stats-grid">
            <div class="stat-item">
                <h2>10K+</h2>
                <p>Happy Customers</p>
            </div>
            <div class="stat-item">
                <h2>500+</h2>
                <p>Products Available</p>
            </div>
            <div class="stat-item">
                <h2>50+</h2>
                <p>Brands</p>
            </div>
            <div class="stat-item">
                <h2>4.8⭐</h2>
                <p>Average Rating</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section cta">
        <h2>Ready to Start Shopping?</h2>
        <p>Join thousands of satisfied customers and discover amazing products today!</p>
        <a href="index.php" class="btn-large" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">Start Shopping Now</a>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-links">
                <a href="#about">About Us</a>
                <a href="#contact">Contact</a>
                <a href="#privacy">Privacy Policy</a>
                <a href="#terms">Terms of Service</a>
                <a href="#help">Help Center</a>
            </div>
            <p>&copy; 2026 ShopHub. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
