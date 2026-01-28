<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Product Catalog</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
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
      display: inline-block;
    }
    .logout-btn:hover {
      opacity: 0.9;
    }
  </style>
</head>
<body>

<div class="container">
  <h1>🛍️ Product Catalog</h1>
  <div class="nav-actions">
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="admin.php" class="nav-link">Add Products</a>
      <span class="user-info">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
      <a href="php/logout.php" class="logout-btn">Logout</a>
    <?php else: ?>
      <a href="#" id="addProductLink" class="nav-link">Add Products</a>
      <a href="login.php" class="nav-link">Login</a>
    <?php endif; ?>
  </div>

  <label for="category">Filter by Category:</label>
  <select id="category">
    <option value="">All Products</option>
    <option value="1">Electronics</option>
    <option value="2">Books</option>
    <option value="3">Clothing</option>
  </select>

  <div id="loader" style="display:none;">Loading...</div>
  <div id="products"></div>
</div>

<script src="js/app.js"></script>

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

  //prevent non-logged-in users from deleting the products
  <?php if(!isset($_SESSION['user_id'])) : ?>
  $(document).ready(function() {
    $(".delete-product".click(function(e) {
      e.preventDefault();
      alert("Please Login before deleting the products !");
      window.location.href = "login.php";
    }));
  });

  <?php endif; ?>

</script>
</body>
</html>
