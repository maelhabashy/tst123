<?php
include '../includes/auth.php';
requireAdmin(); // Ensure only admins can access this page
include 'includes/header.php';
include 'includes/sidebar.php';
include '../includes/db.php';

$id = $_GET['id']; // Get the borrowing ID from the URL

// Fetch the borrowing details
$sql = "SELECT borrowings.id, borrowings.user_id, borrowings.book_id, borrowings.borrow_date, borrowings.return_date 
        FROM borrowings 
        WHERE borrowings.id = $id";
$result = $conn->query($sql);
$borrowing = $result->fetch_assoc();

// Fetch all users and books for the dropdowns
$users = $conn->query("SELECT id, username FROM users");
$books = $conn->query("SELECT id, title FROM books");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $book_id = $conn->real_escape_string($_POST['book_id']);
    $borrow_date = $conn->real_escape_string($_POST['borrow_date']);
    $return_date = $conn->real_escape_string($_POST['return_date']);

    // Update the borrowing in the database
    $sql = "UPDATE borrowings 
            SET user_id = $user_id, book_id = $book_id, borrow_date = '$borrow_date', return_date = '$return_date' 
            WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Borrowing updated successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>
<div class="main-content">
    <h2>Edit Borrowing</h2>
    <form method="POST">
        <label class="form-label" for="user_id">User:</label>
        <select class="form-select" name="user_id" required>
            <?php while ($user = $users->fetch_assoc()): ?>
                <option value="<?= $user['id'] ?>" <?= $user['id'] == $borrowing['user_id'] ? 'selected' : '' ?>>
                    <?= $user['username'] ?>
                </option>
            <?php endwhile; ?>
        </select>
        
        <label class="form-label" for="book_id">Book:</label>
        <select class="form-select" name="book_id" required>
            <?php while ($book = $books->fetch_assoc()): ?>
                <option value="<?= $book['id'] ?>" <?= $book['id'] == $borrowing['book_id'] ? 'selected' : '' ?>>
                    <?= $book['title'] ?>
                </option>
            <?php endwhile; ?>
        </select>
        
        <label class="form-label" for="borrow_date">Borrow Date:</label>
        <input class="form-control" type="date" name="borrow_date" value="<?= $borrowing['borrow_date'] ?>" required>
        
        <label class="form-label" for="return_date">Return Date:</label>
        <input class="form-control" type="date" name="return_date" value="<?= $borrowing['return_date'] ?>">
        
        <button type="submit">Update Borrowing</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>