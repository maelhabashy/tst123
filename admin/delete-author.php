<?php
include 'includes/auth.php';
requireAdmin(); // Ensure only admins can access this page
include '../includes/db.php';

$id = $_GET['id']; // Get the author ID from the URL

// Delete the author from the database
$sql = "DELETE FROM authors WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    header("Location: list-authors.php"); // Redirect to the list of authors
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>