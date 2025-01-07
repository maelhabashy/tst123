<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';
?>

<!-- Slideshow -->
<div class="slideshow">
    <img src="img/slide1.jpg" alt="Slide 1" class="active">
    <img src="img/slide2.jpg" alt="Slide 2">
    <img src="img/slide3.jpg" alt="Slide 3">
</div>

<!-- Last Borrowed Books Section -->
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Last Borrowed Books</h2>
            </div>
            <?php
            $sql = "SELECT books.id, books.title, books.image, authors.name AS author_name 
                            FROM borrowings 
                            JOIN books ON borrowings.book_id = books.id 
                            JOIN authors ON books.author_id = authors.id 
                            ORDER BY borrowings.borrow_date DESC 
                            LIMIT 4";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()): ?>
                <div class="col-12 col-lg-3">
                    <div class="book-card">

                        <img src="img/<?= $row['image'] ?>" alt="<?= $row['title'] ?>">
                        <h3><?= $row['title'] ?></h3>
                        <p>Author: <?= $row['author_name'] ?></p>
                        <a href="book-details.php?id=<?= $row['id'] ?>" class="btn">View Details</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Featured Books Section -->
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Featured Books</h2>
            </div>
            <?php
            $sql = "SELECT books.id, books.title, books.image, authors.name AS author_name 
                        FROM books 
                        JOIN authors ON books.author_id = authors.id 
                        LIMIT 4";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()): ?>
                <div class="col-12 col-lg-3">
                    <div class="book-card">
                        <img src="img/<?= $row['image'] ?>" alt="<?= $row['title'] ?>">
                        <h3><?= $row['title'] ?></h3>
                        <p>Author: <?= $row['author_name'] ?></p>
                        <a href="book-details.php?id=<?= $row['id'] ?>" class="btn">View Details</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>


</section>




<!-- Your page content goes here -->

<?php
include 'includes/footer.php';
?>
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