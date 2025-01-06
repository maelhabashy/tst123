<?php
include 'includes/auth.php';
requireAdmin(); // Ensure only admins can access this page
include 'includes/header.php';
include 'includes/sidebar.php';
include '../includes/db.php';

// Pagination Logic
$results_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $results_per_page;

// Search Logic
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Base SQL Query
$sql = "SELECT books.id, books.title, authors.name AS author, categories.name AS category, books.description 
        FROM books 
        JOIN authors ON books.author_id = authors.id 
        JOIN categories ON books.category_id = categories.id 
        WHERE books.title LIKE '%$search%' OR authors.name LIKE '%$search%' OR categories.name LIKE '%$search%' 
        LIMIT $results_per_page OFFSET $offset";
$result = $conn->query($sql);

// Fetch Total Number of Books for Pagination
$total_books_sql = "SELECT COUNT(*) as total FROM books 
                    JOIN authors ON books.author_id = authors.id 
                    JOIN categories ON books.category_id = categories.id 
                    WHERE books.title LIKE '%$search%' OR authors.name LIKE '%$search%' OR categories.name LIKE '%$search%'";
$total_books_result = $conn->query($total_books_sql);
$total_books = $total_books_result->fetch_assoc()['total'];
$total_pages = ceil($total_books / $results_per_page);
?>
<head>
    <style>
        /* Table Styles */
        table {
            width: 90%;
            border-collapse: collapse;

            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #41CB5A;
            color: #fff;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .action-buttons a {
            padding: 5px 10px;
            margin: 2px;
            border-radius: 4px;
            text-decoration: none;
            color: #fff;
        }
        .action-buttons .update {
            background-color: #28a745;
        }
        .action-buttons .delete {
            background-color: #dc3545;
        }
        .action-buttons a:hover {
            opacity: 0.8;
        }

        /* Search Bar */
        .search-bar {
            margin-bottom: 20px;
        }
        .search-bar input {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .search-bar button {
            padding: 10px 20px;
            background-color: #41CB5A;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-bar button:hover {
            background-color: #0e0e0e;
        }

        /* Pagination */
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            padding: 10px 15px;
            margin: 0 5px;
            background-color: #41CB5A;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
        }
        .pagination a:hover {
            background-color: #0e0e0e;
        }
        .pagination .active {
            background-color: #0e0e0e;
        }
        .main-content {
    margin-left: 305px;
    padding: 20px;
    height: 1100px;
}
    </style>
</head>
<div class="main-content">
    <h2>List of Books</h2>

    <!-- Search Bar -->
    <div class="search-bar">
        <form method="GET" action="list-books.php">
            <input type="text" name="search" placeholder="Search by title, author, or category" value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Books Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['title'] ?></td>
                        <td><?= $row['author'] ?></td>
                        <td><?= $row['category'] ?></td>
                        <td><?= $row['description'] ?></td>
                        <td class="action-buttons">
                            <a href="edit-book.php?id=<?= $row['id'] ?>" class="update">Update</a>
                            <a href="delete-book.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Are you sure you want to delete this book?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No books found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="list-books.php?page=<?= $i ?>&search=<?= $search ?>" <?= $page === $i ? 'class="active"' : '' ?>><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>