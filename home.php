<?php
require_once 'config.php';

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$username = $isLoggedIn ? $_SESSION['username'] : '';

// Sample job data
$recommended_jobs = [
    [
        'id' => 1,
        'title' => 'UX Designer',
        'image' => 'https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?w=400&auto=format',
        'salary_min' => 5000,
        'salary_max' => 7000,
        'tags' => ['Figma', 'research'],
        'status' => 'open',
        'bids' => 0
    ],
    [
        'id' => 2,
        'title' => 'React Developer',
        'image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=400&auto=format',
        'salary_min' => 8000,
        'salary_max' => 10000,
        'tags' => ['Next.js', 'API'],
        'status' => 'active',
        'bids' => 6
    ],
    [
        'id' => 3,
        'title' => 'Content Writer',
        'image' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=400&auto=format',
        'salary_min' => 3000,
        'salary_max' => 4000,
        'tags' => ['SEO', 'tech'],
        'status' => 'open',
        'bids' => 0
    ]
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexlance · Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', system-ui, sans-serif;
        }

        :root {
            --white: #ffffff;
            --off-white: #f9fcff;
            --blue-400: #4a80f0;
            --blue-500: #2A6DF4;
            --blue-600: #1e5ad9;
            --green-400: #34C759;
            --green-500: #10B981;
            --green-600: #0e9e6e;
            --gray-200: #eef2f6;
            --gray-600: #4b5563;
            --gray-800: #1f2937;
            --shadow-card: 0 25px 40px -18px rgba(0, 40, 80, 0.15);
        }

        body {
            background: var(--white);
            color: var(--gray-800);
            line-height: 1.5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 32px;
        }

        /* header */
        .navbar {
            background: var(--white);
            padding: 16px 0;
            border-bottom: 1px solid var(--gray-200);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .logo {
            font-size: 2rem;
            font-weight: 700;
            text-decoration: none;
        }

        .logo-blue {
            color: var(--blue-500);
        }

        .logo-green {
            color: var(--green-500);
        }

        /* Navigation UL Styles */
        .nav-menu ul {
            display: flex;
            list-style: none;
            gap: 28px;
            font-weight: 500;
            flex-wrap: wrap;
            align-items: center;
        }

        .nav-menu ul li a {
            text-decoration: none;
            color: var(--gray-800);
            padding: 6px 0;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .nav-menu ul li a:hover {
            color: var(--blue-500);
            border-bottom-color: var(--blue-400);
        }

        .nav-menu ul li a.active {
            color: var(--blue-600);
            border-bottom-color: var(--green-500);
        }

        /* User Menu Styles */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-dropdown {
            position: relative;
            display: inline-block;
        }

        .user-dropdown-btn {
            background: var(--green-500);
            color: white;
            padding: 10px 20px;
            border-radius: 60px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .user-dropdown-btn i {
            font-size: 1rem;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 120%;
            background: white;
            min-width: 200px;
            box-shadow: var(--shadow-card);
            border-radius: 16px;
            z-index: 1000;
            overflow: hidden;
        }

        .dropdown-content a {
            color: var(--gray-800);
            padding: 12px 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background 0.3s;
            border-bottom: 1px solid var(--gray-200);
        }

        .dropdown-content a:last-child {
            border-bottom: none;
        }

        .dropdown-content a:hover {
            background: var(--off-white);
            color: var(--blue-500);
        }

        .user-dropdown:hover .dropdown-content {
            display: block;
        }

        .btn {
            padding: 10px 26px;
            border-radius: 60px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-outline-blue {
            background: transparent;
            border: 1.5px solid var(--blue-400);
            color: var(--blue-500);
        }

        .btn-outline-blue:hover {
            background: var(--blue-500);
            color: white;
        }

        .btn-green {
            background: var(--green-500);
            color: white;
            box-shadow: 0 6px 14px rgba(16, 185, 129, 0.25);
        }

        .btn-green:hover {
            background: var(--green-600);
        }

        .btn-logout {
            background: #fee;
            color: #c33;
            border: 1.5px solid #fcc;
        }

        .btn-logout:hover {
            background: #fcc;
        }

        .page {
            padding: 60px 0;
            flex: 1;
        }

        h1,
        h2 {
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        h2 {
            font-size: 2.2rem;
            margin-bottom: 32px;
            border-left: 8px solid var(--green-400);
            padding-left: 24px;
            color: var(--blue-600);
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 32px;
        }

        .job-card {
            background: var(--white);
            border-radius: 28px;
            padding: 24px;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(42, 109, 244, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 45px -18px rgba(42, 109, 244, 0.25);
        }

        .card-img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 20px;
            margin-bottom: 18px;
        }

        .badge {
            background: rgba(16, 185, 129, 0.1);
            color: var(--green-600);
            font-weight: 600;
            padding: 4px 14px;
            border-radius: 60px;
            display: inline-block;
        }

        .tag-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 14px 0;
        }

        .tag {
            background: rgba(74, 128, 240, 0.1);
            color: var(--blue-600);
            padding: 6px 16px;
            border-radius: 40px;
            font-size: 0.8rem;
        }

        .green-dot {
            width: 10px;
            height: 10px;
            background: var(--green-500);
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }

        .img-cover {
            width: 100%;
            height: 240px;
            object-fit: cover;
            border-radius: 24px;
        }

        .hero-section {
            display: flex;
            gap: 30px;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 60px;
        }

        .hero-content {
            flex: 1.2;
        }

        .hero-content h1 {
            font-size: 3rem;
            line-height: 1.2;
            margin-bottom: 30px;
        }

        .hero-image {
            flex: 0.9;
        }

        .search-box {
            background: white;
            border-radius: 80px;
            border: 1px solid var(--gray-200);
            padding: 6px 6px 6px 24px;
            display: flex;
            max-width: 550px;
            margin: 30px 0;
        }

        .search-box input {
            border: none;
            flex: 1;
            font-size: 1rem;
            padding: 14px 0;
            outline: none;
        }

        .search-box button {
            border-radius: 60px;
            padding: 12px 32px;
        }

        .features {
            display: flex;
            gap: 20px;
            color: var(--gray-600);
        }

        .features i {
            margin-right: 8px;
        }

        .welcome-message {
            background: linear-gradient(135deg, var(--blue-500), var(--green-500));
            color: white;
            padding: 12px 24px;
            border-radius: 60px;
            margin-bottom: 20px;
            display: inline-block;
        }

        .footer {
            background: var(--white);
            border-top: 1px solid var(--gray-200);
            padding: 32px 0;
            text-align: center;
            color: var(--gray-600);
        }

        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                gap: 16px;
            }
            
            .nav-menu ul {
                flex-direction: column;
                text-align: center;
                gap: 16px;
            }
            
            .hero-content h1 {
                font-size: 2rem;
            }
            
            .search-box {
                flex-direction: column;
                border-radius: 30px;
                padding: 16px;
            }
            
            .search-box button {
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>
    <header class="navbar">
        <div class="container nav-container">
            <a href="home.php" class="logo">
                <span class="logo-blue">Nex</span><span class="logo-green">lance</span>
            </a>
            
            <!-- Navigation using UL -->
            <nav class="nav-menu">
                <ul>
                    <li><a href="home.php" class="active">Home</a></li>
                    <li><a href="explore.php">Explore jobs</a></li>
                    <li><a href="getjobs.php">Get jobs</a></li>
                    <li><a href="projects.php">Projects</a></li>
                    <li><a href="about.php">About us</a></li>
                    <li><a href="contact.php">Contact us</a></li>
                    <?php if (!$isLoggedIn): ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            
            <div class="user-menu">
                <?php if ($isLoggedIn): ?>
                    <!-- User Dropdown Menu for Logged In Users -->
                    <div class="user-dropdown">
                        <div class="user-dropdown-btn">
                            <i class="fas fa-user-circle"></i>
                            <span><?php echo htmlspecialchars($username); ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="dropdown-content">
                            <a href="dashboard.php">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                            <a href="profile.php">
                                <i class="fas fa-user"></i> My Profile
                            </a>
                            <a href="messages.php">
                                <i class="fas fa-envelope"></i> Messages
                                <span style="background: red; color: white; padding: 2px 8px; border-radius: 20px; font-size: 0.7rem; margin-left: auto;">3</span>
                            </a>
                            <a href="settings.php">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            <a href="logout.php" style="color: #c33;">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
                    <a href="post-project.php" class="btn btn-green">Post project</a>
                <?php else: ?>
                    <!-- Buttons for Non-Logged In Users -->
                    <a href="register.php" class="btn btn-outline-blue">Sign in</a>
                    <a href="post-project.php" class="btn btn-green" style="margin-left:10px;">Post project</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="page">
        <div class="container">
            <?php if ($isLoggedIn): ?>
                <div class="welcome-message">
                    <i class="fas fa-hand-wave" style="margin-right: 10px;"></i>
                    Welcome back, <?php echo htmlspecialchars($username); ?>! Ready to find your next project?
                </div>
            <?php endif; ?>
            
            <div class="hero-section">
                <div class="hero-content">
                    <h1>Find <span style="color:var(--blue-500);">top freelancers</span> <span style="color:var(--green-500);">instantly</span></h1>
                    
                    <form action="explore.php" method="GET" class="search-box">
                        <input type="text" name="search" placeholder="Design, development, writing..." />
                        <button type="submit" class="btn btn-green">Search</button>
                    </form>
                    
                    <div class="features">
                        <span><i class="fas fa-check-circle" style="color:var(--green-500);"></i> verified</span>
                        <span><i class="fas fa-lock" style="color:var(--blue-500);"></i> secure payments</span>
                    </div>
                </div>
                
                <div class="hero-image">
                    <img class="img-cover"
                        src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&auto=format" 
                        alt="team">
                </div>
            </div>

            <h2>Recommended jobs</h2>
            <div class="card-grid">
                <?php foreach ($recommended_jobs as $job): ?>
                    <div class="job-card" onclick="window.location.href='job-details.php?id=<?php echo $job['id']; ?>'">
                        <img class="card-img" src="<?php echo $job['image']; ?>" alt="<?php echo $job['title']; ?>">
                        <h3><?php echo $job['title']; ?></h3>
                        <div class="badge">$<?php echo number_format($job['salary_min']); ?>-<?php echo number_format($job['salary_max']); ?></div>
                        <div class="tag-list">
                            <?php foreach ($job['tags'] as $tag): ?>
                                <span class="tag"><?php echo $tag; ?></span>
                            <?php endforeach; ?>
                        </div>
                        <span class="green-dot"></span> 
                        <?php echo $job['bids'] > 0 ? $job['bids'] . ' bids' : ucfirst($job['status']); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Call to Action for Non-Logged In Users -->
            <?php if (!$isLoggedIn): ?>
                <div style="text-align: center; margin-top: 60px; padding: 40px; background: var(--off-white); border-radius: 48px;">
                    <h2 style="border-left: none; text-align: center;">Ready to start your journey?</h2>
                    <p style="color: var(--gray-600); margin-bottom: 30px;">Join thousands of freelancers and clients on Nexlance</p>
                    <a href="register.php" class="btn btn-green" style="padding: 16px 48px; font-size: 1.2rem;">Create Free Account</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>© 2025 Nexlance — white, blue & green platform. All rights reserved.</p>
            <div style="margin-top: 16px;">
                <a href="#" style="color: var(--gray-600); margin: 0 10px;"><i class="fab fa-twitter"></i></a>
                <a href="#" style="color: var(--gray-600); margin: 0 10px;"><i class="fab fa-linkedin"></i></a>
                <a href="#" style="color: var(--gray-600); margin: 0 10px;"><i class="fab fa-facebook"></i></a>
            </div>
        </div>
    </footer>
</body>

</html>