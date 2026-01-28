<?php

session_start();
include "db.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        die("Username and password are required");
    }

    try {
        $stmt = $conn->prepare("select id, username, password from users where username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo "Success! Redirecting...........";
        }
        else {
            echo "Invalid username or password";
        }
    } catch(PDOException $e) {
        die("Login failed: ". $e->getMessage());
    }
} 

?>