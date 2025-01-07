<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, username, password FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<div class="section">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-lg-4">
                <section class="auth-form">
                    <div class="form-container">
                        <h2>Login</h2>
                        <?php if (isset($error)): ?>
                            <p class="error"><?= $error ?></p>
                        <?php endif; ?>
                        <form method="POST" class="d-flex flex-column ">
                            <label class="form-label" for="email">Email:</label>
                            <input class="form-control" type="email" name="email" required>
                            
                            <label class="form-label" for="password">Password:</label>
                            <input class="form-control" type="password" name="password" required>
                            
                            <button type="submit" class="btn">Login</button>
                        </form>
                        <p class="note">Don't have an account? <a href="register.php">Register here</a>.</p>
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