<?php
// Update users table to support Google OAuth
require_once 'db.php';

try {
    // Add google_id and profile_picture columns if they don't exist
    $conn->exec("
        ALTER TABLE users ADD COLUMN google_id TEXT DEFAULT NULL;
    ");
    echo "Added google_id column\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'duplicate column name') === false) {
        echo "Error adding google_id: " . $e->getMessage() . "\n";
    } else {
        echo "google_id column already exists\n";
    }
}

try {
    $conn->exec("
        ALTER TABLE users ADD COLUMN profile_picture TEXT DEFAULT NULL;
    ");
    echo "Added profile_picture column\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'duplicate column name') === false) {
        echo "Error adding profile_picture: " . $e->getMessage() . "\n";
    } else {
        echo "profile_picture column already exists\n";
    }
}

try {
    $conn->exec("
        CREATE INDEX IF NOT EXISTS idx_google_id ON users(google_id);
    ");
    echo "Created index on google_id\n";
} catch (PDOException $e) {
    echo "Error creating index: " . $e->getMessage() . "\n";
}

echo "\nDatabase schema updated successfully!\n";
?>
