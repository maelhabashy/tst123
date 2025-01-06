<?php
include 'includes/auth.php';
requireAdmin(); // Ensure only admins can access this page
include 'includes/header.php';
include 'includes/sidebar.php';
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $conn->real_escape_string($_POST['role']);

    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
    if ($conn->query($sql) === TRUE) {
        echo "<p>User added successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>
<head>
    <style>
        .form-container {
    max-width: 600px;
    height: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
    </style>
</head>
<div class="main-content">
    <div class="form-container">
        <h2>Add User</h2>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            
            <label for="role">Role:</label>
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            
            <button type="submit">Add User</button>
        </form>
        <p class="note">Already have an account? <a href="../login.php">Login here</a>.</p>
    </div>
</div>
<?php include 'includes/footer.php'; ?>