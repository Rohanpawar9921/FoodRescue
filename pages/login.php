<?php
session_start();

// If already logged in, redirect to admin
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Product Catalog</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .login-container h1 {
            text-align: center;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .error-msg {
            color: #e74c3c;
            background: #fadbd8;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            display: none;
        }
        .success-msg {
            color: #27ae60;
            background: #d5f4e6;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            display: none;
        }
        .login-container form input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .login-container form input:focus {
            outline: none;
            border-color: #10b981;
        }
        .login-container form button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        .login-container form button:hover {
            opacity: 0.9;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h1>🔐 Login</h1>
    
    <div id="error-msg" class="error-msg"></div>
    <div id="success-msg" class="success-msg"></div>
    
    <form id="loginForm">
        <input type="text" name="username" placeholder="Username" required autocomplete="username">
        <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
        <button type="submit">Login</button>
    </form>
    
    <div style="text-align: center; margin: 20px 0;">
        <a href="#" style="color: #10b981; text-decoration: none; font-size: 14px;">Forgot Password?</a>
    </div>
    
    <div style="text-align: center; margin: 20px 0; color: #999;">or continue with</div>
    
    <div style="display: flex; gap: 10px; margin-bottom: 20px;">
        <button type="button" id="googleSignInBtn" style="flex: 1; padding: 12px; border: 2px solid #e0e0e0; background: white; border-radius: 8px; cursor: pointer; font-weight: bold; display: flex; align-items: center; justify-content: center; gap: 8px;">
            <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
            </svg>
            Google
        </button>
        <button type="button" style="flex: 1; padding: 12px; border: 2px solid #e0e0e0; background: white; border-radius: 8px; cursor: pointer; font-weight: bold; display: flex; align-items: center; justify-content: center; gap: 8px;" onclick="alert('GitHub login coming soon!')">
            <span style="font-size: 20px;">🐙</span> GitHub
        </button>
    </div>
    
    <div class="back-link">
        <a href="signup.php">Don't have an account? Sign up</a>
        <span style="margin: 0 10px;">|</span>
        <a href="home.php">Back to Home</a>
    </div>

    <div class="back-link">
    <a href="signup.php">Don't have an account? Sign up</a>
    <span>|</span>
    <a href="index.php">Back to Catalog</a>
</div>
</div>

<script>
    // Google Sign-In Configuration
    const GOOGLE_CLIENT_ID = 'YOUR_GOOGLE_CLIENT_ID_HERE.apps.googleusercontent.com';
    
    // Initialize Google Sign-In button
    function initGoogleSignIn() {
        const googleBtn = document.getElementById('googleSignInBtn');
        googleBtn.addEventListener('click', function() {
            const authUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' + 
                'client_id=' + GOOGLE_CLIENT_ID +
                '&redirect_uri=' + encodeURIComponent(window.location.origin + '/php/google-callback.php') +
                '&response_type=code' +
                '&scope=email profile' +
                '&access_type=offline';
            
            window.location.href = authUrl;
        });
    }
    
    $(document).ready(function() {
        console.log("jQuery loaded:", typeof $ !== 'undefined');
        
        // Initialize Google Sign-In
        initGoogleSignIn();
        
        // Check for error messages from OAuth callback
        const urlParams = new URLSearchParams(window.location.search);
        const error = urlParams.get('error');
        if (error) {
            let errorMsg = 'Authentication failed';
            switch(error) {
                case 'no_code': errorMsg = 'No authorization code received'; break;
                case 'token_failed': errorMsg = 'Failed to get access token'; break;
                case 'userinfo_failed': errorMsg = 'Failed to get user information'; break;
                case 'database_error': errorMsg = 'Database error occurred'; break;
            }
            $("#error-msg").text(errorMsg).show();
        }
        
        $("#loginForm").submit(function(e) {
            e.preventDefault();
            console.log("Form submitted");
            
            $("#error-msg").hide();
            $("#success-msg").hide();
            
            var formData = $(this).serialize();
            console.log("Form data:", formData);

            $.post("../php/login.php", formData, function(res) {
                console.log("Response received:", res);
                
                if(res.indexOf("Success") !== -1) {
                    $("#success-msg").text(res).show();
                    setTimeout(function() {
                        window.location.href = "index.php";
                    }, 500);
                } else {
                    $("#error-msg").text(res).show();
                }
            }).fail(function(xhr, status, error) {
                console.log("AJAX Error:", status, error);
                $("#error-msg").text("Error: " + error).show();
            });
        });
    });
</script>

</body>
</html>