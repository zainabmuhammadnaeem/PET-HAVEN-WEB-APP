<?php
include("db-pet.php");
session_start(); // Start the session

$error = ""; // Variable to store error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    $user = loginUser($email, $password); // Calls function from db-pet.php

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];

        // Redirect based on user role
        if ($user['role'] == 'admin') {
            header("Location: admin-dashboard.php");
        } else {
            header("Location: homepage.pet.php");
        }
        exit();
    } else {
        $error = "❌ Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🐾 Pet Adoption | Login</title>
    <link rel="stylesheet" href="style.css"> <!-- External CSS -->
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: url('images/bg.jpg') no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            position: relative;
        }

        /* Background Overlay */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 380px;
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease-in-out;
        }

        .login-container:hover {
            transform: scale(1.02);
        }

        .login-container h2 {
            color: #6F4F1F;
            margin-bottom: 25px;
            font-size: 24px;
        }

        .input-group {
            position: relative;
            width: 100%;
            margin-bottom: 15px;
        }

        .login-container input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: 0.3s;
            outline: none;
        }

        .login-container input:focus {
            border-color: #6F4F1F;
            box-shadow: 0 0 8px rgba(111, 79, 31, 0.5);
        }

        /* Password Toggle */
        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 40px;
        }

        .password-wrapper .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #6F4F1F;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            background: #6F4F1F;
            color: white;
            border: none;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        .login-container button:hover {
            background: #563B1D;
        }

        .error {
            color: red;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .signup-link {
            margin-top: 15px;
            font-size: 14px;
        }

        .signup-link a {
            color: #6F4F1F;
            text-decoration: none;
            font-weight: bold;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 420px) {
            .login-container {
                width: 90%;
                padding: 25px;
            }
        }
    </style>
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var icon = document.getElementById("toggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.innerHTML = "👁️"; // Show password
            } else {
                passwordInput.type = "password";
                icon.innerHTML = "🔒"; // Hide password
            }
        }
    </script>
</head>
<body>

    <div class="login-container">
        <h2>🐾 Welcome Back to Pet Adoption</h2>
        <form method="POST">
            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

            <div class="input-group">
                <input type="email" name="email" placeholder="📧 Enter Email" required>
            </div>

            <div class="input-group password-wrapper">
                <input type="password" id="password" name="password" placeholder="🔒 Enter Password" required>
                <span class="toggle-password" id="toggleIcon" onclick="togglePassword()">👁️</span>
            </div>

            <button type="submit">Login</button>

            <p class="signup-link">Don't have an account? <a href="register.php">Sign up</a></p>
        </form>
    </div>

</body>
</html>
