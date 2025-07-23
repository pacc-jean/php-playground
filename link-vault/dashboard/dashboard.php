<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../db/connect.php';

$user_id = $_SESSION['user_id'];

$stmt = $db->prepare("SELECT id, title, url, created_at FROM links WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$links = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | LinkVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen transition">

    <header class="bg-white dark:bg-gray-800 shadow p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-indigo-600 dark:text-indigo-400">📂 LinkVault Dashboard</h1>
        <div class="flex gap-3 items-center">
            <button id="toggleDark" class="px-2 py-1 border rounded text-sm border-gray-400 dark:border-gray-600">🌓</button>
            <a href="../auth/logout.php" class="text-sm text-red-500 hover:underline">Logout</a>
        </div>
    </header>

    <main class="max-w-3xl mx-auto mt-10">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Your Links</h2>
            <a href="add_link.php" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">+ Add New</a>
        </div>

        <?php if (count($links) === 0): ?>
            <p class="text-gray-500 dark:text-gray-400">No links saved yet. Start by adding one!</p>
        <?php else: ?>
            <ul class="space-y-4">
                <?php foreach ($links as $link): ?>
                    <li class="bg-white dark:bg-gray-800 p-4 rounded shadow hover:shadow-md transition">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-bold"><?= htmlspecialchars($link['title']) ?></h3>
                                <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" class="text-sm text-indigo-600 dark:text-indigo-300 underline">
                                    <?= htmlspecialchars($link['url']) ?>
                                </a>
                            </div>
                            <button onclick="copyToClipboard('<?= htmlspecialchars($link['url']) ?>')" class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                Copy
                            </button>
                            <a href="edit_link.php?id=<?= $link['id'] ?>" class="text-sm text-yellow-400 hover:underline">Edit</a>
                            <form method="POST" action="delete_link.php" onsubmit="return confirm('Delete this link?');">
                                <input type="hidden" name="id" value="<?= $link['id'] ?>">
                                <button type="submit" class="text-sm text-red-500 hover:underline">Delete</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </main>

    <script>
        const toggleBtn = document.getElementById('toggleDark');
        const html = document.documentElement;
        if (localStorage.getItem('theme') === 'dark') html.classList.add('dark');

        toggleBtn.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
        });

        function copyToClipboard(url) {
            navigator.clipboard.writeText(url).then(() => {
                alert('Link copied!');
            });
        }
    </script>

</body>
</html>