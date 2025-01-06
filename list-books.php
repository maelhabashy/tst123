<?php
session_start();
include 'includes/db.php';

$sql = "SELECT books.id, books.title, authors.name AS author, categories.name AS category, books.description 
        FROM books 
        JOIN authors ON books.author_id = authors.id 
        JOIN categories ON books.category_id = categories.id";
$result = $conn->query($sql);
?>
<?php include 'includes/header.php'; ?>
<div class="container">
    <h2>All Books</h2>
    <div class="book-list">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="book-card">
                    <h3><?= $row['title'] ?></h3>
                    <p><strong>Author:</strong> <?= $row['author'] ?></p>
                    <p><strong>Category:</strong> <?= $row['category'] ?></p>
                    <p><?= $row['description'] ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No books found.</p>
        <?php endif; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>