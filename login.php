<?php
require_once 'config.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $error = "Please enter username/email and password";
    } else {
        // Check if user exists (by username or email)
        $query = "SELECT id, username, password FROM users WHERE username = '$username' OR email = '$username'";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            
            if (password_verify($password, $user['password'])) {
                // Password correct - start session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid password";
            }
        } else {
            $error = "User not found";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Freelance Hiring Platform</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
            font-size: 14px;
        }
        input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        input:focus {
            outline: none;
            border-color: #00b4db;
            box-shadow: 0 0 0 3px rgba(0, 180, 219, 0.1);
        }
        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 180, 219, 0.4);
        }
        .error {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
            font-size: 14px;
        }
        .register-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }
        .register-link a {
            color: #0083b0;
            text-decoration: none;
            font-weight: 500;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .freelance-badge {
            text-align: center;
            margin-bottom: 20px;
        }
        .freelance-badge span {
            background: #f0f8ff;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            color: #0083b0;
        }
        .forgot-password {
            text-align: right;
            margin-top: 5px;
        }
        .forgot-password a {
            color: #666;
            font-size: 13px;
            text-decoration: none;
        }
        .forgot-password a:hover {
            color: #0083b0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="freelance-badge">
            <span>🚀 Freelance Hiring Platform</span>
        </div>
        <h2>Welcome Back</h2>
        <div class="subtitle">Login to access your freelance account</div>
        
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" required
                       placeholder="Enter your username or email">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required
                       placeholder="Enter your password">
                <div class="forgot-password">
                    <a href="#">Forgot password?</a>
                </div>
            </div>
            
            <button type="submit">Login to Dashboard</button>
        </form>
        
        <div class="register-link">
            New to our platform? <a href="register.php">Create an account</a>
        </div>
    </div>
</body>
</html>