<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include 'includes/auth.php';
requireAdmin(); // Ensure only admins can access this page
include 'includes/header.php';
include 'includes/sidebar.php';
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);

    $sql = "INSERT INTO categories (name) VALUES ('$name')";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Category added successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>
<div class="container">
    
    <form method="POST">
    <h2 align="center">Add Category</h2>
        <label for="name">Category Name:</label>
        <input type="text" name="name" required>
        <button type="submit">Add Category</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>