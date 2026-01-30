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
        <button type="button" style="flex: 1; padding: 12px; border: 2px solid #e0e0e0; background: white; border-radius: 8px; cursor: pointer; font-weight: bold; display: flex; align-items: center; justify-content: center; gap: 8px;" onclick="alert('Google login coming soon!')">
            <span style="font-size: 20px;">🔍</span> Google
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
    $(document).ready(function() {
        console.log("jQuery loaded:", typeof $ !== 'undefined');
        
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