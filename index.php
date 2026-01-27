<!DOCTYPE html>
<html>
<head>
  <title>Product Catalog</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container">
  <h1>🛍️ Product Catalog</h1>
  <div class="nav-actions">
    <a href="admin.php" class="nav-link">Add Products</a>
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
</body>
</html>
