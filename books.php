<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

// Search and Filter Logic
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';

// Base SQL Query
$sql = "SELECT books.id, books.title, books.image, authors.name AS author_name, categories.name AS category_name 
        FROM books 
        JOIN authors ON books.author_id = authors.id 
        JOIN categories ON books.category_id = categories.id 
        WHERE books.title LIKE '%$search%'";

// Add Category Filter if Selected
if (!empty($category)) {
    $sql .= " AND categories.name = '$category'";
}

// Pagination Logic
$results_per_page = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $results_per_page;

// Fetch Total Number of Books
$total_books_sql = str_replace("SELECT books.id, books.title, books.image, authors.name AS author_name, categories.name AS category_name", "SELECT COUNT(*) as total", $sql);
$total_books_result = $conn->query($total_books_sql);
$total_books = $total_books_result->fetch_assoc()['total'];
$total_pages = ceil($total_books / $results_per_page);

// Fetch Books for Current Page
$sql .= " LIMIT $results_per_page OFFSET $offset";
$result = $conn->query($sql);

// Fetch Categories for Filter Dropdown
$categories_sql = "SELECT * FROM categories";
$categories_result = $conn->query($categories_sql);
?>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>All Books</h2>
            </div>
            <div class="col-12">
                <div class="search-filter">
                    <form method="GET" action="books.php">
                        <input class="form-control" type="text" name="search" placeholder="Search by title" value="<?= htmlspecialchars($search) ?>">
                        <select class="form-select" name="category">
                            <option value="">All Categories</option>
                            <?php while ($category_row = $categories_result->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($category_row['name']) ?>" <?= $category === $category_row['name'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category_row['name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <button type="submit" class="btn">Search</button>
                    </form>
                </div>
            </div>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-12 col-lg-3">
                        <div class="book-card">
                            <img src="img/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                            <h3><?= htmlspecialchars($row['title']) ?></h3>
                            <p>Author: <?= htmlspecialchars($row['author_name']) ?></p>
                            <p>Category: <?= htmlspecialchars($row['category_name']) ?></p>
                            <a href="book-details.php?id=<?= $row['id'] ?>" class="btn">View Details</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No books found.</p>
            <?php endif; ?>
            <div class="col-12">
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="books.php?page=<?= $i ?>&search=<?= $search ?>&category=<?= $category ?>" <?= $page === $i ? 'class="active"' : '' ?>><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php
include 'includes/footer.php';

?>
</body>

</html>