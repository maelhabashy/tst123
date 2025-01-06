<?php
include 'includes/auth.php';
requireAdmin(); // Ensure only admins can access this page
include 'includes/header.php';
include 'includes/sidebar.php';
include '../includes/db.php';

// Fetch all borrowings
$sql = "SELECT borrowings.id, users.username, books.title, borrowings.borrow_date, borrowings.return_date 
        FROM borrowings 
        JOIN users ON borrowings.user_id = users.id 
        JOIN books ON borrowings.book_id = books.id";
$result = $conn->query($sql);
?>
<div class="main-content">
    <h2>Borrowing Details</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Book</th>
                <th>Borrow Date</th>
                <th>Return Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['title'] ?></td>
                    <td><?= $row['borrow_date'] ?></td>
                    <td><?= $row['return_date'] ?? 'Not returned' ?></td>
                    <td class="action-buttons">
                        <a href="edit-borrowing.php?id=<?= $row['id'] ?>" class="update">Update</a>
                        <a href="delete-borrowing.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Are you sure you want to delete this borrowing record?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include 'includes/footer.php'; ?>