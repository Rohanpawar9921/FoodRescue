<?php
session_start();
include "db.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    
    // Server-side validation
    if (empty($username) || empty($password) || empty($confirmPassword)) {
        die("All required fields must be filled");
    }
    
    if (strlen($username) < 3) {
        die("Username must be at least 3 characters long");
    }
    
    if (strlen($password) < 6) {
        die("Password must be at least 6 characters long");
    }
    
    if ($password !== $confirmPassword) {
        die("Passwords do not match");
    }
    
    // Validate email if provided
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }
    
    try {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($stmt->fetch()) {
            die("Username already exists. Please choose a different username.");
        }
        
        // Check if email already exists (if provided)
        if (!empty($email)) {
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                die("Email already registered. Please use a different email or login.");
            }
        }
        
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);
        
        echo "Success! Account created successfully. Redirecting to login...";
        
    } catch(PDOException $e) {
        if (strpos($e->getMessage(), 'UNIQUE constraint failed') !== false) {
            die("Username already exists. Please choose a different username.");
        }
        die("Signup failed: " . $e->getMessage());
    }
}
?>