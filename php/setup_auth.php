<?php
include "db.php";

try {
    // Create users table with email field
    $conn->exec("CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT, 
                username TEXT NOT NULL UNIQUE,
                email TEXT UNIQUE,
                password TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");
    
    echo "Users table created successfully!<br>";

    // Create default admin user
    $username = "admin";
    $password = password_hash("admin123", PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT OR IGNORE INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);

    echo "Default user created successfully!<br>";
    echo "Username: admin<br>";
    echo "Password: admin123<br>";
    echo "<br><a href='../login.php'>Go to login</a>";
    echo "<br><a href='../signup.php'>Go to signup</a>";
} catch(PDOException $e) {
    die("Setup failed: " . $e->getMessage());
}
?>