<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

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
  
}
?>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="book-image">
                    <img src="img/<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
                </div>
            </div>
            <div class="col-12 col-lg-8">
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
                                <label class="form-label" for="borrow_date">Choose Borrow Date:</label>
                                <div>
                                    <input class="form-control" type="date" name="borrow_date" id="borrow_date" required>
                                    <button type="submit" class="btn" name="borrow">Borrow This Book</button>
                                </div>
                            </form>
                        </div>
                        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow'])): ?>
                            <p class="success-message">You have successfully borrowed this book. Please return it by: <strong><?= $return_date ?></strong></p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>Please <a href="login.php">login</a> to borrow this book.</p>
                    <?php endif; ?>

                    <!-- Back to Books Button -->
                    <a href="books.php" class=" btn">Back to Books</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<?php
include 'includes/footer.php';

?>
</body>

</html>