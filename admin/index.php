<?php
include 'includes/auth.php';
requireAdmin(); // Ensure only admins can access this page
include 'includes/header.php';
include 'includes/sidebar.php';
include '../includes/db.php';

// Fetch summary data
$books_count = $conn->query("SELECT COUNT(*) AS total FROM books")->fetch_assoc()['total'];
$authors_count = $conn->query("SELECT COUNT(*) AS total FROM authors")->fetch_assoc()['total'];
$borrowings_count = $conn->query("SELECT COUNT(*) AS total FROM borrowings")->fetch_assoc()['total'];
$active_borrowings_count = $conn->query("SELECT COUNT(*) AS total FROM borrowings WHERE return_date IS NULL")->fetch_assoc()['total'];
$users_count = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$active_users_count = $conn->query("SELECT COUNT(DISTINCT user_id) AS total FROM borrowings WHERE return_date IS NULL")->fetch_assoc()['total'];

// Fetch recent borrowings
$recent_borrowings = $conn->query("SELECT borrowings.id, books.title, users.username, borrowings.borrow_date, borrowings.return_date 
                                   FROM borrowings 
                                   JOIN books ON borrowings.book_id = books.id 
                                   JOIN users ON borrowings.user_id = users.id 
                                   ORDER BY borrowings.borrow_date DESC 
                                   LIMIT 5");

// Fetch popular books
$popular_books = $conn->query("SELECT books.id, books.title, COUNT(borrowings.id) AS borrow_count 
                               FROM books 
                               LEFT JOIN borrowings ON books.id = borrowings.book_id 
                               GROUP BY books.id 
                               ORDER BY borrow_count DESC 
                               LIMIT 5");
?>

<div class="main-content">
    <h2>Dashboard</h2>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="card">
            <h3>Total Books</h3>
            <p><?= $books_count ?></p>
        </div>
        <div class="card">
            <h3>Total Authors</h3>
            <p><?= $authors_count ?></p>
        </div>
        <div class="card">
            <h3>Total Borrowings</h3>
            <p><?= $borrowings_count ?></p>
        </div>
        <div class="card">
            <h3>Active Borrowings</h3>
            <p><?= $active_borrowings_count ?></p>
        </div>
        <div class="card">
            <h3>Total Users</h3>
            <p><?= $users_count ?></p>
        </div>
        <div class="card">
            <h3>Active Users</h3>
            <p><?= $active_users_count ?></p>
        </div>
    </div>

    <!-- Recent Borrowings -->
    <div class="dashboard-section">
        <h3>Recent Borrowings</h3>
        <table>
            <thead>
                <tr>
                    <th>Book</th>
                    <th>User</th>
                    <th>Borrow Date</th>
                    <th>Return Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $recent_borrowings->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['title'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= date('F j, Y', strtotime($row['borrow_date'])) ?></td>
                        <td><?= $row['return_date'] ? date('F j, Y', strtotime($row['return_date'])) : 'Not Returned' ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Popular Books -->
    <div class="dashboard-section">
        <h3>Popular Books</h3>
        <table>
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Borrow Count</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $popular_books->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['title'] ?></td>
                        <td><?= $row['borrow_count'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>