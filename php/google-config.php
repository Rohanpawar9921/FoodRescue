<?php
// Google OAuth Configuration
// Get these values from Google Cloud Console: https://console.cloud.google.com/

define('GOOGLE_CLIENT_ID', 'YOUR_GOOGLE_CLIENT_ID_HERE.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', 'YOUR_CLIENT_SECRET_HERE');

// For local development
define('GOOGLE_REDIRECT_URI', 'http://localhost:8000/php/google-callback.php');

// For production, change to:
// define('GOOGLE_REDIRECT_URI', 'https://yourdomain.com/php/google-callback.php');
?>
