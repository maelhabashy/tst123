<?php
session_start();
include 'includes/db.php';

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Online Library</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Sliding Navigation Bar -->
    <nav class="navbar">
    <div class="logo"> <img src="img/Logo.png" alt="Logo" width="100" height="100" title="Online Library" /> </div>
    <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="books.php">Books</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="user-profile.php">User Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <!-- Login Form -->
    <section class="auth-form">
        <div class="form-container">
            <h2>Login</h2>
            <?php if (isset($error)): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>
            <form method="POST">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                
                <label for="password">Password:</label>
                <input type="password" name="password" required>
                
                <button type="submit" class="btn">Login</button>
            </form>
            <p class="note">Don't have an account? <a href="register.php">Register here</a>.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Online Library. All rights reserved.</p>
    </footer>
</body>
</html>