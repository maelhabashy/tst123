<?php
session_start();
include 'includes/db.php';

// Fetch Book Details
$book_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT books.id, books.title, books.description, books.image, books.publication_date, books.isbn, authors.name AS author_name, categories.name AS category_name 
        FROM books 
        JOIN authors ON books.author_id = authors.id 
        JOIN categories ON books.category_id = categories.id 
        WHERE books.id = $book_id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("Book not found.");
}

$book = $result->fetch_assoc();

// Handle Borrow Button
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow'])) {
    $user_id = $_SESSION['user_id'];
    $borrow_date = $conn->real_escape_string($_POST['borrow_date']);
    $return_date = date('Y-m-d', strtotime($borrow_date . ' +14 days')); // Return date after 14 days

    // Insert into borrowings table
    $sql = "INSERT INTO borrowings (user_id, book_id, borrow_date, return_date) 
            VALUES ($user_id, $book_id, '$borrow_date', '$return_date')";
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success-message'>Book borrowed successfully! Return by: $return_date</p>";
    } else {
        echo "<p class='error-message'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($book['title']) ?> - Online Library</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Modern Design */
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
        .book-details-container {
            display: flex;
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .book-image {
            flex: 1;
            max-width: 400px;
            margin-right: 20px;
        }
        .book-image img {
            width: 100%;
            border-radius: 10px;
        }
        .book-info {
            flex: 2;
            padding: 20px;
        }
        .book-info h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #333;
        }
        .book-info p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }
        .book-info .info-section {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .book-info .info-section p {
            margin: 10px 0;
        }
        .borrow-form {
            margin-top: 20px;
        }
        .borrow-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .borrow-form input[type="date"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            max-width: 200px;
            margin-bottom: 16px;
        }
        .borrow-form button {
            padding: 10px 20px;
            background-color: #41CB5A;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .borrow-form button:hover {
            background-color: #0e0e0e;
        }
        .success-message {
            color: #28a745;
            margin-top: 20px;
        }
        .error-message {
            color: #dc3545;
            margin-top: 20px;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #6c757d;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 20px;
        }
        .back-button:hover {
            background-color: #5a6268;
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

    <!-- Book Details Section -->
    <div class="book-details-container">
        <!-- Book Image -->
        <div class="book-image">
            <img src="img/<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
        </div>

        <!-- Book Information -->
        <div class="book-info">
            <h1><?= htmlspecialchars($book['title']) ?></h1>
            <p>By <strong><?= htmlspecialchars($book['author_name']) ?></strong></p>

            <!-- Book Details -->
            <div class="info-section">
                <p><strong>Description:</strong> <?= htmlspecialchars($book['description']) ?></p>
                <p><strong>Publication Date:</strong> <?= htmlspecialchars($book['publication_date']) ?></p>
                <p><strong>Category:</strong> <?= htmlspecialchars($book['category_name']) ?></p>
                <p><strong>ISBN:</strong> <?= htmlspecialchars($book['isbn']) ?></p>
            </div>

            <!-- Borrow Form -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="borrow-form">
                    <form method="POST">
                        <label for="borrow_date">Choose Borrow Date:</label>
                        <input type="date" name="borrow_date" id="borrow_date" required>
                        <button type="submit" name="borrow">Borrow This Book</button>
                    </form>
                </div>
                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow'])): ?>
                    <p class="success-message">You have successfully borrowed this book. Please return it by: <strong><?= $return_date ?></strong></p>
                <?php endif; ?>
            <?php else: ?>
                <p>Please <a href="login.php">login</a> to borrow this book.</p>
            <?php endif; ?>

            <!-- Back to Books Button -->
            <a href="books.php" class="back-button">Back to Books</a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Online Library. All rights reserved.</p>
    </footer>
</body>
</html>