<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodRescue - Fight Food Waste, Feed the Future</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
            color: #10b981;
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
            position: relative;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 100px 20px;
            text-align: center;
            overflow: hidden;
            cursor: pointer;
        }
        
        #hero-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            opacity: 0.3;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero-content a,
        .hero-content button {
            cursor: pointer;
        }
        
        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            animation: fadeInUp 1s ease-out;
            font-weight: bold;
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
            color: #10b981;
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
            font-size: 42px;
            margin-bottom: 20px;
            font-weight: 800;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            padding-bottom: 20px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 2px;
        }
        
        .section-subtitle {
            text-align: center;
            font-size: 18px;
            color: #666;
            margin-bottom: 50px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }
        
        .feature-card {
            text-align: center;
            padding: 40px 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(16, 185, 129, 0.2);
            border-color: #10b981;
        }
        
        .feature-card:hover::before {
            transform: scaleX(1);
        }
        
        .feature-icon {
            font-size: 56px;
            margin-bottom: 25px;
            display: inline-block;
            padding: 20px;
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        .feature-card h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #059669;
            font-weight: 700;
        }
        
        .feature-card p {
            color: #6b7280;
            line-height: 1.8;
            font-size: 15px;
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
            <a href="home.php" class="logo"><i class="fas fa-leaf"></i> FoodRescue</a>
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="index.php">Products</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#categories">Categories</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="admin.php">Admin</a></li>
                    <li><span>Hi, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span></li>
                    <li><a href="../php/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="btn-primary">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="hero-section">
        <canvas id="hero-canvas"></canvas>
        <div class="hero-content">
            <h1>🌍 Fight Food Waste, Feed the Future</h1>
            <p>Join the movement to rescue surplus food and make a positive impact on our planet</p>
            <div class="hero-buttons">
                <a href="index.php" class="btn-large btn-white"><i class="fas fa-utensils mr-2"></i>Rescue Food Now</a>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="signup.php" class="btn-large btn-outline"><i class="fas fa-user-plus mr-2"></i>Join Our Mission</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section" id="features">
        <h2 class="section-title">How FoodRescue Makes a Difference</h2>
        <p class="section-subtitle">Join thousands of people making an impact by rescuing food and reducing waste</p>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🌱</div>
                <h3>Reduce Food Waste</h3>
                <p>Save perfectly good food from going to waste. Every meal rescued is a step towards sustainability.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💰</div>
                <h3>Save Money</h3>
                <p>Get quality food at discounted prices. Help the planet while keeping your wallet happy.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🌍</div>
                <h3>Help the Planet</h3>
                <p>Reduce CO2 emissions and conserve resources. Every rescue counts towards a greener future.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🤝</div>
                <h3>Support Local Businesses</h3>
                <p>Help restaurants and stores sell surplus food instead of wasting it. Win-win for everyone.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3>Quick & Easy</h3>
                <p>Browse, buy, and rescue food in minutes. Simple process, massive impact.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🍽️</div>
                <h3>Fresh Quality Food</h3>
                <p>Surplus doesn't mean bad. Get fresh, delicious food at the end of business day.</p>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="section categories" id="categories">
        <h2 class="section-title">Rescue Food by Category</h2>
        <p class="section-subtitle">Browse surplus food from bakeries, restaurants, and local vendors</p>
        <div class="category-grid">
            <div class="category-card" onclick="window.location.href='index.php?category=1'">
                <div class="category-image">🍞</div>
                <div class="category-content">
                    <h3>Bakery & Desserts</h3>
                    <p>Fresh breads, pastries, cakes and sweet treats</p>
                </div>
            </div>
            <div class="category-card" onclick="window.location.href='index.php?category=2'">
                <div class="category-image">🥗</div>
                <div class="category-content">
                    <h3>Vegetarian Meals</h3>
                    <p>Healthy veggie dishes, salads and plant-based food</p>
                </div>
            </div>
            <div class="category-card" onclick="window.location.href='index.php?category=3'">
                <div class="category-image">🍗</div>
                <div class="category-content">
                    <h3>Non-Veg Meals</h3>
                    <p>Chicken, fish, lamb and protein-rich meals</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="section stats">
        <h2 class="section-title">Our Impact</h2>
        <p class="section-subtitle" style="color: rgba(255,255,255,0.9); margin-bottom: 50px;">Together we're making a real difference in fighting food waste</p>
        <div class="stats-grid">
            <div class="stat-item">
                <h2>50K+</h2>
                <p>Meals Rescued</p>
            </div>
            <div class="stat-item">
                <h2>25 Tons</h2>
                <p>Food Waste Prevented</p>
            </div>
            <div class="stat-item">
                <h2>5K+</h2>
                <p>Happy Rescuers</p>
            </div>
            <div class="stat-item">
                <h2>4.9⭐</h2>
                <p>User Rating</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section cta">
        <h2>Ready to Make a Difference?</h2>
        <p>Join thousands of food rescuers and help fight food waste while saving money!</p>
        <a href="index.php" class="btn-large" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;"><i class="fas fa-leaf mr-2"></i>Start Rescuing Food Now</a>
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
            <p>&copy; 2026 FoodRescue. All rights reserved.</p>
        </div>
    </footer>

    <!-- Three.js Hero Animation -->
    <script>
        // Initialize Three.js scene
        const canvas = document.getElementById('hero-canvas');
        const heroSection = document.getElementById('hero-section');
        
        // Scene setup
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, heroSection.offsetWidth / heroSection.offsetHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ canvas: canvas, alpha: true, antialias: true });
        
        renderer.setSize(heroSection.offsetWidth, heroSection.offsetHeight);
        renderer.setPixelRatio(window.devicePixelRatio);
        camera.position.z = 30;
        
        // Create floating geometric shapes
        const shapes = [];
        const geometries = [
            new THREE.OctahedronGeometry(1.5),
            new THREE.IcosahedronGeometry(1.2),
            new THREE.TetrahedronGeometry(1.8),
            new THREE.BoxGeometry(2, 2, 2),
            new THREE.TorusGeometry(1, 0.4, 16, 100)
        ];
        
        // Material with subtle white/green tones
        const material = new THREE.MeshPhongMaterial({
            color: 0xffffff,
            shininess: 100,
            transparent: true,
            opacity: 0.7,
            wireframe: false
        });
        
        // Create multiple floating shapes
        for (let i = 0; i < 15; i++) {
            const geometry = geometries[Math.floor(Math.random() * geometries.length)];
            const mesh = new THREE.Mesh(geometry, material.clone());
            
            // Random positions
            mesh.position.x = (Math.random() - 0.5) * 60;
            mesh.position.y = (Math.random() - 0.5) * 40;
            mesh.position.z = (Math.random() - 0.5) * 40;
            
            // Store original positions for distortion effect
            mesh.originalPosition = {
                x: mesh.position.x,
                y: mesh.position.y,
                z: mesh.position.z
            };
            
            // Random rotation speeds
            mesh.rotationSpeed = {
                x: (Math.random() - 0.5) * 0.01,
                y: (Math.random() - 0.5) * 0.01,
                z: (Math.random() - 0.5) * 0.01
            };
            
            // Random floating animation
            mesh.floatSpeed = Math.random() * 0.02 + 0.01;
            mesh.floatAmplitude = Math.random() * 2 + 1;
            mesh.floatOffset = Math.random() * Math.PI * 2;
            
            // Distortion properties
            mesh.isDistorted = false;
            mesh.distortionVelocity = { x: 0, y: 0, z: 0 };
            
            shapes.push(mesh);
            scene.add(mesh);
        }
        
        // Lighting
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
        scene.add(ambientLight);
        
        const pointLight1 = new THREE.PointLight(0xffffff, 1, 100);
        pointLight1.position.set(20, 20, 20);
        scene.add(pointLight1);
        
        const pointLight2 = new THREE.PointLight(0x10b981, 0.8, 100);
        pointLight2.position.set(-20, -20, 10);
        scene.add(pointLight2);
        
        // Mouse interaction
        let mouseX = 0;
        let mouseY = 0;
        
        document.addEventListener('mousemove', (event) => {
            mouseX = (event.clientX / window.innerWidth) * 2 - 1;
            mouseY = -(event.clientY / window.innerHeight) * 2 + 1;
        });
        
        // Click distortion effect
        heroSection.addEventListener('click', (event) => {
            // Don't trigger if clicking on buttons or links
            if (event.target.tagName === 'A' || event.target.tagName === 'BUTTON' || 
                event.target.closest('a') || event.target.closest('button')) {
                return;
            }
            
            // Get click position in 3D space
            const rect = heroSection.getBoundingClientRect();
            const clickX = ((event.clientX - rect.left) / rect.width) * 2 - 1;
            const clickY = -((event.clientY - rect.top) / rect.height) * 2 + 1;
            
            // Apply distortion to all shapes
            shapes.forEach((shape, index) => {
                shape.isDistorted = true;
                
                // Calculate direction from click point
                const dx = shape.position.x - clickX * 30;
                const dy = shape.position.y - clickY * 30;
                const distance = Math.sqrt(dx * dx + dy * dy);
                
                // Create explosion effect - shapes fly away from click point
                const force = 15 / (distance + 1); // Closer shapes get more force
                shape.distortionVelocity.x = (dx / distance) * force + (Math.random() - 0.5) * 5;
                shape.distortionVelocity.y = (dy / distance) * force + (Math.random() - 0.5) * 5;
                shape.distortionVelocity.z = (Math.random() - 0.5) * 10;
                
                // Increase rotation speed during distortion
                shape.rotationSpeed.x *= 3;
                shape.rotationSpeed.y *= 3;
                shape.rotationSpeed.z *= 3;
            });
        });
        
        // Animation loop
        let time = 0;
        function animate() {
            requestAnimationFrame(animate);
            time += 0.01;
            
            // Animate each shape
            shapes.forEach((shape, index) => {
                if (shape.isDistorted) {
                    // Apply distortion velocity
                    shape.position.x += shape.distortionVelocity.x;
                    shape.position.y += shape.distortionVelocity.y;
                    shape.position.z += shape.distortionVelocity.z;
                    
                    // Dampen velocity (friction)
                    shape.distortionVelocity.x *= 0.95;
                    shape.distortionVelocity.y *= 0.95;
                    shape.distortionVelocity.z *= 0.95;
                    
                    // Pull back to original position (spring effect)
                    const returnForce = 0.02;
                    shape.distortionVelocity.x += (shape.originalPosition.x - shape.position.x) * returnForce;
                    shape.distortionVelocity.y += (shape.originalPosition.y - shape.position.y) * returnForce;
                    shape.distortionVelocity.z += (shape.originalPosition.z - shape.position.z) * returnForce;
                    
                    // Gradually restore rotation speed
                    shape.rotationSpeed.x *= 0.98;
                    shape.rotationSpeed.y *= 0.98;
                    shape.rotationSpeed.z *= 0.98;
                    
                    // Check if settled back
                    const totalVelocity = Math.abs(shape.distortionVelocity.x) + 
                                        Math.abs(shape.distortionVelocity.y) + 
                                        Math.abs(shape.distortionVelocity.z);
                    if (totalVelocity < 0.1) {
                        shape.isDistorted = false;
                        // Restore original rotation speed
                        shape.rotationSpeed.x = (Math.random() - 0.5) * 0.01;
                        shape.rotationSpeed.y = (Math.random() - 0.5) * 0.01;
                        shape.rotationSpeed.z = (Math.random() - 0.5) * 0.01;
                    }
                } else {
                    // Normal floating motion
                    shape.position.y += Math.sin(time * shape.floatSpeed + shape.floatOffset) * 0.05;
                    
                    // Parallax effect
                    shape.position.x += (mouseX * 3 - shape.position.x + shape.originalPosition.x) * 0.01;
                    shape.position.y += (mouseY * 3 - shape.position.y + shape.originalPosition.y) * 0.01;
                }
                
                // Rotation (always active)
                shape.rotation.x += shape.rotationSpeed.x;
                shape.rotation.y += shape.rotationSpeed.y;
                shape.rotation.z += shape.rotationSpeed.z;
                
                // Keep shapes within bounds
                if (Math.abs(shape.position.x) > 60) {
                    shape.position.x *= 0.9;
                }
                if (Math.abs(shape.position.y) > 50) {
                    shape.position.y *= 0.9;
                }
            });
            
            // Slight camera movement
            camera.position.x = mouseX * 2;
            camera.position.y = mouseY * 2;
            camera.lookAt(scene.position);
            
            renderer.render(scene, camera);
        }
        
        // Handle window resize
        window.addEventListener('resize', () => {
            camera.aspect = heroSection.offsetWidth / heroSection.offsetHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(heroSection.offsetWidth, heroSection.offsetHeight);
        });
        
        // Start animation
        animate();
    </script>

</body>
</html>
