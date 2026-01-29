# 🚀 Quick Reference Card

## API Endpoint
```
http://localhost:8000/api/index.php
```

## Frontend Helper
```javascript
API.call(controller, action, data)
```

---

## 📡 All Available API Calls

### Fetch Products
```javascript
// All products
API.call('product', 'fetch')

// By category
API.call('product', 'fetch', {category: '1'})
```

### Get Single Product
```javascript
API.call('product', 'get', {id: '15'})
```

### Add Product
```javascript
API.call('product', 'add', {
    name: 'Product Name',
    price: '99.99',
    category_id: '1'  // 1=Electronics, 2=Books, 3=Clothing
})
```

### Update Product
```javascript
API.call('product', 'update', {
    id: '15',
    name: 'Updated Name',
    price: '89.99',
    category_id: '2'
})
```

### Delete Product
```javascript
// Requires login!
API.call('product', 'delete', {product_id: '15'})
```

---

## 📂 File Structure

```
/api/
├── index.php                    → Single entry point
├── controllers/
│   ├── BaseController.php       → Base class
│   └── ProductController.php    → Product operations
└── services/
    └── Database.php             → DB singleton

/js/
├── api.js                       → API helper
└── app-refactored.js            → Uses new API
```

---

## 🔧 Quick Commands

### Start Server
```bash
cd /workspaces/Manage-Learners
php -S 0.0.0.0:8000
```

### Test API
```bash
# Fetch products
curl "http://localhost:8000/api/index.php?controller=product&action=fetch"

# Add product
curl -X POST http://localhost:8000/api/index.php \
  -d "controller=product" \
  -d "action=add" \
  -d "name=Test" \
  -d "price=99" \
  -d "category_id=1"
```

### Check Database
```bash
sqlite3 mini_shop.db "SELECT * FROM products LIMIT 5;"
```

---

## 🎯 Response Format

### Success
```json
{
  "success": true,
  "data": { ... }
}
```

### Error
```json
{
  "success": false,
  "error": "Error message"
}
```

---

## 📋 Categories

| ID | Name |
|----|------|
| 1 | Electronics |
| 2 | Books |
| 3 | Clothing |

---

## 🔐 Authentication

- **Login required:** Delete operation only
- **No login:** Fetch, get, add, update operations

---

## 📄 Documentation Files

- `OOP_REFACTORING_GUIDE.md` - Complete refactoring guide
- `ARCHITECTURE.md` - Architecture diagrams and flow
- `TESTING.md` - Comprehensive testing guide
- `QUICK_REFERENCE.md` - This file

---

## ✅ What Changed

| Before | After |
|--------|-------|
| Multiple PHP endpoints | Single `/api/index.php` |
| Mixed responses (HTML/Text) | JSON only |
| Procedural code | OOP with controllers |
| Direct DB access | Database singleton |
| Scattered error handling | Centralized try-catch |

---

## 🚀 Next Steps

1. ✅ Test the application in browser
2. ✅ Verify all features work
3. ✅ Optionally remove old PHP files
4. ✅ Add more controllers as needed

---

## 💡 Tips

- Use browser console to test API calls
- Check Network tab for API responses
- All responses are JSON now
- Old files still exist for reference
- No framework dependencies!

---

## 📞 Need Help?

Check these files:
- **Setup issues:** `OOP_REFACTORING_GUIDE.md`
- **How it works:** `ARCHITECTURE.md`
- **Testing:** `TESTING.md`
