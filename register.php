<?php
session_start();
include 'includes/db.php';

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Online Library</title>
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
    <!-- Register Form -->
    <section class="auth-form">
        <div class="form-container">
            <h2>Register</h2>
            <?php if (isset($error)): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>
            <form method="POST">
                <label for="username">Username:</label>
                <input type="text" name="username" required>
                
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                
                <label for="password">Password:</label>
                <input type="password" name="password" required>
                
                <button type="submit" class="btn">Register</button>
            </form>
            <p class="note">Already have an account? <a href="login.php">Login here</a>.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Online Library. All rights reserved.</p>
    </footer>
</body>
</html>