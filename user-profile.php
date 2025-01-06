
<?php
session_start();
include 'includes/db.php';

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch User Information
$user_sql = "SELECT username, email, created_at FROM users WHERE id = $user_id";
$user_result = $conn->query($user_sql);
$user = $user_result->fetch_assoc();

// Fetch Borrowed Books
$borrowed_books_sql = "SELECT books.id, books.title, books.image, authors.name AS author_name, borrowings.borrow_date, borrowings.return_date 
                       FROM borrowings 
                       JOIN books ON borrowings.book_id = books.id 
                       JOIN authors ON books.author_id = authors.id 
                       WHERE borrowings.user_id = $user_id 
                       ORDER BY borrowings.borrow_date DESC";
$borrowed_books_result = $conn->query($borrowed_books_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Online Library</title>
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

        /* Profile Section */
        .profile-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .profile-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .profile-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #333;
        }
        .profile-header p {
            font-size: 16px;
            color: #555;
        }

        /* User Info Section */
        .user-info {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 40px;
        }
        .user-info h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .user-info p {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
        }

        /* Borrowed Books Section */
        .borrowed-books {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
        }
        .borrowed-books h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .book-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .book-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: calc(25% - 20px);
            padding: 15px;
            text-align: center;
        }
        .book-card img {
            width: 150px; /* Fixed width */
            height: 200px; /* Fixed height */
            object-fit: cover; /* Ensures the image covers the area without distortion */
            border-radius: 10px;
        }
        .book-card h3 {
            font-size: 18px;
            margin: 10px 0;
        }
        .book-card p {
            font-size: 14px;
            color: #555;
        }
        .book-card .btn {
            display: inline-block;
            padding: 16px 24px;
            background-color: #41CB5A;
            color: #fff;
            border-radius: 16px;
            text-decoration: none;
            margin-top: 10px;
        }
        .book-card .btn:hover {
            background-color: #0e0e0e;
        }

        /* Footer */
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
    <!-- Navigation Bar -->
    <nav class="navbar">
    <div class="logo">
        <img src="img/Logo.png" alt="Logo" width="100" height="100" title="Online Library" />
    </div>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="books.php">Books</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="user-profile.php">User Profile</a></li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li><a href="./admin/index.php">Admin Dashboard</a></li>
            <?php endif; ?>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>

    <!-- Profile Container -->
    <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
            <h1>Welcome, <?= htmlspecialchars($user['username']) ?></h1>
            <p>Member since: <?= date('F j, Y', strtotime($user['created_at'])) ?></p>
        </div>

        <!-- User Info Section -->
        <div class="user-info">
            <h2>Your Information</h2>
            <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Account Created:</strong> <?= date('F j, Y', strtotime($user['created_at'])) ?></p>
        </div>

        <!-- Borrowed Books Section -->
        <div class="borrowed-books">
            <h2>Books You've Borrowed</h2>
            <div class="book-list">
                <?php if ($borrowed_books_result->num_rows > 0): ?>
                    <?php while ($row = $borrowed_books_result->fetch_assoc()): ?>
                        <div class="book-card">
                            <img src="img/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                            <h3><?= htmlspecialchars($row['title']) ?></h3>
                            <p>Author: <?= htmlspecialchars($row['author_name']) ?></p>
                            <p>Borrowed on: <?= date('F j, Y', strtotime($row['borrow_date'])) ?></p>
                            <p>Return by: <?= date('F j, Y', strtotime($row['return_date'])) ?></p>
                            <a href="book-details.php?id=<?= $row['id'] ?>" class="btn">View Details</a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>You haven't borrowed any books yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Online Library. All rights reserved.</p>
    </footer>
</body>
</html>