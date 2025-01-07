<?php
include 'includes/auth.php';
requireAdmin(); // Ensure only admins can access this page
include 'includes/header.php';
include 'includes/sidebar.php';
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $book_id = $conn->real_escape_string($_POST['book_id']);
    $borrow_date = $conn->real_escape_string($_POST['borrow_date']);
    $return_date = $conn->real_escape_string($_POST['return_date']);

    // Insert the new borrowing into the database
    $sql = "INSERT INTO borrowings (user_id, book_id, borrow_date, return_date) 
            VALUES ($user_id, $book_id, '$borrow_date', '$return_date')";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Borrowing added successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

// Fetch all users and books for the dropdowns
$users = $conn->query("SELECT id, username FROM users");
$books = $conn->query("SELECT id, title FROM books");
?>
<div class="main-content">
    <div class="form-container">
        <h2>Add Borrowing</h2>
        <form method="POST">
            <label class="form-label" for="user_id">User:</label>
            <select class="form-select" name="user_id" required>
                <?php while ($user = $users->fetch_assoc()): ?>
                    <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
                <?php endwhile; ?>
            </select>
            
            <label class="form-label" for="book_id">Book:</label>
            <select class="form-select" name="book_id" required>
                <?php while ($book = $books->fetch_assoc()): ?>
                    <option value="<?= $book['id'] ?>"><?= $book['title'] ?></option>
                <?php endwhile; ?>
            </select>
            
            <label class="form-label" for="borrow_date">Borrow Date:</label>
            <input class="form-control" type="date" name="borrow_date" required>
            
            <label class="form-label" for="return_date">Return Date:</label>
            <input class="form-control" type="date" name="return_date">
            
            <button type="submit">Add Borrowing</button>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>