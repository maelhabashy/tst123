<?php
session_start();
include 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Modern Design */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        /* Navigation Bar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #0e0e0e;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar .logo {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
        }

        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar ul li {
            margin-left: 20px;
        }

        .navbar ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
        }

        .navbar ul li a:hover {
            text-decoration: underline;
        }

        /* Slideshow */
        .slideshow {
            width: 100%;
            height: 400px;
            overflow: hidden;
            position: relative;
        }

        .slideshow img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .slideshow img.active {
            opacity: 1;
        }

        /* Sections */
        .section {
            padding: 40px 20px;
            background-color: #fff;
            margin: 20px 0;
            border-radius: 10px;
            /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
        }

        .section h2 {
            font-size: 28px;
            margin-bottom: 24px;
            color: #333;
        }

        /* Book List */
        .book-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .book-card {
            background-color: #f5f8f9;
            border-radius: 10px;
            /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
            width: calc(25% - 49px);
            padding: 16px;
            text-align: center;
            border: 1px solid #dddddd;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .book-card img {
            width: 150px;
            /* Fixed width */
            height: 200px;
            /* Fixed height */
            object-fit: cover;
            /* Ensures the image covers the area without distortion */
            border-radius: 10px;
        }

        .book-card h3 {
            font-size: 18px;
            margin: 10px 0;
        }

        .book-card p {
            font-size: 14px;
            color: #555;
        }

        .book-card .btn {
            display: inline-block;
            padding: 16px 24px;
            background-color: #41CB5A;
            color: #fff;
            border-radius: 16px;
            text-decoration: none;
            margin-top: 10px;
        }

        .book-card .btn:hover {
            background-color: #0e0e0e;
        }

        /* Footer */
        footer {
            background-color: #0e0e0e;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: 40px;
        }



        /* Footer Styles */
        footer {
            background-color: #0e0e0e;
            color: #fff;
            padding: 40px 20px;
            font-family: 'Arial', sans-serif;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            justify-content: space-between;
        }

        .footer-section {
            flex: 1;
            min-width: 200px;
        }

        .footer-section h3 {
            font-size: 18px;
            margin-bottom: 20px;
            color: #1abc9c;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        .footer-section ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .footer-section ul li a:hover {
            color: #1abc9c;
        }

        .footer-section p {
            font-size: 14px;
            margin: 5px 0;
        }

        .social-links {
            display: flex;
            gap: 10px;
            align-items: center;
            justify-self: center;
        }

        .social-links a {
            color: #fff;
            font-size: 24px;
            transition: color 0.3s ease;
        }

        .social-links a:hover {
            color: #1abc9c;
        }

        .footer-bottom {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #34495e;
            font-size: 14px;
        }

        .footer-bottom a {
            color: #1abc9c;
            text-decoration: none;
        }

        .footer-bottom a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo">
            <img src="img/Logo.png" alt="Logo" width="100" height="100" title="Online Library" />
        </div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="books.php">Books</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="user-profile.php">User Profile</a></li>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li><a href="./admin/index.php">Admin Dashboard</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <!-- Slideshow -->
    <div class="slideshow">
        <img src="img/slide1.jpg" alt="Slide 1" class="active">
        <img src="img/slide2.jpg" alt="Slide 2">
        <img src="img/slide3.jpg" alt="Slide 3">
    </div>

    <!-- Last Borrowed Books Section -->
    <section class="section">
        <h2>Last Borrowed Books</h2>
        <div class="book-list">
            <?php
            $sql = "SELECT books.id, books.title, books.image, authors.name AS author_name 
                    FROM borrowings 
                    JOIN books ON borrowings.book_id = books.id 
                    JOIN authors ON books.author_id = authors.id 
                    ORDER BY borrowings.borrow_date DESC 
                    LIMIT 4";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()): ?>
                <div class="book-card">
                    <img src="img/<?= $row['image'] ?>" alt="<?= $row['title'] ?>">
                    <h3><?= $row['title'] ?></h3>
                    <p>Author: <?= $row['author_name'] ?></p>
                    <a href="book-details.php?id=<?= $row['id'] ?>" class="btn">View Details</a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- Featured Books Section -->
    <section class="section">
        <h2>Featured Books</h2>
        <div class="book-list">
            <?php
            $sql = "SELECT books.id, books.title, books.image, authors.name AS author_name 
                    FROM books 
                    JOIN authors ON books.author_id = authors.id 
                    LIMIT 4";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()): ?>
                <div class="book-card">
                    <img src="img/<?= $row['image'] ?>" alt="<?= $row['title'] ?>">
                    <h3><?= $row['title'] ?></h3>
                    <p>Author: <?= $row['author_name'] ?></p>
                    <a href="book-details.php?id=<?= $row['id'] ?>" class="btn">View Details</a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>




    <!-- Your page content goes here -->

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <!-- Quick Links -->
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="books.php">Books</a></li>
                    <li><a href="user-profile.php">User Profile</a></li>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): ?>
                        <li><a href="./admin/index.php">Admin Dashboard</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Contact Information -->
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p>Email: support@onlinelibrary.com</p>
                <p>Phone: +1 (123) 456-7890</p>
                <p>Address: 123 Library St, Knowledge City</p>
            </div>

            <!-- Social Media Links -->
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-links">
                    <a href="https://facebook.com" target="_blank" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="https://twitter.com" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="https://instagram.com" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://linkedin.com" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            &copy; 2025 Online Library. All rights reserved. | <a href="privacy-policy.php">Privacy Policy</a> | <a href="terms-of-service.php">Terms of Service</a>
        </div>
    </footer>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Slideshow Script -->
    <script>
        const slideshow = document.querySelector('.slideshow');
        const images = slideshow.querySelectorAll('img');
        let currentIndex = 0;

        function showNextImage() {
            images[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % images.length;
            images[currentIndex].classList.add('active');
        }

        setInterval(showNextImage, 3000); // Change image every 3 seconds
    </script>
</body>

</html>