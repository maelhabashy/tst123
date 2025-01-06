<?php
session_start();
include '../includes/db.php';

// Handle Login Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, username, password, role FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
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
    <title>Admin Login - Online Library</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        /* Modern Design */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .login-container p {
            font-size: 14px;
            color: #555;
            margin-bottom: 30px;
        }

        .login-container .error {
            color: #dc3545;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-container input:focus {
            border-color: #41CB5A;
            outline: none;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            background-color: #41CB5A;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #0e0e0e;
        }

        .login-container .register-link {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        .login-container .register-link a {
            color: #41CB5A;
            text-decoration: none;
        }

        .login-container .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Login Container -->
    <div class="login-container">
        <h2>Admin Login</h2>
        <p>Welcome back! Please log in to access the admin dashboard.</p>

        <!-- Display Error Message -->
        <?php if (isset($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Log In</button>
        </form>

        <!-- Register Link -->
        <p class="register-link">Don't have an account? <a href="../register.php">Register here</a></p>
    </div>
</body>
</html>