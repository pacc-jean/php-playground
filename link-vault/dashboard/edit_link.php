<?php
session_start();
require_once '../db/connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$link_id = $_GET['id'] ?? null;

if (!$link_id) {
    header("Location: dashboard.php");
    exit;
}

$stmt = $db->prepare("SELECT * FROM links WHERE id = ? AND user_id = ?");
$stmt->execute([$link_id, $user_id]);
$link = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$link) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $url = trim($_POST['url']);

    if (!$title || !$url) {
        $error = "Title and URL are required.";
    } else {
        $stmt = $db->prepare("UPDATE links SET title = ?, url = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$title, $url, $link_id, $user_id]);
        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <title>Edit Link | LinkVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script> tailwind.config = { darkMode: 'class' } </script>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen px-4">

<div class="bg-gray-800 p-8 rounded-xl shadow-xl w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Edit Link</h2>

    <?php if ($error): ?>
        <div class="bg-red-500 text-white p-3 rounded mb-4"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-5">
        <div>
            <label class="block mb-1 text-sm font-medium">Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($link['title']) ?>" required class="w-full px-4 py-2 rounded bg-gray-700 border border-gray-600 focus:ring-2 focus:ring-indigo-500" />
        </div>
        <div>
            <label class="block mb-1 text-sm font-medium">URL</label>
            <input type="url" name="url" value="<?= htmlspecialchars($link['url']) ?>" required class="w-full px-4 py-2 rounded bg-gray-700 border border-gray-600 focus:ring-2 focus:ring-indigo-500" />
        </div>
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
            Save Changes
        </button>
    </form>

    <div class="mt-6 text-center">
        <a href="dashboard.php" class="text-sm text-indigo-400 hover:underline">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>