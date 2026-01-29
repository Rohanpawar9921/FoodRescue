<?php
session_start();

// if already logged in, redirect to index
if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up - Product Catalog</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .signup-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .signup-container h1 {
            text-align: center;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        .signup-container form input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .signup-container form input:focus {
            outline: none;
            border-color: #667eea;
        }
        .signup-container form button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        .signup-container form button:hover {
            opacity: 0.9;
        }
        .password-requirements {
            font-size: 12px;
            color: #666;
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .password-requirements ul {
            margin: 5px 0 0 20px;
            padding: 0;
        }
        .links {
            text-align: center;
            margin-top: 20px;
        }
        .links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="signup-container">
    <h1>📝 Sign Up</h1>
    
    <div id="error-msg" class="error-msg"></div>
    <div id="success-msg" class="success-msg"></div>
    
    <div style="text-align: center; margin-bottom: 20px; color: #999;">Sign up with</div>
    
    <div style="display: flex; gap: 10px; margin-bottom: 25px;">
        <button style="flex: 1; padding: 12px; border: 2px solid #e0e0e0; background: white; border-radius: 8px; cursor: pointer; font-weight: bold; display: flex; align-items: center; justify-content: center; gap: 8px;" onclick="alert('Google signup coming soon!')">
            <span style="font-size: 20px;">🔍</span> Google
        </button>
        <button style="flex: 1; padding: 12px; border: 2px solid #e0e0e0; background: white; border-radius: 8px; cursor: pointer; font-weight: bold; display: flex; align-items: center; justify-content: center; gap: 8px;" onclick="alert('GitHub signup coming soon!')">
            <span style="font-size: 20px;">🐙</span> GitHub
        </button>
    </div>
    
    <div style="text-align: center; margin-bottom: 20px; color: #999;">or use email</div>
    
    <form id="signupForm">
        <input type="text" name="username" id="username" placeholder="Username" required 
               minlength="3" maxlength="50" autocomplete="username">
        
        <input type="email" name="email" id="email" placeholder="Email (optional)" autocomplete="email">
        
        <input type="password" name="password" id="password" placeholder="Password" required 
               minlength="6" autocomplete="new-password">
        
        <input type="password" name="confirm_password" id="confirm_password" 
               placeholder="Confirm Password" required autocomplete="new-password">
        
        <div class="password-requirements">
            <strong>Password Requirements:</strong>
            <ul>
                <li>At least 6 characters long</li>
                <li>Both passwords must match</li>
            </ul>
        </div>
        
        <button type="submit">Create Account</button>
    </form>
    
    <div class="links">
        <a href="login.php">Already have an account? Login</a>
        <span>|</span>
        <a href="home.php">Back to Home</a>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#signupForm").submit(function(e) {
            e.preventDefault();
            
            $("#error-msg").hide();
            $("#success-msg").hide();  // Line 148: Fixed $.("#success-msg") to $("#success-msg")
            
            // Client-side validation
            var password = $("#password").val();
            var confirmPassword = $("#confirm_password").val();
            var username = $("#username").val();
            
            if(username.length < 3) {
                $("#error-msg").text("Username must be at least 3 characters long").show();
                return;
            }
            
            if (password.length < 6) {
                $("#error-msg").text("Password must be at least 6 characters long").show();
                return;
            }
            
            if (password !== confirmPassword) {
                $("#error-msg").text("Passwords do not match").show();
                return;
            }
            
            // Submit via AJAX
            $.post("php/signup.php", $(this).serialize(), function(res) {
                if(res.indexOf("Success") !== -1 || res.indexOf("created successfully") !== -1) {
                    $("#success-msg").text(res).show();
                    $("#signupForm")[0].reset();  // Line 174: Fixed $("#signupFrom") to $("#signupForm")
                    
                    // Redirect to login after 2 seconds
                    setTimeout(function() {
                        window.location.href = "login.php";
                    }, 2000);
                } else {
                    $("#error-msg").text(res).show();
                }
            }).fail(function(xhr, status, error) {
                $("#error-msg").text("Error: " + error).show();  // Line 184: Fixed $("#eror-msg") and changed 'res' to 'error'
            });
        });
        
        // Real-time password match validation
        $("#confirm_password").on("keyup", function() {
            var password = $("#password").val();
            var confirmPassword = $(this).val();
            
            if (confirmPassword && password !== confirmPassword) {
                $(this).css("border-color", "#e74c3c");
            } else {
                $(this).css("border-color", "#27ae60");
            }
        });
    });
</script>
</body>
</html>