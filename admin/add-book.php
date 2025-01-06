<?php
include 'includes/auth.php';
requireAdmin(); // Ensure only admins can access this page
include 'includes/header.php';
include 'includes/sidebar.php';
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $author_id = $conn->real_escape_string($_POST['author_id']);
    $category_id = $conn->real_escape_string($_POST['category_id']);
    $description = $conn->real_escape_string($_POST['description']);
    $publication_date = $conn->real_escape_string($_POST['publication_date']);
    $isbn = $conn->real_escape_string($_POST['isbn']);

    // Handle image upload
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
                $image = ''; // No image uploaded
            }
        } else {
            echo "<p>Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.</p>";
            $image = ''; // No image uploaded
        }
    } else {
        $image = ''; // No image uploaded
    }

    // Insert the new book into the database
    $sql = "INSERT INTO books (title, author_id, category_id, description, image, publication_date, isbn) 
            VALUES ('$title', $author_id, $category_id, '$description', '$image', '$publication_date', '$isbn')";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Book added successfully!</p>";
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
            margin: 5px 5px 70px 55px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], input[type="date"], textarea, select {
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
    </style>
</head>
<div class="main-content">
    <h2>Add Book</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" required>
        
        <label for="author_id">Author:</label>
        <select name="author_id" required>
            <?php
            $authors = $conn->query("SELECT id, name FROM authors");
            while ($author = $authors->fetch_assoc()): ?>
                <option value="<?= $author['id'] ?>"><?= $author['name'] ?></option>
            <?php endwhile; ?>
        </select>
        
        <label for="category_id">Category:</label>
        <select name="category_id" required>
            <?php
            $categories = $conn->query("SELECT id, name FROM categories");
            while ($category = $categories->fetch_assoc()): ?>
                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php endwhile; ?>
        </select>
        
        <label for="description">Description:</label>
        <textarea name="description" rows="5" required></textarea>
        
        <label for="publication_date">Publication Date:</label>
        <input type="date" name="publication_date" required>
        
        <label for="isbn">ISBN:</label>
        <input type="text" name="isbn" required>
        
        <label for="image">Book Cover Image:</label>
        <input type="file" name="image" accept="image/*">
        
        <button type="submit">Add Book</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>