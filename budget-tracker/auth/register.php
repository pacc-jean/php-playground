<?php
require '../db/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!$username || !$email || !$password) {
        echo "All fields required.";
        exit;
    }

    // Check for existing username or email
    $checkStmt = $db->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $checkStmt->execute([$username, $email]);

    if ($checkStmt->fetch()) {
        echo "Username or email already exists.";
        exit;
    }

    // Hash password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

    try {
        $stmt->execute([$username, $email, $hashed]);
        header("Location: login.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!-- Minimal form -->
<form method="POST" action="register.php">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Register</button>
</form>