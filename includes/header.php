<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
  /* Modern Design */
  body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        /* Navigation Bar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #0e0e0e;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar .logo {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
        }
        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .navbar ul li {
            margin-left: 20px;
        }
        .navbar ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
        }
        .navbar ul li a:hover {
            text-decoration: underline;
        }

footer {
            background-color: #0e0e0e;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: 40px;
        }

    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
    <div class="logo"> <img src="img/Logo.png" alt="Logo" width="100" height="100" title="Online Library" /> </div>
    <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="books.php">Books</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="user-profile.php">User Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
 