<?php
session_start();
require_once 'google-config.php';
require_once 'db.php';

// Check if we have an authorization code
if (!isset($_GET['code'])) {
    header('Location: ../pages/login.php?error=no_code');
    exit();
}

$code = $_GET['code'];

// Exchange authorization code for access token
$tokenUrl = 'https://oauth2.googleapis.com/token';
$postData = [
    'code' => $code,
    'client_id' => GOOGLE_CLIENT_ID,
    'client_secret' => GOOGLE_CLIENT_SECRET,
    'redirect_uri' => GOOGLE_REDIRECT_URI,
    'grant_type' => 'authorization_code'
];

$ch = curl_init($tokenUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
$response = curl_exec($ch);
curl_close($ch);

$tokenData = json_decode($response, true);

if (!isset($tokenData['access_token'])) {
    header('Location: ../pages/login.php?error=token_failed');
    exit();
}

// Get user info from Google
$userInfoUrl = 'https://www.googleapis.com/oauth2/v2/userinfo';
$ch = curl_init($userInfoUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $tokenData['access_token']
]);
$userInfoResponse = curl_exec($ch);
curl_close($ch);

$userInfo = json_decode($userInfoResponse, true);

if (!isset($userInfo['email'])) {
    header('Location: ../pages/login.php?error=userinfo_failed');
    exit();
}

// Extract user data
$googleId = $userInfo['id'];
$email = $userInfo['email'];
$name = $userInfo['name'] ?? '';
$picture = $userInfo['picture'] ?? '';

// Check if user exists in database
try {
    // First, check if users table has necessary columns
    $stmt = $conn->prepare("SELECT * FROM users WHERE google_id = ? OR email = ? LIMIT 1");
    $stmt->execute([$googleId, $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        // User exists, update their info if needed
        if (empty($user['google_id'])) {
            $updateStmt = $conn->prepare("UPDATE users SET google_id = ?, profile_picture = ? WHERE id = ?");
            $updateStmt->execute([$googleId, $picture, $user['id']]);
        }
        
        // Log them in
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['login_method'] = 'google';
        
    } else {
        // Create new user
        // Generate username from email or name
        $username = $name ? strtolower(str_replace(' ', '', $name)) : explode('@', $email)[0];
        
        // Check if username already exists, if so append number
        $baseUsername = $username;
        $counter = 1;
        while (true) {
            $checkStmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $checkStmt->execute([$username]);
            if ($checkStmt->rowCount() == 0) {
                break;
            }
            $username = $baseUsername . $counter;
            $counter++;
        }
        
        // Insert new user
        $insertStmt = $conn->prepare("
            INSERT INTO users (username, email, password, google_id, profile_picture, created_at) 
            VALUES (?, ?, ?, ?, ?, datetime('now'))
        ");
        // Use empty password for Google users (they won't use password login)
        $insertStmt->execute([$username, $email, '', $googleId, $picture]);
        
        $userId = $conn->lastInsertId();
        
        // Log them in
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['login_method'] = 'google';
    }
    
    // Redirect to main page
    header('Location: ../pages/index.php?login=success');
    exit();
    
} catch (PDOException $e) {
    error_log("Google login error: " . $e->getMessage());
    header('Location: ../pages/login.php?error=database_error');
    exit();
}
?>
