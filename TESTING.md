# Testing Guide for Refactored OOP API

## 🧪 Quick Test Checklist

### Prerequisites
```bash
# Start PHP server
cd /workspaces/Manage-Learners
php -S 0.0.0.0:8000
```

### ✅ Test 1: Fetch All Products
```bash
curl -s "http://localhost:8000/api/index.php?controller=product&action=fetch" | jq
```

**Expected Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "iPhone 15 Pro",
      "price": "999.99",
      "category_name": "Electronics",
      "category_id": 1,
      "is_logged_in": false
    },
    ...
  ]
}
```

### ✅ Test 2: Fetch Products by Category
```bash
# Electronics (category 1)
curl -s "http://localhost:8000/api/index.php?controller=product&action=fetch&category=1" | jq

# Books (category 2)
curl -s "http://localhost:8000/api/index.php?controller=product&action=fetch&category=2" | jq

# Clothing (category 3)
curl -s "http://localhost:8000/api/index.php?controller=product&action=fetch&category=3" | jq
```

### ✅ Test 3: Get Single Product
```bash
curl -s "http://localhost:8000/api/index.php?controller=product&action=get&id=15" | jq
```

**Expected Response:**
```json
{
  "success": true,
  "data": {
    "id": 15,
    "name": "iPhone 15 Pro",
    "price": 999.99,
    "category_id": 1
  }
}
```

### ✅ Test 4: Add New Product
```bash
curl -X POST "http://localhost:8000/api/index.php" \
  -d "controller=product" \
  -d "action=add" \
  -d "name=Test Laptop" \
  -d "price=1299.99" \
  -d "category_id=1" | jq
```

**Expected Response:**
```json
{
  "success": true,
  "data": {
    "message": "Product Added Successfully",
    "product_id": 42
  }
}
```

### ✅ Test 5: Update Product
```bash
curl -X POST "http://localhost:8000/api/index.php" \
  -d "controller=product" \
  -d "action=update" \
  -d "id=42" \
  -d "name=Updated Laptop" \
  -d "price=1199.99" \
  -d "category_id=1" | jq
```

**Expected Response:**
```json
{
  "success": true,
  "data": {
    "message": "Product Updated Successfully"
  }
}
```

### ✅ Test 6: Delete Product (Requires Login)
```bash
# This will fail if not logged in
curl -X POST "http://localhost:8000/api/index.php" \
  -d "controller=product" \
  -d "action=delete" \
  -d "product_id=42" | jq
```

**Expected Response (Not Logged In):**
```json
{
  "success": false,
  "error": "You must be logged in to perform this action"
}
```

---

## 🌐 Browser Testing

### Test Frontend Integration

1. **Open Catalog Page**
   ```
   http://localhost:8000/index.php
   ```
   - ✅ Products should load
   - ✅ Filter by category should work
   - ✅ Edit/Delete buttons visible only when logged in

2. **Test Add Product**
   ```
   http://localhost:8000/admin.php
   ```
   - ✅ Login first if not authenticated
   - ✅ Fill form and submit
   - ✅ Success message should appear
   - ✅ Form should reset after submission

3. **Test Edit Product**
   - ✅ Click "Edit" button on any product
   - ✅ Product data should load
   - ✅ Update fields and submit
   - ✅ Success message and redirect to catalog

4. **Test Delete Product**
   - ✅ Click "Delete" button
   - ✅ Confirm dialog appears
   - ✅ Product is removed from list
   - ✅ Success message appears

---

## 🔍 Browser Console Testing

Open browser console (F12) and run:

```javascript
// Test fetch all products
API.call('product', 'fetch')
    .then(products => console.log('Products:', products))
    .catch(error => console.error('Error:', error));

// Test fetch by category
API.call('product', 'fetch', {category: '1'})
    .then(products => console.log('Electronics:', products))
    .catch(error => console.error('Error:', error));

// Test get single product
API.call('product', 'get', {id: '15'})
    .then(product => console.log('Product:', product))
    .catch(error => console.error('Error:', error));

// Test add product
API.call('product', 'add', {
    name: 'Console Test Product',
    price: '99.99',
    category_id: '1'
})
    .then(result => console.log('Added:', result))
    .catch(error => console.error('Error:', error));

// Test update product
API.call('product', 'update', {
    id: '15',
    name: 'Updated Name',
    price: '899.99',
    category_id: '1'
})
    .then(result => console.log('Updated:', result))
    .catch(error => console.error('Error:', error));

// Test delete product (will fail if not logged in)
API.call('product', 'delete', {product_id: '42'})
    .then(result => console.log('Deleted:', result))
    .catch(error => console.error('Error:', error));
```

---

## 🐛 Error Testing

### Test Invalid Controller
```bash
curl -s "http://localhost:8000/api/index.php?controller=invalid&action=fetch" | jq
```

**Expected:**
```json
{
  "success": false,
  "error": "Controller not found"
}
```

### Test Invalid Action
```bash
curl -s "http://localhost:8000/api/index.php?controller=product&action=invalid" | jq
```

**Expected:**
```json
{
  "success": false,
  "error": "Action not found"
}
```

### Test Missing Parameters
```bash
curl -X POST "http://localhost:8000/api/index.php" \
  -d "controller=product" \
  -d "action=add" \
  -d "name=Test" | jq
```

**Expected:**
```json
{
  "success": false,
  "error": "Field 'price' is required"
}
```

### Test Product Not Found
```bash
curl -s "http://localhost:8000/api/index.php?controller=product&action=get&id=99999" | jq
```

**Expected:**
```json
{
  "success": false,
  "error": "Product not found"
}
```

---

## 📊 Database Verification

### Check Products Added
```bash
sqlite3 mini_shop.db "SELECT * FROM products ORDER BY id DESC LIMIT 5;"
```

### Check All Categories
```bash
sqlite3 mini_shop.db "SELECT * FROM categories;"
```

### Count Products by Category
```bash
sqlite3 mini_shop.db "
SELECT 
    c.name as category,
    COUNT(p.id) as product_count
FROM categories c
LEFT JOIN products p ON c.id = p.category_id
GROUP BY c.id, c.name;"
```

---

## 🔐 Authentication Testing

### Test Protected Routes

1. **Without Login:**
   ```bash
   curl -X POST "http://localhost:8000/api/index.php" \
     -d "controller=product" \
     -d "action=delete" \
     -d "product_id=1" | jq
   ```
   Should return: `"You must be logged in to perform this action"`

2. **With Login:**
   - Login via browser at `http://localhost:8000/login.php`
   - Open browser console
   - Run: `API.call('product', 'delete', {product_id: 1})`
   - Should work (if product exists)

---

## ⚡ Performance Testing

### Test Response Times
```bash
# Fetch products 10 times and measure time
for i in {1..10}; do
  time curl -s "http://localhost:8000/api/index.php?controller=product&action=fetch" > /dev/null
done
```

### Test with Redis Cache

If Redis is available:

```bash
# First request (no cache)
time curl -s "http://localhost:8000/api/index.php?controller=product&action=fetch&category=1" > /dev/null

# Second request (cached)
time curl -s "http://localhost:8000/api/index.php?controller=product&action=fetch&category=1" > /dev/null
```

The second request should be significantly faster!

---

## 📱 Mobile/Responsive Testing

Test on different screen sizes:
- Desktop: 1920x1080
- Tablet: 768x1024
- Mobile: 375x667

All features should work on all screen sizes.

---

## ✅ Complete Test Script

Run this comprehensive test:

```bash
#!/bin/bash

API_URL="http://localhost:8000/api/index.php"

echo "🧪 Testing Refactored OOP API"
echo "=============================="

# Test 1: Fetch all products
echo ""
echo "✅ Test 1: Fetch all products"
curl -s "$API_URL?controller=product&action=fetch" | jq -r '.success'

# Test 2: Fetch by category
echo ""
echo "✅ Test 2: Fetch by category"
curl -s "$API_URL?controller=product&action=fetch&category=1" | jq -r '.success'

# Test 3: Get single product
echo ""
echo "✅ Test 3: Get single product"
curl -s "$API_URL?controller=product&action=get&id=15" | jq -r '.success'

# Test 4: Add product
echo ""
echo "✅ Test 4: Add product"
curl -X POST "$API_URL" \
  -d "controller=product" \
  -d "action=add" \
  -d "name=Test Product" \
  -d "price=99.99" \
  -d "category_id=1" | jq -r '.success'

# Test 5: Error handling
echo ""
echo "✅ Test 5: Invalid controller"
curl -s "$API_URL?controller=invalid&action=fetch" | jq -r '.success'

echo ""
echo "=============================="
echo "✅ All tests completed!"
```

Save as `test-api.sh`, make executable, and run:
```bash
chmod +x test-api.sh
./test-api.sh
```

---

## 🎯 Expected Results Summary

| Test | Expected Result |
|------|----------------|
| Fetch all products | ✅ Returns array of products |
| Fetch by category | ✅ Returns filtered products |
| Get single product | ✅ Returns product object |
| Add product | ✅ Product created, ID returned |
| Update product | ✅ Product updated |
| Delete product (logged out) | ❌ Error: Must be logged in |
| Delete product (logged in) | ✅ Product deleted |
| Invalid controller | ❌ Error: Controller not found |
| Invalid action | ❌ Error: Action not found |
| Missing required field | ❌ Error: Field required |

---

## 📝 Troubleshooting

### Issue: API returns "Controller not found"
**Solution:** Check autoloader in `/api/index.php` and verify file names match class names.

### Issue: Database error
**Solution:** Verify database path in `/api/services/Database.php` and ensure `mini_shop.db` exists.

### Issue: CORS errors in browser
**Solution:** Not needed for same-origin requests. If testing from different domain, add CORS headers to `/api/index.php`.

### Issue: Session issues
**Solution:** Ensure `session_start()` is called at the top of `/api/index.php`.

---

## 🚀 Ready to Deploy

Once all tests pass:

1. ✅ All endpoints return correct JSON
2. ✅ Error handling works properly
3. ✅ Authentication checks work
4. ✅ Browser UI functions correctly
5. ✅ No JavaScript console errors

You're ready to:
- Remove old PHP files (optional)
- Deploy to production
- Add more features using the same pattern
