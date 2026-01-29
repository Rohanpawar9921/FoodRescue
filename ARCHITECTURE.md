# Architecture Comparison

## 🔴 OLD Architecture (Before Refactoring)

```
Frontend (index.php, admin.php, edit.php)
    ↓
Multiple AJAX endpoints:
├── php/fetch_products.php    → Returns HTML string
├── php/add_product.php        → Returns plain text
├── php/delete_product.php     → Returns plain text
├── php/get_product.php        → Returns JSON
├── php/update_product.php     → Returns plain text
└── Each includes php/db.php directly
```

**Issues:**
- Multiple endpoints scattered across php/ folder
- Inconsistent response formats (HTML, text, JSON)
- Procedural code with no structure
- Each file creates its own DB connection
- No centralized error handling
- Hard to maintain and scale

---

## 🟢 NEW Architecture (After Refactoring)

```
Frontend (Browser)
    ↓
    JavaScript: js/api.js
    ↓
    ┌────────────────────────────────────┐
    │  Single Entry Point                │
    │  /api/index.php                    │
    │  - Routes requests                 │
    │  - Handles errors                  │
    │  - Returns JSON only               │
    └────────────────────────────────────┘
              ↓
    ┌────────────────────────────────────┐
    │  Controller Layer                  │
    │  /api/controllers/                 │
    │  ├── BaseController.php            │
    │  │   - requireLogin()              │
    │  │   - validateRequired()          │
    │  │   - getRequestData()            │
    │  │                                 │
    │  └── ProductController.php         │
    │      - fetch()                     │
    │      - get()                       │
    │      - add()                       │
    │      - update()                    │
    │      - delete()                    │
    └────────────────────────────────────┘
              ↓
    ┌────────────────────────────────────┐
    │  Service Layer                     │
    │  /api/services/                    │
    │  └── Database.php (Singleton)      │
    │      - Single PDO instance         │
    │      - Reused across all requests  │
    └────────────────────────────────────┘
              ↓
         SQLite Database
         (mini_shop.db)
```

**Benefits:**
✅ Single API entry point
✅ Consistent JSON responses
✅ OOP structure
✅ Reusable base controller
✅ Database singleton pattern
✅ Centralized error handling
✅ Easy to extend and maintain

---

## 📡 API Request Flow Example

### Fetching Products

```javascript
// Frontend Call
API.call('product', 'fetch', {category: '1'})
```

**Step-by-step:**

1. **api.js** sends POST request to `/api/index.php`
   ```
   POST /api/index.php
   Data: {controller: 'product', action: 'fetch', category: '1'}
   ```

2. **api/index.php** receives request
   - Validates controller and action exist
   - Instantiates `ProductController`
   - Calls `fetch()` method

3. **ProductController::fetch()** executes
   - Gets request data
   - Checks Redis cache (if available)
   - Queries database via Database service
   - Returns array of products

4. **api/index.php** wraps response
   ```json
   {
     "success": true,
     "data": [
       {"id": 1, "name": "iPhone", "price": "999.99", ...},
       ...
     ]
   }
   ```

5. **Frontend** receives JSON
   - Parses response
   - Builds HTML dynamically
   - Updates DOM

---

## 🔄 Request/Response Examples

### ✅ SUCCESS Response

```json
{
  "success": true,
  "data": {
    "message": "Product Added Successfully",
    "product_id": 42
  }
}
```

### ❌ ERROR Response

```json
{
  "success": false,
  "error": "You must be logged in to perform this action"
}
```

---

## 🎯 Controller → Action Mapping

| Controller | Action | Method | Auth Required |
|-----------|--------|--------|---------------|
| product | fetch | GET/POST | No |
| product | get | GET/POST | No |
| product | add | POST | No |
| product | update | POST | No |
| product | delete | POST | **Yes** |

---

## 📂 File Structure

```
/workspaces/Manage-Learners/
│
├── api/                           ← NEW: OOP Backend
│   ├── index.php                  ← Single entry point
│   ├── controllers/
│   │   ├── BaseController.php     ← Base class
│   │   └── ProductController.php  ← Product operations
│   └── services/
│       └── Database.php           ← DB singleton
│
├── js/
│   ├── api.js                     ← NEW: API helper
│   ├── app-refactored.js          ← NEW: Uses OOP API
│   └── app.js                     ← OLD: Still exists
│
├── php/                           ← OLD: Procedural endpoints
│   ├── fetch_products.php         ← Can be removed
│   ├── add_product.php            ← Can be removed
│   ├── delete_product.php         ← Can be removed
│   ├── get_product.php            ← Can be removed
│   ├── update_product.php         ← Can be removed
│   ├── db.php                     ← Keep for now
│   ├── auth_check.php             ← Keep
│   ├── login.php                  ← Keep
│   ├── signup.php                 ← Keep
│   └── logout.php                 ← Keep
│
├── index.php                      ← UPDATED: Uses new API
├── admin.php                      ← UPDATED: Uses new API
├── edit.php                       ← UPDATED: Uses new API
├── home.php
├── login.php
└── signup.php
```

---

## 🚀 How to Extend

### Adding a New Controller

**Step 1:** Create controller file
```php
// api/controllers/CategoryController.php
<?php
class CategoryController extends BaseController {
    public function list() {
        $sql = "SELECT * FROM categories";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
```

**Step 2:** Call from frontend
```javascript
API.call('category', 'list')
    .then(categories => {
        console.log(categories);
    });
```

**That's it!** No routing configuration needed.

---

## 💡 Key Concepts

### Singleton Pattern (Database)
```php
// Only one database connection for entire application
$db1 = Database::getInstance();
$db2 = Database::getInstance();
// $db1 === $db2 (same instance)
```

### Controller Base Class
```php
// All controllers inherit common functionality
class ProductController extends BaseController {
    // Automatic access to:
    // - $this->db (database)
    // - $this->requireLogin()
    // - $this->validateRequired()
    // - $this->getRequestData()
}
```

### Automatic Routing
```php
// api/index.php automatically routes to correct controller/action
// No need to define routes manually
$controllerName = ucfirst($controller) . 'Controller';
$controllerInstance = new $controllerName();
$result = $controllerInstance->$action();
```

---

## 📊 Performance & Caching

The refactored code **maintains Redis caching** from the original:

```php
// In ProductController::fetch()
try {
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    $cacheKey = "products:category:{$category}:logged:{$isLoggedIn}";
    
    $cachedData = $redis->get($cacheKey);
    if($cachedData !== false) {
        return json_decode($cachedData, true);
    }
    
    // ... fetch from database ...
    
    $redis->setex($cacheKey, 3600, json_encode($products));
} catch (Error $e) {
    // Continue without cache if Redis unavailable
}
```

Cache is automatically cleared on add/update/delete operations.
