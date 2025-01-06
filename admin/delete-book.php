<?php
include 'includes/auth.php';
requireAdmin(); // Ensure only admins can access this page
include '../includes/db.php';

$id = $_GET['id']; // Get the book ID from the URL

// Delete the book from the database
$sql = "DELETE FROM books WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    header("Location: list-books.php"); // Redirect to the list of books
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>