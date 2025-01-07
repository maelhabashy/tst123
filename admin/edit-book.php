<?php
include 'includes/auth.php';
requireAdmin(); // Ensure only admins can access this page
include 'includes/header.php';
include 'includes/sidebar.php';
include '../includes/db.php';

$id = $_GET['id']; // Get the book ID from the URL

// Fetch the book details
$sql = "SELECT books.id, books.title, books.author_id, books.category_id, books.description, books.image, books.publication_date, books.isbn 
        FROM books 
        WHERE books.id = $id";
$result = $conn->query($sql);
$book = $result->fetch_assoc();

// Fetch all authors and categories for the dropdowns
$authors = $conn->query("SELECT id, name FROM authors");
$categories = $conn->query("SELECT id, name FROM categories");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $author_id = $conn->real_escape_string($_POST['author_id']);
    $category_id = $conn->real_escape_string($_POST['category_id']);
    $description = $conn->real_escape_string($_POST['description']);
    $publication_date = $conn->real_escape_string($_POST['publication_date']);
    $isbn = $conn->real_escape_string($_POST['isbn']);

    // Handle image upload
    $image = $book['image']; // Default to the existing image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../img/'; // Directory to store uploaded images
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);

        // Check if the file is an image
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowedTypes)) {
            // Move the uploaded file to the img folder
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $image = basename($_FILES['image']['name']); // Save the file name in the database
            } else {
                echo "<p>Error uploading image.</p>";
            }
        } else {
            echo "<p>Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.</p>";
        }
    }

    // Update the book in the database
    $sql = "UPDATE books 
            SET title = '$title', author_id = $author_id, category_id = $category_id, description = '$description', image = '$image', publication_date = '$publication_date', isbn = '$isbn' 
            WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Book updated successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>
<head>
    <style>
        .main-content {
    margin-left: 305px; /* Same as sidebar width */
    padding: 20px;
    height: 1100px;
}
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 5px 5px 70px 55px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], input[type="date"], textarea, select, input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #41CB5A;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0e0e0e;
        }
        .current-image {
            margin-bottom: 16px;
        }
        .current-image img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>
<div class="main-content">
    <h2>Edit Book</h2>
    <form method="POST" enctype="multipart/form-data">
        <label class="form-label" for="title">Title:</label>
        <input class="form-control" type="text" name="title" value="<?= $book['title'] ?>" required>
        
        <label class="form-label" for="author_id">Author:</label>
        <select class="form-select" name="author_id" required>
            <?php while ($author = $authors->fetch_assoc()): ?>
                <option value="<?= $author['id'] ?>" <?= $author['id'] == $book['author_id'] ? 'selected' : '' ?>>
                    <?= $author['name'] ?>
                </option>
            <?php endwhile; ?>
        </select>
        
        <label class="form-label" for="category_id">Category:</label>
        <select class="form-select" name="category_id" required>
            <?php while ($category = $categories->fetch_assoc()): ?>
                <option value="<?= $category['id'] ?>" <?= $category['id'] == $book['category_id'] ? 'selected' : '' ?>>
                    <?= $category['name'] ?>
                </option>
            <?php endwhile; ?>
        </select>
        
        <label class="form-label" for="description">Description:</label>
        <textarea name="description" rows="5" required><?= $book['description'] ?></textarea>
        
        <label class="form-label" for="publication_date">Publication Date:</label>
        <input class="form-control" type="date" name="publication_date" value="<?= $book['publication_date'] ?>" required>
        
        <label class="form-label" for="isbn">ISBN:</label>
        <input class="form-control" type="text" name="isbn" value="<?= $book['isbn'] ?>" required>
        
        <div class="current-image">
            <label class="form-label">Current Image:</label>
            <img src="../img/<?= $book['image'] ?>" alt="<?= $book['title'] ?>">
        </div>
        
        <label class="form-label" for="image">Upload New Image:</label>
        <input class="form-control" type="file" name="image" accept="image/*">
        
        <button type="submit">Update Book</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>