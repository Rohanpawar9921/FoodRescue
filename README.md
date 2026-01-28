# Manage-Learners

A simple product catalog management system built with vanilla PHP, jQuery, and SQLite. This application allows users to browse products by category and manage the catalog through an admin interface.

## Features

- 📦 Browse product catalog with category filtering
- ➕ Add new products through admin panel
- ✏️ Edit and update existing products
- 🗑️ Delete products from the catalog
- 📱 Responsive design with purple gradient theme
- 💾 SQLite database for lightweight data persistence
- ⚡ AJAX-powered interface for smooth interactions

## Tech Stack

- **Backend:** PHP (vanilla, no framework)
- **Frontend:** jQuery, HTML, CSS
- **Database:** SQLite
- **Server:** Built-in PHP development server

## Prerequisites

- PHP 7.0 or higher
- SQLite3
- Git (optional)

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Rohanpawar99/Manage-Learners.git
   cd Manage-Learners
   ```

2. **Verify the database exists:**
   ```bash
   sqlite3 mini_shop.db ".tables"
   ```
   If the database doesn't exist, it will be created automatically on first use.

## Starting the Application

### Option 1: Using PHP Built-in Server (Recommended for Development)

1. Navigate to the project directory:
   ```bash
   cd /workspaces/Manage-Learners
   ```

2. Start the PHP development server:
   ```bash
   php -S 0.0.0.0:8000 -t /workspaces/Manage-Learners
   ```

3. Open your browser and navigate to:
   ```
   http://localhost:8000
   ```

### Option 2: Using Apache/Nginx

1. Configure your web server to point to the `/workspaces/Manage-Learners` directory as the document root.

2. Access the application through your configured domain/URL.

## Usage

### Viewing Products

1. Visit the **Home** page (`http://localhost:8000/index.php`)
2. Browse all products or filter by category:
   - Electronics
   - Books
   - Clothing
3. Products are displayed in a responsive grid layout

### Managing Products (Admin Panel)

1. Click the **Add Product** link to open the admin panel (`admin.php`)

2. **To Add a Product:**
   - Enter product name (required)
   - Enter product price (required)
   - Select a category
   - Click "Add Product" button

3. **To Edit a Product:**
   - Click the **Edit** button on any product (feature in development)
   - Modify product details
   - Save changes

4. **To Delete a Product:**
   - Click the **Delete** button on any product
   - Product will be removed from the catalog

## Project Structure

```
Manage-Learners/
├── index.php              # Main product catalog page
├── admin.php              # Admin panel for adding products
├── edit.php               # Edit product page
├── mini_shop.db           # SQLite database
├── css/
│   └── style.css          # Styling with purple gradient theme
├── js/
│   └── app.js             # jQuery event handlers
└── php/
    ├── db.php             # Database connection
    ├── fetch_products.php # Fetch products from database
    ├── add_product.php    # Add new product
    ├── get_product.php    # Get single product details
    ├── delete_product.php # Delete product
    └── update_product.php # Update product details
```

## Database Schema

### Tables

**products**
- `id` - Primary key (auto-increment)
- `name` - Product name
- `price` - Product price
- `category_id` - Foreign key to categories table

**categories**
- `id` - Primary key
- `name` - Category name

### Hardcoded Categories
- 1 - Electronics
- 2 - Books
- 3 - Clothing

## Troubleshooting

### Database Connection Issues
- Ensure SQLite3 is installed: `sqlite3 --version`
- Check database file permissions: `ls -la mini_shop.db`
- Verify `php/db.php` path is correct

### Port Already in Use
If port 8000 is already in use, specify a different port:
```bash
php -S 0.0.0.0:8080 -t /workspaces/Manage-Learners
```

### Products Not Loading
1. Check browser console for errors (F12 → Console)
2. Verify database has sample data: `sqlite3 mini_shop.db "SELECT * FROM products;"`
3. Check PHP error log for database errors

## Development Notes

- **No build step required** - directly edit files and refresh browser
- **AJAX-powered** - product operations use jQuery AJAX calls
- **Prepared statements** - all database queries use parameterized statements for security
- **Responsive grid** - CSS Grid layout adapts to different screen sizes

## Future Enhancements

- [ ] Complete edit functionality (currently stubbed)
- [ ] Input validation on backend
- [ ] User authentication for admin panel
- [ ] Product search functionality
- [ ] Category management
- [ ] Product images support
- [ ] Unit tests

## Contributing

Feel free to fork this repository and submit pull requests for any improvements.

## License

This project is open source and available under the MIT License.

## Support

For issues or questions, please open an issue on the GitHub repository.
