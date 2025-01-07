<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';


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

<div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section">
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
                                <div class="row">
                                    <?php if ($borrowed_books_result->num_rows > 0): ?>
                                        <?php while ($row = $borrowed_books_result->fetch_assoc()): ?>
                                            <div class="col-12 col-lg-3">
                                                <div class="book-card">
                                                    <img src="img/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                                                    <h3><?= htmlspecialchars($row['title']) ?></h3>
                                                    <p>Author: <?= htmlspecialchars($row['author_name']) ?></p>
                                                    <p>Borrowed on: <?= date('F j, Y', strtotime($row['borrow_date'])) ?></p>
                                                    <p>Return by: <?= date('F j, Y', strtotime($row['return_date'])) ?></p>
                                                    <a href="book-details.php?id=<?= $row['id'] ?>" class="btn">View Details</a>
                                                </div>
                                            </div>


                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <p>You haven't borrowed any books yet.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include 'includes/footer.php';

?>
</body>

</html>