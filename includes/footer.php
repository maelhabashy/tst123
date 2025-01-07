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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="js/script.js"></script>
</body>
</html>