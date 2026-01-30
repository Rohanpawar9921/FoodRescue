<?php
include "db.php";

try {
    // Drop existing users table
    $conn->exec("DROP TABLE IF EXISTS users");
    echo "Old users table dropped!<br>";
    
    // Create new users table with email
    $conn->exec("CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT, 
                username TEXT NOT NULL UNIQUE,
                email TEXT UNIQUE,
                password TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");
    
    echo "New users table created with email column!<br>";
    
    // Create default admin user
    $username = "admin";
    $password = password_hash("admin123", PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);
    
    echo "Default admin user created!<br>";
    echo "Username: admin<br>";
    echo "Password: admin123<br>";
    echo "<br><a href='../signup.php'>Go to signup</a>";
    
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>