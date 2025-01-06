<?php
session_start();
include 'includes/db.php';

// Search and Filter Logic
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';

// Base SQL Query
$sql = "SELECT books.id, books.title, books.image, authors.name AS author_name, categories.name AS category_name 
        FROM books 
        JOIN authors ON books.author_id = authors.id 
        JOIN categories ON books.category_id = categories.id 
        WHERE books.title LIKE '%$search%'";

// Add Category Filter if Selected
if (!empty($category)) {
    $sql .= " AND categories.name = '$category'";
}

// Pagination Logic
$results_per_page = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $results_per_page;

// Fetch Total Number of Books
$total_books_sql = str_replace("SELECT books.id, books.title, books.image, authors.name AS author_name, categories.name AS category_name", "SELECT COUNT(*) as total", $sql);
$total_books_result = $conn->query($total_books_sql);
$total_books = $total_books_result->fetch_assoc()['total'];
$total_pages = ceil($total_books / $results_per_page);

// Fetch Books for Current Page
$sql .= " LIMIT $results_per_page OFFSET $offset";
$result = $conn->query($sql);

// Fetch Categories for Filter Dropdown
$categories_sql = "SELECT * FROM categories";
$categories_result = $conn->query($categories_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books - Online Library</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Additional Styles for Enhanced Design */
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
        .books {
            padding: 20px;
            text-align: center;
        }
        .search-filter {
            margin-bottom: 20px;
        }
        .search-filter input, .search-filter select {
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .book-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .book-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 200px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .book-card img {
            width: 150px; /* Fixed width */
            height: 200px; /* Fixed height */
            object-fit: cover; /* Ensures the image covers the area without distortion */
            border-radius: 5px;
        }
        .book-card h3 {
            font-size: 18px;
            margin: 10px 0;
        }
        .book-card p {
            font-size: 14px;
            color: #555;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            padding: 10px 15px;
            margin: 0 5px;
            background: #41CB5A;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
        }
        .pagination a:hover {
            background: #0e0e0e;
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

    <!-- Books Section -->
    <section class="books">
        <h2>All Books</h2>

        <!-- Search and Filter Form -->
        <div class="search-filter">
            <form method="GET" action="books.php">
                <input type="text" name="search" placeholder="Search by title" value="<?= htmlspecialchars($search) ?>">
                <select name="category">
                    <option value="">All Categories</option>
                    <?php while ($category_row = $categories_result->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($category_row['name']) ?>" <?= $category === $category_row['name'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category_row['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <button type="submit" class="btn">Search</button>
            </form>
        </div>

        <!-- Book List -->
        <div class="book-list">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="book-card">
                        <img src="img/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                        <h3><?= htmlspecialchars($row['title']) ?></h3>
                        <p>Author: <?= htmlspecialchars($row['author_name']) ?></p>
                        <p>Category: <?= htmlspecialchars($row['category_name']) ?></p>
                        <a href="book-details.php?id=<?= $row['id'] ?>" class="btn">View Details</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No books found.</p>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="books.php?page=<?= $i ?>&search=<?= $search ?>&category=<?= $category ?>" <?= $page === $i ? 'class="active"' : '' ?>><?= $i ?></a>
            <?php endfor; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Online Library. All rights reserved.</p>
    </footer>
</body>
</html>