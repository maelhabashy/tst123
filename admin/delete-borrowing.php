<?php
include 'includes/auth.php';
requireAdmin(); // Ensure only admins can access this page
include '../includes/db.php';

$id = $_GET['id']; // Get the borrowing ID from the URL

// Delete the borrowing from the database
$sql = "DELETE FROM borrowings WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    header("Location: borrow-details.php"); // Redirect to the list of borrowings
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>