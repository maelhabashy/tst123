<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session only if it's not already active
}

// Redirect to login if user is not logged in
function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }
}

// Redirect to login if user is not an admin
function requireAdmin() {
    requireLogin(); // Ensure the user is logged in
    if ($_SESSION['role'] !== 'admin') {
        header("Location: ../login.php");
        exit();
    }
}
function requireAdmin() {
    requireLogin(); // Ensure the user is logged in
    if ($_SESSION['role'] !== 'admin') {
        header("Location: ../login.php");
        exit();
    }
}
?>