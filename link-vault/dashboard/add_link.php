<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../db/connect.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $url = trim($_POST['url']);

    if (!$title || !$url) {
        $error = "Both title and URL are required.";
    } else {
        $stmt = $db->prepare("INSERT INTO links (user_id, title, url) VALUES (?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $title, $url]);
        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <title>Add Link | LinkVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen px-4">

    <div class="bg-gray-800 p-8 rounded-xl shadow-xl w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">🔗 Save a New Link</h2>

        <?php if ($error): ?>
            <div class="bg-red-500 text-white p-3 rounded mb-4"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">
            <div>
                <label class="block mb-1 text-sm font-medium">Title</label>
                <input type="text" name="title" required class="w-full px-4 py-2 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium">URL</label>
                <input type="url" name="url" required class="w-full px-4 py-2 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 transition text-white font-semibold py-2 px-4 rounded">
                Save Link
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="dashboard.php" class="text-sm text-indigo-400 hover:underline">← Back to Dashboard</a>
        </div>
    </div>

</body>
</html>