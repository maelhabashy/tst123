<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>
<div class="section">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-lg-4">
                <!-- Register Form -->
                <section class="auth-form">
                    <div class="form-container">
                        <h2>Register</h2>
                        <?php if (isset($error)): ?>
                            <p class="error"><?= $error ?></p>
                        <?php endif; ?>
                        <form method="POST" class="d-flex flex-column ">
                            <label class="form-label" for="username">Username:</label>
                            <input class="form-control" type="text" name="username" required>

                            <label class="form-label" for="email">Email:</label>
                            <input class="form-control" type="email" name="email" required>

                            <label class="form-label" for="password">Password:</label>
                            <input class="form-control" type="password" name="password" required>

                            <button type="submit" class="btn">Register</button>
                        </form>
                        <p class="note">Already have an account? <a href="login.php">Login here</a>.</p>
                    </div>
                </section>

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