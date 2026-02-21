<?php
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user details
$user_id = $_SESSION['user_id'];
$query = "SELECT username, email, created_at FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Freelance Hiring Platform</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
        }
        .navbar {
            background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%);
            padding: 1rem 2rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .username {
            font-weight: 500;
        }
        .logout-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .welcome-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .welcome-card h1 {
            color: #333;
            margin-bottom: 15px;
        }
        .welcome-card p {
            color: #666;
            line-height: 1.6;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .stat-card .number {
            color: #0083b0;
            font-size: 28px;
            font-weight: bold;
        }
        .profile-info {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .profile-info h2 {
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f2f5;
        }
        .info-row {
            display: flex;
            margin-bottom: 15px;
            padding: 10px 0;
        }
        .info-label {
            width: 150px;
            color: #666;
            font-weight: 500;
        }
        .info-value {
            color: #333;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">🚀 Freelance Hiring Platform</div>
        <div class="user-info">
            <span class="username">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-card">
            <h1>Welcome to Your Dashboard!</h1>
            <p>Manage your freelance profile, find projects, or hire talented freelancers.</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Profile Views</h3>
                <div class="number">0</div>
            </div>
            <div class="stat-card">
                <h3>Projects</h3>
                <div class="number">0</div>
            </div>
            <div class="stat-card">
                <h3>Earnings</h3>
                <div class="number">$0</div>
            </div>
            <div class="stat-card">
                <h3>Reviews</h3>
                <div class="number">0</div>
            </div>
        </div>

        <div class="profile-info">
            <h2>Profile Information</h2>
            <div class="info-row">
                <div class="info-label">Username:</div>
                <div class="info-value"><?php echo htmlspecialchars($user['username']); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value"><?php echo htmlspecialchars($user['email']); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Member Since:</div>
                <div class="info-value"><?php echo date('F j, Y', strtotime($user['created_at'])); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Account Type:</div>
                <div class="info-value">Freelancer/Client</div>
            </div>
        </div>
    </div>
</body>
</html>