<?php include 'includes/header.php'; ?>
<div class="container">
    <h2>Book Catalog</h2>
    <div class="book-list">
        <?php
        include 'includes/db.php';
        $stmt = $pdo->query("SELECT * FROM books");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "
            <div class='book-card'>
                <img src='images/{$row['image']}' alt='{$row['title']}'>
                <h3>{$row['title']}</h3>
                <p>{$row['author']}</p>
                <a href='book-details.php?id={$row['id']}'>View Details</a>
            </div>
            ";
        }
        ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>