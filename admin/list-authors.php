<?php
include 'includes/auth.php';
requireAdmin(); // Ensure only admins can access this page
include 'includes/header.php';
include 'includes/sidebar.php';
include '../includes/db.php';

// Fetch all authors
$sql = "SELECT id, name, bio FROM authors";
$result = $conn->query($sql);

// Handle author deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM authors WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<p>Author deleted successfully!</p>";
        // Refresh the page to reflect the changes
        header("Location: list-authors.php");
        exit();
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>
<div class="main-content">
    <h2>List of Authors</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Biography</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['bio'] ?></td>
                    <td class="action-buttons">
                        <a href="delete-author.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Are you sure you want to delete this author?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include 'includes/footer.php'; ?>