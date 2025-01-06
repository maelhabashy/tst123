<?php
session_start(); // Start the session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Sliding Navigation Bar */
        .sliding-nav {
            background-color: #2c3e50;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: top 0.3s ease;
        }

        .sliding-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 20px;
        }

        .sliding-nav ul li {
            margin: 0;
        }

        .sliding-nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .sliding-nav ul li a:hover {
            background-color: #1abc9c;
        }

        /* Header */
        header {
            padding-top: 60px; /* Add padding to avoid overlap with the fixed navigation bar */
            text-align: center;
            background-color: #3498db;
            color: #fff;
            padding: 20px;
        }

        header h1 {
            margin: 0;
            font-size: 32px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Online Library</h1>
    </header>

    <!-- Sliding Navigation Bar -->
    <nav class="sliding-nav">
        <ul>
            <li><a href="../index.php">Website</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li><a href="index.php">Admin Dashboard</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Main Content -->
    <main>
        <!-- Add your main content here -->
    </main>
</body>
</html>