<?php
include 'includes/auth.php';
requireAdmin(); // Ensure only admins can access this page
include 'includes/header.php';
include 'includes/sidebar.php';
include '../includes/db.php';

// Fetch all categories
$sql = "SELECT id, name FROM categories";
$result = $conn->query($sql);

// Handle category deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM categories WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<p>Category deleted successfully!</p>";
        // Refresh the page to reflect the changes
        header("Location: list-categories.php");
        exit();
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>
<div class="main-content">
    <h2>List of Categories</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td class="action-buttons">
                        <a href="delete-category.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include 'includes/footer.php'; ?>