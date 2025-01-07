<?php
include 'includes/auth.php';
requireAdmin(); // Ensure only admins can access this page
include 'includes/header.php';
include 'includes/sidebar.php';
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $bio = $conn->real_escape_string($_POST['bio']);

    // Insert the new author into the database
    $sql = "INSERT INTO authors (name, bio) VALUES ('$name', '$bio')";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Author added successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>
<head>
    <style>
        form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 5px 10px 100px 50px;
}
    </style>
</head>
<div class="main-content">
    <h2>Add Author</h2>
    <form method="POST">
        <label class="form-label" for="name">Author Name:</label>
        <input class="form-control" type="text" name="name" required>
        
        <label class="form-label" for="bio">Biography:</label>
        <textarea name="bio" rows="5" required></textarea>
        
        <button type="submit">Add Author</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>