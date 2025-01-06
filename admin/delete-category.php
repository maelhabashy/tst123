<?php
include 'includes/auth.php';
requireAdmin(); // Ensure only admins can access this page
include '../includes/db.php';

$id = $_GET['id']; // Get the category ID from the URL

// Delete the category from the database
$sql = "DELETE FROM categories WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    header("Location: list-categories.php"); // Redirect to the list of categories
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>