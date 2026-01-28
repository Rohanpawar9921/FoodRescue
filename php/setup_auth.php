<?php
include "db.php";

try {
    //create uesrs table
    $conn->exec("create table if not exists users (
                id integer primary key autoincrement, 
                username text not null unique,
                password text not null,
                created_at datetime default current_timestamp
            )");
    
    echo "Users table created successfully!<br>";

    //crate default admin user
    $username = "admin";
    $password = password_hash("admin123", PASSWORD_DEFAULT);

    $stmt = $conn->prepare("insert or ignore into users (username, password) values (?, ?)");
    $stmt->execute([$username, $password]);

    echo "Default user created successfully! <br>";
    echo "Username: admin<br>";
    echo "Password: admin123<br>";
    echo "<br> <a href='../login.php'> Go to login</a>";
} catch(PDOException $e) {
    die("setup faild: ".$e->getMessage());
}

?>