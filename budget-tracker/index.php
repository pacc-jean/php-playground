<?php
session_start();

// Redirect if user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Budget Tracker</title>
</head>
<body>
    <h1>Welcome to Budget Tracker</h1>
    
    <p><a href="auth/register.php">Register</a></p>
    <p><a href="auth/login.php">Login</a></p>
</body>
</html>