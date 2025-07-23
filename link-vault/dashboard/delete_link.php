<?php
session_start();
require_once '../db/connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $user_id = $_SESSION['user_id'];

    if ($id) {
        $stmt = $db->prepare("DELETE FROM links WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);
    }
}

header("Location: dashboard.php");
exit;